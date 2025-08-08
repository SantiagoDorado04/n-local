<?php

namespace App\Http\Livewire\Admin\CourseRegistrationForms;

use App\Contact;
use App\Jobs\NewSendEmailJob;
use App\Models\ContactsCourseRegistrationForm;
use App\Models\ContactsInformationForm;
use App\Models\CourseRegistrationForm;
use App\Models\InformationForm;
use App\Models\InformationFormAnswer;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AttendeeRegistrationComponent extends Component
{

    use WithFileUploads, WithPagination;
    protected $paginationTheme = 'simple-bootstrap';
    public
        $course_registration_form_id,
        $formId;

    public
        $searchName;

    public $feedback;

    public $contactId;

    public $nit,
        $name,
        $phone,
        $email,
        $whatsapp,
        $website,
        $contact_person_name,
        $approved = 1;

    //File to import contacts
    public $filePostulates, $imports;

    //Failures import file
    public $failures;

    public $contactHasStage = false;

    public $sortField = 'id';
    public $sortDirection = 'asc';

    public function mount($id)
    {
        $this->course_registration_form_id = $id;
        $form = InformationForm::where('course_registration_form_id', $this->course_registration_form_id)->firstOrFail();
        $this->formId = $form->id;
    }

    public function render()
    {
        $form = InformationForm::findOrFail($this->formId);
        $questions = $form->questions;
        $query = ContactsCourseRegistrationForm::with('contact')->where('course_registration_form_id', $this->course_registration_form_id);

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

        $contactsCourseRegistrationForm = $query->paginate(25);

        return view('livewire..admin.course-registration-forms.attendee-registration-component', [
            'form' => $form,
            'questions' => $questions,
            'contactsCourseRegistrationForm' => $contactsCourseRegistrationForm,
            'courseRegistrationForm' => $form->courseRegistrationForm
        ]);
    }
    public function toggleApproval($id)
    {
        $contactCourseRegistrationForm = ContactsCourseRegistrationForm::findOrFail($id);
        $contactCourseRegistrationForm->update(['approved' => !$contactCourseRegistrationForm->approved]);

        $message = $contactCourseRegistrationForm->approved ? 'Persona registrada asistió' : 'Persona registrada no asistió';
        $this->emit('alert', ['type' => $contactCourseRegistrationForm->approved ? 'success' : 'error', 'message' => $message]);
    }

    public function delete($id)
    {
        $this->contactId = $id;
    }

    public function destroy()
    {
        $contact = Contact::find($this->contactId);

        if ($contact) {
            $courseRegistrationForm = CourseRegistrationForm::find($this->course_registration_form_id);

            if ($courseRegistrationForm) {
                InformationFormAnswer::where('contact_id', $this->contactId)
                    ->where('information_form_id', $courseRegistrationForm->form->id)
                    ->delete();
            }

            ContactsCourseRegistrationForm::where('contact_id', $this->contactId)
                ->where('course_registration_form_id', $this->course_registration_form_id)
                ->delete();

            $this->emit('alert', ['type' => 'success', 'message' => 'Asistente y respuestas del formulario eliminados correctamente']);
        } else {

            $this->emit('alert', ['type' => 'error', 'message' => 'No se pudo encontrar el Asistente']);
        }

        $this->cancel();
    }



    public function feedback($id)
    {
        $contact = ContactsCourseRegistrationForm::find($id);

        if (!$contact) {
            $this->emit('alert', ['type' => 'error', 'message' => 'No se encontró el contacto.']);
            return;
        }

        $this->feedback = $contact->feedback;
        $this->contactId = $contact->id;
    }

    public function storeFeedback()
    {

        $this->validate([
            'feedback' => 'required',
        ]);

        $attendee = ContactsCourseRegistrationForm::find($this->contactId);
        $attendee->feedback =  $this->feedback;
        $attendee->update();


        //Email
        $contactEmail = Contact::find($attendee->contact_id);
        $content = 'Hola ' . $contactEmail->name . ' se ha registrado un feedback a la entrega del formulario: ' . $attendee->courseRegistrationForm->name . ' del control de registro del proceso: ' . $attendee->courseRegistrationForm->onlineRegistration->name . ': ' . $this->feedback;
        NewSendEmailJob::dispatch($contactEmail->email, 'Feedback Registro Formulario: ' . $attendee->courseRegistrationForm->name, $content);


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
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }

    // public function export()
    // {
    //     $stage = Stage::find($this->stageId);
    //     if (!$stage) {
    //         // Manejar el caso en que no se encuentra la etapa
    //         session()->flash('error', 'Etapa no encontrada.');
    //         return;
    //     }

    //     $postulates = ContactsStage::where('stage_id', $this->stageId)->get();
    //     $formStage = InformationForm::where('stage_id', '=', $this->stageId)->first();
    //     $answers = InformationFormAnswer::where('information_form_id', '=', $formStage->id)->get();

    //     return (new PostulatesListExport($postulates, $formStage, $answers, $stage))
    //         ->download('listado_postulados_' . date('Y-m-d_H-i-s') . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    // }

    // public function uploadPostulates()
    // {
    //     $this->failures = '';

    //     $this->validate([
    //         'filePostulates' => 'file|mimes:xlsx',
    //     ]);

    //     $import = new PostulatesImport($this->stageId);
    //     try {
    //         $import->import($this->filePostulates);

    //         $this->emit('alert', ['type' => 'success', 'message' =>  'Archivo de postulados cargado correctamente, ' . $import->getRowCount() . ' postulados importados']);
    //         $this->cancel();

    //         $this->filePostulates = '';
    //         $this->failures = '';
    //     } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
    //         $this->failures = $e->failures();

    //         foreach ($this->failures as $failure) {
    //             $failure->row();
    //             $failure->attribute();
    //             $failure->errors();
    //             $failure->values();
    //         }
    //     }
    // }

    public function sortBy($field)
    {
        $this->sortDirection = ($this->sortField === $field && $this->sortDirection === 'asc') ? 'desc' : 'asc';
        $this->sortField = $field;
    }


    public function updatingSearchName()
    {
        $this->resetPage();
    }
}
