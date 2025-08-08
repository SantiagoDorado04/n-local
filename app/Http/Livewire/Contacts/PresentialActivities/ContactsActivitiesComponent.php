<?php

namespace App\Http\Livewire\Contacts\PresentialActivities;

use App\Contact;
use App\Models\Step;
use Livewire\Component;
use App\Models\PresentialActivity;
use App\ContactsPresentialActivity;
use Illuminate\Support\Facades\Auth;
use App\Models\PresentialActivitiesGroup;

class ContactsActivitiesComponent extends Component
{

    public $stepId;
    public  $contactId;

    public $groupId;

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
        $step = Step::find($this->stepId);
        $activities = PresentialActivity::where('step_id', '=', $this->stepId)->get();

        return view('livewire.contacts.presential-activities.contacts-activities-component', [
            'step' => $step,
            'activities' => $activities
        ]);
    }

    public function selectAttend($selectAttend)
    {
        $this->groupId = $selectAttend;
    }

    public function cancelAttendance($selectAttend)
    {
        $this->groupId = $selectAttend;
    }

    public function attend()
    {
        $group = PresentialActivitiesGroup::findOrFail($this->groupId);

        $existingAttendance = ContactsPresentialActivity::where('contact_id', $this->contactId)
            ->whereHas('group', function ($query) use ($group) {
                $query->where('presential_activity_id', $group->presential_activity_id);
            })
            ->first();

        if ($existingAttendance) {
            $this->emit('alert', ['type' => 'error', 'message' => 'Ya estás registrado en otro grupo de esta actividad.']);
        } else {
            if ($group->quota <= $group->registeredAttendees()->count()) {
                $this->emit('alert', ['type' => 'error', 'message' => 'Lo siento, el cupo para este grupo ya está lleno.']);
            } else {
                ContactsPresentialActivity::create([
                    'contact_id' => $this->contactId,
                    'group_id' => $this->groupId,
                    'presential_activity_id' => $group->presential_activity_id,
                ]);

                $this->emit('alert', ['type' => 'success', 'message' => '¡Te has registrado correctamente!']);
            }
        }

        $this->cancel();
    }

    public function confirmCancelAttendance()
    {

        ContactsPresentialActivity::where('contact_id', $this->contactId)
            ->where('group_id', $this->groupId)
            ->delete();



        $this->emit('alert', ['type' => 'success', 'message' => 'Has cancelado tu registro correctamente.']);

        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->groupId = '';
    }
    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
