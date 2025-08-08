<?php

namespace App\Http\Livewire\Admin\AnnouncementsContatcs;

use App\Announcement;
use App\AnnouncementsContact;
use App\Contact;
use Livewire\Component;
use App\AnnouncementsForm;
use App\AnnouncementsFormsOption;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AnnouncementsContactsComponent extends Component
{

    public $contactId;

    public $anContact=[], $announcementId;

    public function mount($form, $action, $contact_id = null ){
        
        $contact= [];
        if ($contact_id !=null) {
            $this->contactId=$contact_id;
            $contact = Contact::find($contact_id);
        }else{
            $contact = Contact::where('user_id', '=', Auth::user()->id)->first();
            $this->contactId=$contact->id;
    
        }

        $result=DB::table('answers_form_' . $form)->where('commercial_action_id','=',$action)->where('contact_id','=',$contact->id)->get();

        $announcements = AnnouncementsForm::where('commercial_form_id', '=', $form)
            ->get();

            if (count($announcements) > 0) {
                foreach ($announcements as $announcement) {
    
                    $options = AnnouncementsFormsOption::where('announcement_form_id', '=', $announcement->id)
                        ->get();
    
                    if (count($options) > 0) {
                        $convoque = true;
                        foreach ($options as $option) {
                            if ($result[0]->{'question_' . $option->commercial_question_id} != $option->value) {
                                $convoque = true;
                            }else{
                                $convoque = false;
                            }
                        }
    
                        if ($convoque == true) {
                            array_push($this->anContact, $announcement->announcement_id);
                        }
                    }
                }
            }
    }

    public function render()
    {

        $announcements=Announcement::whereIn('id',$this->anContact)
        ->get();

        return view('livewire.admin.announcements-contatcs.announcements-contacts-component',[
            'announcements'=>$announcements
        ]);
    }

    public function apply($id){
        $this->announcementId=$id;
    }

    public function confirmApply()
    {
        $announcement=new AnnouncementsContact();
        $announcement->announcement_id=$this->announcementId;
        $announcement->contact_id=$this->contactId;
        $announcement->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Convocatoria aplicada correctamente']);
        $this->cancel();
    }

    public function resetInputFields(){
        
    }

    public function cancel(){
        $this->emit('close-modal');
        $this->resetInputFields();
    }

}
