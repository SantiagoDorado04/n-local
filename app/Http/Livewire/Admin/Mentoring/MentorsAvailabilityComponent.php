<?php

namespace App\Http\Livewire\Admin\Mentoring;

use App\Models\Mentor;
use Livewire\Component;
use App\Models\MentorAvailability;

class MentorsAvailabilityComponent extends Component
{
    public $mentorAvailabilities, $mentorId, $date, $start_time, $end_time,$availabilityId;
    public $updateMode = false;

    public function mount($id)
{
    $this->mentorId = $id;
}

public function render()
{
    $this->mentorAvailabilities = MentorAvailability::where('mentor_id', $this->mentorId)->get();

    $mentor = Mentor::find($this->mentorId);

    return view('livewire.admin.mentoring.mentors-availability-component', [
        'mentor' => $mentor,
        'mentorAvailabilities' => $this->mentorAvailabilities,
    ]);
}

    public function show($id)
    {
        $mentorAvailability = MentorAvailability::find($id);
        $this->mentorId = $mentorAvailability->mentor_id;
        $this->date = $mentorAvailability->date;
        $this->start_time = $mentorAvailability->start_time;
        $this->end_time = $mentorAvailability->end_time;
    }

    public function store()
    {
        $this->validate([
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|before:end_time',
            'end_time' => 'required|after:start_time',
       ], [], [
            'date' => 'fecha',
            'start_time' => 'hora de inicio',
            'end_time' => 'hora de fin',
        ]);

        MentorAvailability::create([
            'mentor_id' => $this->mentorId,
            'date' => $this->date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ]);

        $this->emit('alert', ['type' => 'success', 'message' => 'Disponibilidad del mentor creada correctamente']);
        $this->cancel();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $this->updateMode = true;
        $mentorAvailability = MentorAvailability::find($id);
        $this->mentorId = $mentorAvailability->mentor_id;
        $this->date = $mentorAvailability->date;
        $this->start_time = $mentorAvailability->start_time;
        $this->end_time = $mentorAvailability->end_time;

        $this->availabilityId = $id;
    }

    public function update()
    {
        $this->validate([
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|before:end_time',
            'end_time' => 'required|after:start_time',
        ], [], [
            'date' => 'fecha',
            'start_time' => 'hora de inicio',
            'end_time' => 'hora de fin',
        ]);

        if ($this->availabilityId) {
            $mentorAvailability = MentorAvailability::find($this->availabilityId);
            $mentorAvailability->update([
                'date' => $this->date,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
            ]);
            $this->emit('alert', ['type' => 'success', 'message' => 'Disponibilidad del mentor actualizada correctamente']);
            $this->cancel();
        }
        $this->resetInputFields();
    }


    public function delete($id)
    {
        $this->availabilityId = $id;
    }

    public function destroy()
    {
        $mentor = MentorAvailability::find($this->availabilityId);
        $mentor->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Mentor eliminado correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->date = '';
        $this->start_time = '';
        $this->end_time = '';
        $this->updateMode = false;
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
