<?php

namespace App\Http\Livewire\Contacts;

use App\Contact;
use App\Models\ContactsStage;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ProcessesContactComponent extends Component
{
    public  $contactId;

    public function mount()
    {
        $user = Auth::user();
        $contact = Contact::where('user_id', '=', $user->id)->first();
        $this->contactId = $contact->id;
    }

    public function render()
    {
        $postulations = ContactsStage::where('contact_id', '=', $this->contactId)->get();
        
        return view('livewire.contacts.processes-contact-component', [
            'postulations' => $postulations
        ]);
    }
}
