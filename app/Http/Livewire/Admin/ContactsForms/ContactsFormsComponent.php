<?php

namespace App\Http\Livewire\Admin\ContactsForms;

use App\CommercialForm;
use App\Contact;
use App\ContactsAssignedForm;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ContactsFormsComponent extends Component
{
    public $form=[], $result=[];

    public function render()
    {
        if (auth()->check() && auth()->user()->role_id == 7) {

            $contact = Contact::where('user_id', '=', Auth::user()->id)->first();
            return view('livewire.admin.contacts-forms.contacts-forms-component',[
                'contact'=>$contact
            ]);
        } else {
            abort(403);
        }
    }
    
    public function getResult($id){
        $assign=ContactsAssignedForm::find($id);
        $commercialFormAction = $assign->commercialFormAction;
        $commercialForm = $commercialFormAction->commercialForm;
        
        $this->form=CommercialForm::find($commercialForm->id);
        $this->result = DB::table('answers_form_' . $commercialForm->id)->where('contact_id', '=', $assign->contact_id)->get();
    }

    public function resetInputFields()
    {
        $this->form= [];
        $this->result =  [];
    }

    public function cancel(){
        $this->emit('close-modal');
        $this->resetInputFields();
    }
}
