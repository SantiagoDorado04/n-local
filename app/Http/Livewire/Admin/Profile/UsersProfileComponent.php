<?php

namespace App\Http\Livewire\Admin\Profile;


use App\CommercialFormQuestion;
use App\Contact;
use App\SocialEngineeringAnswers;
use App\SocialQuestion;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class UsersProfileComponent extends Component
{
    public $contactId;

    public function mount($contact)
    {
        $this->contactId = $contact;
    }

    public function render()
    {
        $contact = Contact::find($this->contactId);
        $questions = [];
        $answers = [];

        $sQuestions=SocialQuestion::where(function ($query) use ($contact) {
            $query->where('commercial_action_id', '=', $contact->commercial_action_id)
                ->orWhereNull('commercial_action_id');
        })
        ->get();

        $sAnswers=[];
        $sAnswers=SocialEngineeringAnswers::where('contact_id','=',$contact->id)->first();
        
        if ($contact->commercial_form_id != '') {
            $questions = CommercialFormQuestion::where('commercial_form_id', '=', $contact->commercial_form_id)->get();
            
            $answers = DB::table('answers_form_' . $contact->commercial_form_id)->where('contact_id', '=', $contact->id)->first();

        }


        return view('livewire.admin.profile.users-profile-component', [
            'contact' => $contact,
            'questions' => $questions,
            'answers' => $answers,
            'sQuestions'=>$sQuestions,
            'sAnswers'=>$sAnswers
        ]);
    }
}
