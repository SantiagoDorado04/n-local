<?php

namespace App\Http\Livewire\Admin\Contacts;

use App\Contact;
use Livewire\Component;
use App\CommercialFormAction;
use App\ContactsAssignedForm;

class ContactsFormsComponent extends Component
{
    public $token, $form = [], $formId;

    public $contact, $contactId;

    public function mount($id)
    {
        $this->contact=Contact::find($id);
        $this->contactId = $id;
    }

    public function render()
    {
        return view('livewire.admin.contacts.contacts-forms-component');
    }

    //y12xgprYhPyToVTq6E89
    public function validateToken()
    {

        $this->validate([
            'token' => 'required'
        ], [], []);

        $result = CommercialFormAction::where('token', '=', $this->token)->first();

        if ($result != '') {
            $this->form = $result;
            $this->formId = $this->form->id;
            $this->emit('alert', ['type' => 'success', 'message' => 'Formulario seleccionado.']);
        } else {
            $this->form = [];
            $this->formId = '';
            $this->emit('alert', ['type' => 'error', 'message' => 'Formulario no encontrado.']);
        }
    }

    public function assign()
    {

        if ($this->form != []) {

            $result = ContactsAssignedForm::where('contact_id', '=', $this->contactId)
                ->where('commercial_form_action_id', '=', $this->formId)
                ->first();

            if ($result != '') {
                $this->emit('alert', ['type' => 'error', 'message' => 'El formulario ya se encuentra asignado.']);
            } else {
                $assigned = new ContactsAssignedForm();
                $assigned->contact_id = $this->contactId;
                $assigned->commercial_form_action_id = $this->formId;
                $assigned->save();

                $this->emit('alert', ['type' => 'success', 'message' => 'Formulario asignado correctamente.']);

                $this->form = [];
                $this->formId = '';
                $this->token='';
            }
        }

        $this->contact=Contact::find($this->contactId);
    }

    public function cancel()
    {
        $this->emit('close-modal');
    }
}
