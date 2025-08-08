<?php

namespace App\Http\Livewire\Contacts\Mentoring;

use App\Contact;
use App\Models\Step;
use App\Models\Mentor;
use Livewire\Component;
use App\Jobs\SendEmailJob;
use App\Jobs\NewSendEmailJob;
use App\Models\ContactsMentoring;
use Illuminate\Support\Facades\Auth;

class MentoringContactsComponent extends Component
{

    public $stepId;
    public  $contactId;

    public $range;

    public $idAgenda;

    public $stageActive = false;

    public function mount($id)
    {
        $this->stepId = $id;
        $step = Step::find($id);
        if ($step->stage->active == 1) {
            $this->stageActive = true;
        }

        $user = Auth::user();
        $contact = Contact::where('user_id', '=', $user->id)->first();
        $this->contactId = $contact->id;
    }

    public function render()
    {

        $mentors = Mentor::where('step_id', '=', $this->stepId)->get();
        $step = Step::find($this->stepId);

        $bookings = ContactsMentoring::where('step_id', '=', $this->stepId)->get();

        return view('livewire.contacts.mentoring.mentoring-contacts-component', [
            'mentors' => $mentors,
            'step' => $step,
            'bookings' => $bookings
        ]);
    }

    public function selectTimeRange($range)
    {
        $this->range = $range;
    }

    public function cancelBooking($id)
    {
        $this->idAgenda = $id;
    }

    public function cancelSelectTimeRange()
    {

        $mentory =  ContactsMentoring::find($this->idAgenda);
        $mentory->delete();

        $contact = Contact::find($this->contactId);
        $mentorDetail  = Mentor::find($mentory->mentor_id);
        $content = 'Hola ' . $contact->name . ' ha cancelado la mentoria con ' . $mentorDetail->name . ', del dia ' . $mentory->date . ' a las ' . $mentory->start;

        NewSendEmailJob::dispatch($contact->email, 'Agenda Mentoria', $content);

        $this->emit('alert', ['type' => 'success', 'message' => 'Mentoria cancelada correctamente']);
        $this->cancel();
    }


    public function confirmSelectTimeRange()
    {
        $parts = explode(' - ', $this->range);
        $start = $parts[0];
        $end = $parts[1];
        $date = $parts[2];
        $mentor = $parts[3];

        $mentoryContact = ContactsMentoring::where('contact_id', '=', $this->contactId)->where('step_id', '=', $this->stepId)->where('mentor_id', '=', $mentor)->first();

        if ($mentoryContact != '') {
            $this->emit('alert', ['type' => 'error', 'message' => 'Ya tiene agendado una mentoria']);
        } else {

            $mentorDetail  = Mentor::find($mentor);
            $mentory =  new ContactsMentoring();
            $mentory->contact_id  =  $this->contactId;
            $mentory->step_id  =  $this->stepId;
            $mentory->mentor_id  =  $mentor;
            $mentory->date  =  $date;
            $mentory->start  =  $start;
            $mentory->end  =  $end;
            $mentory->save();

            $contact = Contact::find($this->contactId);

            $content = 'Hola ' . $contact->name . ' ha agendado una mentoria con ' . $mentorDetail->name . ', el dia ' . $date . ' a las ' . $start;

            NewSendEmailJob::dispatch($contact->email, 'Agenda Mentoria', $content);

            $this->emit('alert', ['type' => 'success', 'message' => 'Mentoria agendada correctamente']);
            $this->cancel();
        }
    }

    public function resetInputFields()
    {
        $this->range = '';
        $this->idAgenda = '';
    }
    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
