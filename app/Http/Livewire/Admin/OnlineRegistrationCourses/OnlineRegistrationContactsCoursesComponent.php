<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses;

use App\Contact;
use App\ContactsCourse;
use App\Jobs\NewSendEmailJob;
use App\Models\ContactsInformationForm;
use App\Models\InformationForm;
use App\Models\OnlineRegistration;
use App\Models\OnlineRegistrationCharacterization;
use App\Models\OnlineRegistrationContactCourse;
use App\Models\OnlineRegistrationContactTest;
use App\Models\OnlineRegistrationContentProgress;
use App\Models\OnlineRegistrationCourse;
use App\Models\OnlineRegistrationForm;
use App\Models\OnlineRegistrationFormAnswer;
use App\Models\OnlineRegistrationSessionAttendee;
use App\Models\OrAssignedCharacterization;
use App\Models\OrCharacterizationAnswer;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class OnlineRegistrationContactsCoursesComponent extends Component
{

    use WithFileUploads, WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $online_registration_course_id, $formId;

    public $searchName;

    public $feedback;
    public $form;
    public $contactId;
    public $orCourseId;
    public $certificateDate;

    public $nit,
        $name,
        $phone,
        $email,
        $whatsapp,
        $website,
        $contact_person_name;

    //File to import contacts
    public $filePostulates, $imports;

    public $onlineRegistrationContactCourse;
    public $course;
    //Failures import file
    public $failures;
    public $preview;

    public $HasOnlineRegistrationContactCourse = false;

    public $sortField = 'id';
    public $sortDirection = 'asc';

    public $user_created_at,  $user_updated_at;

    public  $isRegisterForm = false;


    public function mount($id)
    {
        $this->online_registration_course_id = $id;
        $form = OnlineRegistrationForm::where('online_registration_course_id', $this->online_registration_course_id)->firstOrFail();
        $this->formId = $form->id;
    }

    public function render()
    {
        $form = OnlineRegistrationForm::findOrFail($this->formId);
        $questions = $form->questions;
        $query = OnlineRegistrationContactCourse::with('contact')->where('or_course_id', $this->online_registration_course_id);

        if ($this->searchName) {
            $query->whereHas('contact', function ($q) {
                $q->where('name', 'like', '%' . $this->searchName . '%')
                    ->orWhere('email', 'like', '%' . $this->searchName . '%')
                    ->orWhere('nit', 'like', '%' . $this->searchName . '%');
            });
        }
        if ($this->sortField) {
            $query->whereHas('contact', function ($q) {
                $q->orderBy($this->sortField, $this->sortDirection);
            });
        }

        $onlineRegistrationContactsCourse = $query->paginate(25);

        return view('livewire.admin.online-registration-courses.online-registration-contacts-courses-component', [
            'form' => $form,
            'questions' => $questions,
            'onlineRegistrationContactsCourse' => $onlineRegistrationContactsCourse,
            'onlineRegistrationCourse' => $form->onlineRegistrationCourse
        ]);
    }

    public function toggleApproval($id)
    {
        $onlineRegistrationContactCourse = OnlineRegistrationContactCourse::findOrFail($id);
        $onlineRegistrationContactCourse->update(['certificate' => !$onlineRegistrationContactCourse->certificate]);

        $message = $onlineRegistrationContactCourse->certificate ? 'Persona registrada certificada' : 'Persona registrada no certificada';
        $this->emit('alert', ['type' => $onlineRegistrationContactCourse->certificate ? 'success' : 'error', 'message' => $message]);
    }

    public function delete($id)
    {
        $this->contactId = $id;
    }

    public function destroy()
    {
        $contact = Contact::find($this->contactId);

        if ($contact) {
            //ELIMINACION DE INFORMACION DE REGISTRO
            $onlineRegistrationCourse = OnlineRegistrationCourse::find($this->online_registration_course_id);

            $testIds = [];

            foreach ($onlineRegistrationCourse->onlineRegistrationCourseSessions as $session) {
                foreach ($session->contents as $content) {
                    if ($content->type === 'T') {
                        $test = $content->test;

                        if ($test) {
                            $testIds[] = $test->id;
                        }
                    }
                }
            }

            // Si hay test IDs, borramos los registros
            if (!empty($testIds)) {
                OnlineRegistrationContactTest::where("contact_id", $this->contactId)
                    ->whereIn("or_test_id", $testIds)
                    ->delete();
            }

            if ($onlineRegistrationCourse) {
                OnlineRegistrationFormAnswer::where('contact_id', $this->contactId)
                    ->where('or_form_id', $onlineRegistrationCourse->form->id)
                    ->delete();
            }

            OnlineRegistrationContactCourse::where('contact_id', $this->contactId)
                ->where('or_course_id', $this->online_registration_course_id)
                ->delete();

            //ELIMINACION DE CARACTERIZACIONES

            $characterizationIds = $onlineRegistrationCourse->onlineRegistrationCourseSessions
                ->flatMap->characterizations
                ->pluck('id');

            // Eliminar todas las respuestas de caracterización para el contacto en este curso
            OrCharacterizationAnswer::where('contact_id', $this->contactId)
                ->whereIn('characterization_id', $characterizationIds)
                ->delete();

            // Eliminar todas las asignaciones de caracterización para el contacto en este curso
            OrAssignedCharacterization::where('contact_id', $this->contactId)
                ->whereIn('characterization_id', $characterizationIds)
                ->delete();


            OnlineRegistrationContentProgress::where('contact_id', $this->contactId)
                ->where('or_course_id', $this->online_registration_course_id)
                ->delete();

            $sessionIds = $onlineRegistrationCourse->onlineRegistrationCourseSessions->pluck('id');

            // Eliminar todos los asistentes asociados a ese contact_id y a las sesiones del curso
            OnlineRegistrationSessionAttendee::where('contact_id', $this->contactId)
                ->whereIn('session_id', $sessionIds)
                ->delete();

            $this->emit('alert', ['type' => 'success', 'message' => 'Registrado,caracterizaciones y respuestas del formulario eliminados correctamente']);
        } else {
            $this->emit('alert', ['type' => 'error', 'message' => 'No se pudo encontrar el registrado']);
        }

        $this->cancel();
    }

    public function store()
    {
        $this->validate([
            'nit' => 'required',
            'name' => 'required',
            'phone' => 'required|integer',
            'email' => 'required|email',
            'whatsapp' => 'integer|nullable',
            'website' => 'nullable',
            'contact_person_name' => 'required',
        ], [], [
            'nit' => 'NIT/Cédula',
            'name' => 'nombre',
            'phone' => 'teléfono',
            'email' => 'correo electrónico',
            'whatsapp' => 'whatsapp',
            'website' => 'sitio web',
            'contact_person_name' => 'nombre persona de contacto',
        ]);


        $existingContact = Contact::where('nit', $this->nit)->first();

        if ($existingContact) {

            $existingOnlineRegistrationContactCourse = OnlineRegistrationContactCourse::where('contact_id', $existingContact->id)
                ->where('or_course_id', $this->online_registration_course_id)
                ->first();

            if ($existingOnlineRegistrationContactCourse) {
                $this->emit('alert', ['type' => 'error', 'message' => 'El contacto ya está postulado en esta etapa.']);
                return;
            } else {

                $OnlineRegistrationContactCourse = new OnlineRegistrationContactCourse();
                $OnlineRegistrationContactCourse->contact_id = $existingContact->id;
                $OnlineRegistrationContactCourse->or_course_id = $this->online_registration_course_id;
                $OnlineRegistrationContactCourse->certificate_date = $this->certificateDate;
                $OnlineRegistrationContactCourse->save();

                $this->emit('alert', ['type' => 'success', 'message' => 'Postulado creado correctamente en la etapa.']);
                $this->cancel();
                return;
            }
        } else {

            $user = new User();
            $user->name = $this->name;
            $user->email = $this->email;
            $user->password = Hash::make($this->nit);
            $user->role_id = '7';
            $user->save();

            $contact = new Contact();
            $contact->nit = $this->nit;
            $contact->name = $this->name;
            $contact->phone = $this->phone;
            $contact->email = $this->email;
            $contact->whatsapp = $this->whatsapp;
            $contact->website = $this->website;
            $contact->contact_person_name = $this->contact_person_name;
            $contact->user_id = $user->id;
            $contact->storage = "form";
            $contact->save();

            $OnlineRegistrationContactCourse = new OnlineRegistrationContactCourse();
            $OnlineRegistrationContactCourse->contact_id = $contact->id;
            $OnlineRegistrationContactCourse->or_course_id = $this->orCourseId;
            $OnlineRegistrationContactCourse->certificate_date = $this->certificateDate;
            $OnlineRegistrationContactCourse->save();

            $this->emit('alert', ['type' => 'success', 'message' => 'Postulado creado correctamente.']);
            $this->cancel();
        }
    }
    public function edit($id)
    {
        $this->contactId = $id;


        $contact = Contact::findOrFail($id);
        $this->nit = $contact->nit;
        $this->name = $contact->name;
        $this->phone = $contact->phone;
        $this->email = $contact->email;
        $this->whatsapp = $contact->whatsapp;
        $this->website = $contact->website;
        $this->contact_person_name = $contact->contact_person_name;
    }

    public function update()
    {
        $this->validate([
            'nit' => 'required|unique:contacts,nit,' . $this->contactId,
            'name' => 'required',
            'phone' => 'required|integer',
            'email' => 'required',
            'whatsapp' => 'integer|nullable',
            'website' => 'nullable',
            'contact_person_name' => 'required',
        ], [], [
            'nit' => 'NIT',
            'name' => 'nombre',
            'phone' => 'teléfono',
            'email' => 'correo electrónico',
            'whatsapp' => 'whatsapp',
            'website' => 'sitio web',
            'contact_person_name' => 'nombre persona de contacto',
        ]);

        $contact = Contact::findOrFail($this->contactId);
        $contact->update([
            'nit' => $this->nit,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'whatsapp' => $this->whatsapp,
            'website' => $this->website,
            'contact_person_name' => $this->contact_person_name,
        ]);
        $user = User::findOrFail($contact->user_id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);


        $this->emit('alert', ['type' => 'success', 'message' => 'Postulado actualizado correctamente']);
        $this->cancel();
    }

    public function preview($course, $contactId)
    {
        $this->course = $course;
        $this->contactId = $contactId;

        $this->preview = OnlineRegistrationFormAnswer::where('or_form_id', $course)
            ->where('contact_id', $this->contactId)
            ->with('question.options', 'question.answers')
            ->get();
        // dd($this->preview);
    }



    public function feedback($id)
    {
        $contact = OnlineRegistrationContactCourse::findOrFail($id);
        $this->feedback = $contact->feedback;
        $this->contactId = $contact->id;
    }

    public function storeFeedback()
    {

        $this->validate([
            'feedback' => 'required',
        ]);

        $contact = OnlineRegistrationContactCourse::findOrFail($this->contactId);

        $contact->feedback =  $this->feedback;
        $contact->update();


        //Email
        $contact = Contact::find($this->contactId);
        $content = 'Hola ' . $contact->name . 'se ha registrado un feedback a la entrega del formulario.';
        NewSendEmailJob::dispatch($contact->email, 'Feedback Registro Formulario', $content);


        $this->emit('alert', ['type' => 'success', 'message' => 'Feedback agregado correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->feedback = '';
        $this->nit = '';
        $this->name = '';
        $this->phone = '';
        $this->email = '';
        $this->whatsapp = '';
        $this->website = '';
        $this->contact_person_name = '';
        $this->filePostulates = null;
        $this->contactId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }



    public function sortBy($field)
    {
        $this->sortDirection = ($this->sortField === $field && $this->sortDirection === 'asc') ? 'desc' : 'asc';
        $this->sortField = $field;
    }

    public function updatingSearchName()
    {
        $this->resetPage();
    }



    public function searchNit()
    {
        $this->validate([
            'nit' => 'required|string'
        ], [
            'nit.required' => 'El campo NIT/Cédula es obligatorio.'
        ]);

        try {
            $company = Contact::where('nit', $this->nit)->firstOrFail();

            $this->nit = $company->nit;
            $this->name = $company->name;
            $this->email = $company->email;
            $this->phone = $company->phone;
            $this->whatsapp = $company->whatsapp;
            $this->contact_person_name = $company->contact_person_name;
            $this->website = $company->website;

            $this->contactId = $company->id;

            $ContactCourse = ContactsCourse::where('contact_id', $company->id)->first();
            if ($ContactCourse !== null) {
                if ($ContactCourse->contact_id == $this->contactId) {
                    $this->HasOnlineRegistrationContactCourse = true;
                    $this->addError('OnlineRegistrationContactCourse', 'Ya se encuentra postulado a esta estrategia.');
                } else {
                    $this->HasOnlineRegistrationContactCourse = false;
                }
            } else {
                $this->HasOnlineRegistrationContactCourse = false;
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $this->name = '';
            $this->email = '';
            $this->phone = '';
            $this->whatsapp = '';
            $this->contact_person_name = '';
            $this->website = '';
            $this->contactId = '';

            $this->HasOnlineRegistrationContactCourse = false;
            $this->addError('nit', 'No existe registros con este NIT/Cédula.');
        }
    }
}
