<?php

namespace App\Http\Livewire\Contacts\Widgets;

use App\Contact;
use Livewire\Component;
use Livewire\WithPagination;
use App\ContactsPointsDetail;
use Illuminate\Support\Facades\Auth;

class WidgetsContactsComponent extends Component
{
    use WithPagination;

    public $contactId;
    
    public function mount()
    {
        $user = Auth::user();
        $contact = Contact::where('user_id', '=', $user->id)->first();

        $this->contactId = $contact->id;
    }

    public function render()
    {
        $detailPoints = ContactsPointsDetail::where('contact_id', '=', $this->contactId)
        ->orderBy('date', 'desc')
        ->get();
    
        $contact = Contact::find($this->contactId);

        return view('livewire.contacts.widgets.widgets-contacts-component',[
            'detailPoints'=> $detailPoints,
            'contact' => $contact
        ]);
    }
}
