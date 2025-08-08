<?php

namespace App\Http\Livewire\Admin\Mentoring;

use App\Contact;
use App\Models\Mentor;
use Livewire\Component;
use Livewire\WithPagination;
use App\ContactsPointsDetail;
use App\Jobs\NewSendEmailJob;
use App\Models\ContactsMentoring;

class ListMentoringComponent extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $mentorId;

    public $feedback, $mentoringId, $contactId;

    public
        $searchName;

    public function mount($id)
    {
        $this->mentorId = $id;
    }

    public function render()
    {
        $mentor = Mentor::find($this->mentorId);

        $query = ContactsMentoring::with('contact')->where('mentor_id', '=', $mentor->id)->where('step_id', '=', $mentor->step_id);

        if ($this->searchName) {
            $query->whereHas('contact', function ($q) {
                $q->where('name', 'like', '%' . $this->searchName . '%')
                    ->orWhere('email', 'like', '%' . $this->searchName . '%')
                    ->orWhere('nit', 'like', '%' . $this->searchName . '%');
            });
        }
        // $mentoring = ContactsMentoring::where('mentor_id', '=', $mentor->id)->where('step_id', '=', $mentor->step_id)->get();
        $mentoring = $query->paginate(25);



        return view('livewire.admin.mentoring.list-mentoring-component', [
            'mentor' => $mentor,
            'mentoring' => $mentoring
        ]);
    }

    public function toggleAttended($id)
    {
        $mentoring = ContactsMentoring::findOrFail($id);

        $mentory = Mentor::find($mentoring->mentor_id);
        $contactDetail = Contact::find($mentoring->contact_id);

        //Update approved form
        $mentoring->update(['attended' => !$mentoring->attended]);

        $message = $mentoring->attended ? 'Asistencia registrada' : 'Asistencia no registrada';


        if ($mentoring->attended) {

            //Email approved form
            $content = 'Hola ' . $contactDetail->name . ', se ha registrado la asistencia a la mentoria correctamente.';
            NewSendEmailJob::dispatch($contactDetail->email, 'Asistencia Mentoria', $content);

            //Add Points
            $contactDetail->points = $contactDetail->points + $mentory->points;
            $contactDetail->update();

            //Add Detail Points
            $detail = new ContactsPointsDetail();
            $detail->detail = 'Se te han asignado +' . $mentory->points . ' por por la asistencia a mentoria con "' . $mentory->name . '"';
            $detail->points = $mentory->points;
            $detail->date = date('Y-m-d H:i:s');
            $detail->contact_id = $contactDetail->id;
            $detail->save();

            //Email Points
            $content = $detail->detail;
            NewSendEmailJob::dispatch($contactDetail->email, '+ Puntos', $content);

            $this->emit('alert', ['type' => 'success', 'message' => 'Asistencia mentoria registrada']);
        } else {

            $this->emit('alert', ['type' => 'error', 'message' => 'Asistencia mentoria no registrada']);
        }
    }

    public function confirmDelete($id)
    {
        $mentoring = ContactsMentoring::findOrFail($id);
        $mentoring->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Mentoria eliminada correctamente']);
    }

    public function feedback($id)
    {
        $mentoring = ContactsMentoring::findOrFail($id);
        $this->feedback = $mentoring->feedback;

        $this->mentoringId = $mentoring->id;
    }

    public function storeFeedback()
    {

        $this->validate([
            'feedback' => 'required',
        ]);

        $mentoring = ContactsMentoring::findOrFail($this->mentoringId);
        $mentoring->feedback =  $this->feedback;
        $mentoring->update();

        //Email
        $contact = Contact::find($mentoring->contact_id);
        $content = 'Hola ' . $contact->name . ', se ha registrado un feedback a la asistencia de su mentoria.';
        NewSendEmailJob::dispatch($contact->email, 'Feedback Mentoria', $content);


        $this->emit('alert', ['type' => 'success', 'message' => 'Feedback agregado correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->feedback = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
