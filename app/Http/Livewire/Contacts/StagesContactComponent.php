<?php

namespace App\Http\Livewire\Contacts;

use App\Contact;
use App\Models\ContactsStage;
use App\Models\Stage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StagesContactComponent extends Component
{
    public $contactId;
    public $processId;
    public $stages;

    public function mount($id)
    {
        $this->processId = $id;

        $user = Auth::user();
        $contact = Contact::where('user_id', $user->id)->first();
        $this->contactId = $contact->id;

        // Etapas del proceso a las que el contacto está postulado
        $this->stages = Stage::where('process_id', $this->processId)
            ->whereHas('contactsStages', function ($query) {
                $query->where('contact_id', $this->contactId);
            })
            ->get();
    }

    public function render()
    {
        return view('livewire.contacts.stages-contact-component', [
            'stages' => $this->stages,
        ]);
    }
}
