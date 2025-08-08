<?php

namespace App\Http\Livewire\Admin\Viability;

use App\Contact;
use Livewire\Component;
use App\AnnouncementsContact;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ViabilityComponent extends Component
{

    public $contactId;
    
    public function mount()
    {
        $contact = Contact::where('user_id', '=', Auth::user()->id)->first();
        if($contact!=''){
            $this->contactId = $contact->id;
            $this->contactId;
        }else{
            abort(403);
        }
        
    }
    
    public function render()
    {
        $projects=Project::where('contact_id','=',$this->contactId)->get();
        return view('livewire.admin.viability.viability-component',[
            'projects'=>$projects
        ]);
    }

    public function show($id){

    }
}
