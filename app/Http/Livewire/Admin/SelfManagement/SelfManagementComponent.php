<?php

namespace App\Http\Livewire\Admin\SelfManagement;

use App\Contact;
use Livewire\Component;
use App\AnnouncementsContact;
use Illuminate\Support\Facades\Auth;

class SelfManagementComponent extends Component
{
    public $contactId;
    
    public function mount()
    {
        $contact = Contact::where('user_id', '=', Auth::user()->id)->first();
        $this->contactId = $contact->id;
        $this->contactId;
    }
    
    public function render()
    {
        $projects=AnnouncementsContact::where('contact_id','=',$this->contactId)->get();
        return view('livewire.admin.self-management.self-management-component',[
            'projects'=>$projects
        ]);
    }

    public function show($id){

    }
}
