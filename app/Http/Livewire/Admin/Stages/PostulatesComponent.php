<?php

namespace App\Http\Livewire\Admin\Stages;

use App\Contact;
use App\Models\User;
use App\Models\Stage;
use App\Jobs\WaOfiJob;
use Livewire\Component;
use App\Jobs\SendSmsUser;
use App\Jobs\SendEmailUser;
use Livewire\WithPagination;
use App\ContactsPointsDetail;
use App\Jobs\NewSendEmailJob;
use App\Models\ContactsStage;
use Livewire\WithFileUploads;
use App\Models\InformationForm;
use App\Imports\PostulatesImport;
use Illuminate\Support\Facades\Hash;
use App\Exports\PostulatesListExport;
use App\Models\InformationFormAnswer;
use Illuminate\Support\Facades\Route;
use App\Models\ContactsInformationForm;

class PostulatesComponent extends Component
{
    use WithFileUploads, WithPagination;
    protected $paginationTheme = 'simple-bootstrap';
    public
        $stageId,
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

    public  $isRegisterForm = false;

    // public function mount($id)
    // {
    //     if (Route::currentRouteName() == 'information-forms.answers') {
    //         $this->formId = $id;
    //         $form = InformationForm::findOrFail($this->formId);
    //     } else {
    //         $this->stageId = $id;
    //         $form = InformationForm::where('stage_id', $this->stageId)->firstOrFail();
    //         $this->formId = $form->id;
    //         $this->isRegisterForm = true;
    //     }
    // }

    public $sortField = 'id';
    public $sortDirection = 'asc';

    public function mount($id)
    {
        if (Route::currentRouteName() == 'information-forms.answers') {
            $this->formId = $id;
            $form = InformationForm::findOrFail($this->formId);
            $this->stageId = $form->step->stage->id; // Asegúrate de que la etapa asociada esté correctamente asignada.
        } else {
            $this->stageId = $id;
            $form = InformationForm::where('stage_id', $this->stageId)->firstOrFail();
            $this->formId = $form->id;
            $this->isRegisterForm = true;
        }
    }

    // public function render()
    // {
    //     if (Route::currentRouteName() == 'information-forms.answers') {
    //         $form = InformationForm::findOrFail($this->formId);
    //     } else {
    //         $form = InformationForm::where('stage_id', $this->stageId)->firstOrFail();
    //         $this->formId = $form->id;
    //     }

    //     $questions = $form->questions;

    //     if ($form->stage_id != null) {
    //         $query = ContactsStage::where('stage_id', $this->stageId);
    //     } else {
    //         $query = ContactsInformationForm::where('information_form_id', $this->formId);
    //     }

    //     if ($this->searchName) {
    //         $query->whereHas('contact', function ($q) {
    //             $q->where('name', 'like', '%' . $this->searchName . '%')
    //                 ->orWhere('email', 'like', '%' . $this->searchName . '%')
    //                 ->orWhere('nit', 'like', '%' . $this->searchName . '%');
    //         });
    //     }

    //     $postulates = $query->paginate(25);

    //     return view('livewire.admin.stages.postulates-component', [
    //         'form' => $form,
    //         'questions' => $questions,
    //         'postulates' => $postulates,
    //         'stage' => $form->stage
    //     ]);
    // }

    public function render()
    {
        $form = InformationForm::findOrFail($this->formId);
        $questions = $form->questions;

        if ($form->stage_id != null) {
            $query = ContactsStage::with('contact')->where('stage_id', $this->stageId);
        } else {
            $query = ContactsInformationForm::with('contact')->where('information_form_id', $this->formId);
        }

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

        $postulates = $query->paginate(25);


        return view('livewire.admin.stages.postulates-component', [
            'form' => $form,
            'questions' => $questions,
            'postulates' => $postulates,
            'stage' => $form->stage
        ]);
    }


    public function toggleApproval($postulateId)
    {
        $postulate = ContactsStage::findOrFail($postulateId);
        $postulate->update(['approved' => !$postulate->approved]);

        $message = $postulate->approved ? 'Postulante aprobado' : 'Postulante no aprobado';
        $this->emit('alert', ['type' => $postulate->approved ? 'success' : 'error', 'message' => $message]);
    }

    public function toggleApprovalForm($id)
    {
        $contactForm = ContactsInformationForm::findOrFail($id);

        $form = InformationForm::find($this->formId);
        $contactDetail = Contact::find($contactForm->contact_id);

        //Update approved form
        $contactForm->update(['approved' => !$contactForm->approved]);

        if ($contactForm->approved) {

            //Add Points
            $contactDetail->points = $contactDetail->points + $form->points;
            $contactDetail->update();

            //Add Detail Points
            $detail = new ContactsPointsDetail();
            $detail->detail = 'Se te han asignado +' . $form->points . ' por el registro del formulario "' . $form->name . '"';
            $detail->points = $form->points;
            $detail->date = date('Y-m-d H:i:s');
            $detail->contact_id = $contactDetail->id;
            $detail->save();

            //Congratulations
            $contact = Contact::find($contactDetail->id);
            $content = $form->congratulation_message;

            switch ($form->reminder_message_mean) {
                case 'email':
                    NewSendEmailJob::dispatch($contact->email, 'Registro formulario', $content);
                    break;
                case 'whatsapp':
                    WaOfiJob::dispatch('+57' . $contact->phone, $content);
                    break;
                case 'sms':
                    SendSmsUser::dispatch('+57' . $contact->phone, $content);
                    break;
                default:
                    break;
            }

            $this->emit('alert', ['type' => 'success', 'message' => 'Formulario revisado']);
        } else {

            $this->emit('alert', ['type' => 'error', 'message' => 'Formulario no aprobado']);

            $contactDetail->points = $contactDetail->points - $form->points;
            $contactDetail->update();
        }
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

            $existingContactStage = ContactsStage::where('contact_id', $existingContact->id)
                ->where('stage_id', $this->stageId)
                ->first();

            if ($existingContactStage) {
                $this->emit('alert', ['type' => 'error', 'message' => 'El contacto ya está postulado en esta etapa.']);
                return;
            } else {

                $contactsStages = new ContactsStage();
                $contactsStages->contact_id = $existingContact->id;
                $contactsStages->stage_id = $this->stageId;
                $contactsStages->approved = $this->approved;
                $contactsStages->save();

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

            $contactsStages = new ContactsStage();
            $contactsStages->contact_id = $contact->id;
            $contactsStages->stage_id = $this->stageId;
            $contactsStages->approved = $this->approved;
            $contactsStages->save();

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

        $this->emit('alert', ['type' => 'success', 'message' => 'Postulado actualizado correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->contactId = $id;
    }

    public function destroy()
    {
        $contact = Contact::find($this->contactId);

        if ($contact) {

            ContactsStage::where('contact_id', $this->contactId)
                ->where('stage_id', $this->stageId)
                ->delete();

            $this->emit('alert', ['type' => 'success', 'message' => 'Postulado eliminado correctamente']);
        } else {
            $this->emit('alert', ['type' => 'error', 'message' => 'No se pudo encontrar el postuladoo']);
        }
        $this->cancel();
    }

    public function feedback($id)
    {

        if ($this->isRegisterForm) {
            $contact = ContactsStage::findOrFail($id);
            $this->feedback = $contact->feedback;
            $this->contactId = $contact->contact_id;
        } else {
            $contact = ContactsInformationForm::findOrFail($id);
            $this->feedback = $contact->feedback;
            $this->contactId = $contact->id;
        }
    }

    public function storeFeedback()
    {

        $this->validate([
            'feedback' => 'required',
        ]);

        if ($this->isRegisterForm) {
            $contact = ContactsStage::findOrFail($this->contactId);
            $contact->feedback =  $this->feedback;
            $contact->update();
        } else {
            $contact = ContactsInformationForm::findOrFail($this->contactId);
            $contact->feedback =  $this->feedback;
            $contact->update();
        }

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
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }

    public function export()
    {
        $stage = Stage::find($this->stageId);
        if (!$stage) {
            // Manejar el caso en que no se encuentra la etapa
            session()->flash('error', 'Etapa no encontrada.');
            return;
        }

        $postulates = ContactsStage::where('stage_id', $this->stageId)->get();
        $formStage = InformationForm::where('stage_id', '=', $this->stageId)->first();
        $answers = InformationFormAnswer::where('information_form_id', '=', $formStage->id)->get();

        return (new PostulatesListExport($postulates, $formStage, $answers, $stage))
            ->download('listado_postulados_' . date('Y-m-d_H-i-s') . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function uploadPostulates()
    {
        $this->failures = '';

        $this->validate([
            'filePostulates' => 'file|mimes:xlsx',
        ]);

        $import = new PostulatesImport($this->stageId);
        try {
            $import->import($this->filePostulates);

            $this->emit('alert', ['type' => 'success', 'message' =>  'Archivo de postulados cargado correctamente, ' . $import->getRowCount() . ' postulados importados']);
            $this->cancel();

            $this->filePostulates = '';
            $this->failures = '';
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $this->failures = $e->failures();

            foreach ($this->failures as $failure) {
                $failure->row();
                $failure->attribute();
                $failure->errors();
                $failure->values();
            }
        }
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

            $contactStage = ContactsStage::where('contact_id', $company->id)->first();
            if ($contactStage !== null) {
                if ($contactStage->stage_id == $this->stageId) {
                    $this->contactHasStage = true;
                    $this->addError('stage', 'Ya se encuentra postulado a esta estrategia.');
                } else {
                    $this->contactHasStage = false;
                }
            } else {
                $this->contactHasStage = false;
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $this->name = '';
            $this->email = '';
            $this->phone = '';
            $this->whatsapp = '';
            $this->contact_person_name = '';
            $this->website = '';
            $this->contactId = '';

            $this->contactHasStage = false;
            $this->addError('nit', 'No existe registros con este NIT/Cédula.');
        }
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
}
