<?php

namespace App\Http\Livewire\Contacts;

use App\Contact;
use App\Models\ContactsStage;
use App\Models\Process;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ProcessesContactComponent extends Component
{
    public  $contactId;
    public $processes;

    public function mount()
    {
        $user = Auth::user();
        $contact = Contact::where('user_id', $user->id)->first();
        $this->contactId = $contact->id;

        // Opción más directa: obtener procesos únicos que tengan etapas donde el contacto esté postulado
        $this->processes = Process::whereHas('stages.contactsStages', function ($query) {
            $query->where('contact_id', $this->contactId);
        })
            ->get();
    }

    public function render()
    {
        return view('livewire.contacts.processes-contact-component', [
            'processes' => $this->processes
        ]);
    }
}
