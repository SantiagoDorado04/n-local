<?php

namespace App\Http\Livewire\Admin\PresentialActivities;

use App\Contact;
use Livewire\Component;
use Livewire\WithPagination;
use App\ContactsPointsDetail;
use App\Jobs\NewSendEmailJob;
use App\Models\ContactsStage;
use App\Models\PresentialActivity;
use App\ContactsPresentialActivity;
use App\Models\PresentialActivitiesGroup;

class PresentialActivitiesParticipantsComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public
        $searchName;

    public $groupId, $activityId;
    public $feedback, $contactActivityId;
    public $selectedContact;

    public function mount($id)
    {
        $this->groupId = $id;
    }

    public function render()
    {
        $group = PresentialActivitiesGroup::find($this->groupId);

        $query = ContactsPresentialActivity::with('contact')->where('presential_activity_id', '=', $group->presentialActivity->id)
            ->where('group_id', '=', $group->id);

        if ($this->searchName) {
            $query->whereHas('contact', function ($q) {
                $q->where('name', 'like', '%' . $this->searchName . '%')
                    ->orWhere('email', 'like', '%' . $this->searchName . '%')
                    ->orWhere('nit', 'like', '%' . $this->searchName . '%');
            });
        }
        // $mentoring = ContactsMentoring::where('mentor_id', '=', $mentor->id)->where('step_id', '=', $mentor->step_id)->get();
        $participants = $query->paginate(25);

        // $participants = ContactsPresentialActivity::where('presential_activity_id', '=', $group->presentialActivity->id)
        //     ->where('group_id', '=', $group->id)->get();

        $contactsStage = ContactsStage::where('stage_id', '=', $group->presentialActivity->step->stage_id)->get();

        return view('livewire.admin.presential-activities.presential-activities-participants-component', [
            'group' => $group,
            'activity' => $group->presentialActivity,
            'participants' => $participants,
            'contactsStage' => $contactsStage
        ]);
    }

    public function toggleApproved($id)
    {
        $contactActivity = ContactsPresentialActivity::findOrFail($id);
        $group = PresentialActivitiesGroup::find($contactActivity->group_id);
        $activity = PresentialActivity::find($group->presential_activity_id);
        $contactDetail = Contact::find($contactActivity->contact_id);

        // Update approved form
        $contactActivity->update(['approved' => !$contactActivity->approved]);

        $message = $contactActivity->approved ? 'Asistencia registrada' : 'Asistencia no registrada';

        if ($contactActivity->approved) {
            // Email approved form
            $content = 'Hola ' . $contactDetail->name . ', se ha registrado la asistencia a la actividad presencial correctamente.';
            NewSendEmailJob::dispatch($contactDetail->email, 'Asistencia Actividad Presencial', $content);

            // Add Points
            $contactDetail->points = $contactDetail->points + $activity->points;
            $contactDetail->update();

            // Add Detail Points
            $detail = new ContactsPointsDetail();
            $detail->detail = 'Se te han asignado +' . $activity->points . ' por por la asistencia a la actividad presencial "' . $activity->name . '"';
            $detail->points = $activity->points;
            $detail->date = date('Y-m-d H:i:s');
            $detail->contact_id = $contactDetail->id;
            $detail->save();

            // Email Points
            $content = $detail->detail;
            NewSendEmailJob::dispatch($contactDetail->email, '+ Puntos', $content);

            $this->emit('alert', ['type' => 'success', 'message' => 'Asistencia registrada']);
        } else {
            $this->emit('alert', ['type' => 'error', 'message' => 'Asistencia no registrada']);
        }
    }

    public function feedback($id)
    {
        $contactActivity = ContactsPresentialActivity::findOrFail($id);
        $this->feedback = $contactActivity->feedback;
        $this->contactActivityId = $contactActivity->id;
    }

    public function storeFeedback()
    {
        $this->validate([
            'feedback' => 'required',
        ]);

        $contactActivity = ContactsPresentialActivity::findOrFail($this->contactActivityId);
        $contactActivity->feedback =  $this->feedback;
        $contactActivity->update();

        // Email
        $contact = Contact::find($contactActivity->contact_id);
        $content = 'Hola ' . $contact->name . ', se ha registrado un feedback a la asistencia de su actividad presencial.';
        NewSendEmailJob::dispatch($contact->email, 'Feedback actividad presencial', $content);

        $this->emit('alert', ['type' => 'success', 'message' => 'Feedback agregado correctamente']);
        $this->cancel();
    }

    public function addParticipant()
    {

        // dd($this->selectedContact);

        $contactId = $this->selectedContact;
        $group = PresentialActivitiesGroup::find($this->groupId);
        $this->activityId = $group->presentialActivity->id;



        if ($contactId) {
            $contact = Contact::find($contactId);

            if ($contact) {
                $participant = new ContactsPresentialActivity();
                $participant->contact_id = $contactId;
                $participant->presential_activity_id = $this->activityId;
                $participant->group_id = $this->groupId;
                $participant->save();

                session()->flash('success_message', 'Usuario agregado correctamente.');
            } else {
                session()->flash('error_message', 'No se pudo encontrar el contacto seleccionado.');
            }
        } else {
            session()->flash('error_message', 'Por favor seleccione un contacto.');
        }
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

    public function confirmDelete($id)
    {
        $participant = ContactsPresentialActivity::findOrFail($id);
        $participant->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'asistente eliminado correctamente']);
    }
}
