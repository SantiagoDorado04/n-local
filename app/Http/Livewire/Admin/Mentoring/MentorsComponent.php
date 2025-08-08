<?php

namespace App\Http\Livewire\Admin\Mentoring;

use App\MentorsList;
use App\Models\Mentor;
use App\Models\Step;
use Livewire\Component;

class MentorsComponent extends Component
{

    public $mentors, $name ,$email, $phone, $mentor_id, $session_duration, $points, $required_points, $cancellation_deadline, $reminder_message, $reminder_message_date, $reminder_message_mean, $congratulation_message, $congratulation_message_date, $congratulation_message_mean;
    public $updateMode = false;
    public $stepId, $mentorId;
    public $selectedMentor, $mentorListId;
    public $searchName;

    public function mount($id)
    {
        $this->stepId = $id;
    }

    public function render()
    {
        // $this->mentors = Mentor::all();
        $this->mentors = Mentor::where('step_id', $this->stepId)->get();
        $mentorsList = MentorsList::all();
        $step = Step::find($this->stepId);

        return view('livewire.admin.mentoring.mentors-component', [
            'step' => $step,
            'mentorsList' => $mentorsList,
            'mentors' => $this->mentors
        ]);
    }

    public function show($id)
    {
        $this->mentorId = $id;

        $mentor = Mentor::find($id);
        $infoMentor = MentorsList::find($mentor->mentor_id);
        $this->name = $infoMentor->name;
        $this->email=$infoMentor->email;
        $this->phone=$infoMentor->phone;
        $this->session_duration = $mentor->session_duration;
        $this->points = $mentor->points;
        $this->required_points = $mentor->required_points;
        $this->cancellation_deadline = $mentor->cancellation_deadline;
        $this->reminder_message = $mentor->reminder_message;
        $this->reminder_message_date = $mentor->reminder_message_date;
        $this->reminder_message_mean = $mentor->reminder_message_mean;
        $this->congratulation_message = $mentor->congratulation_message;
        $this->congratulation_message_date = $mentor->congratulation_message_date;
        $this->congratulation_message_mean = $mentor->congratulation_message_mean;
    }

    public function store()
    {
        $this->validate([
            'mentor_id' => 'required',
            'session_duration' => 'required|numeric',
            'points' => 'nullable|numeric|min:1',
            'required_points' => 'nullable|numeric|min:1',
            'cancellation_deadline' => 'nullable|date',
            'reminder_message' => 'nullable',
            'reminder_message_date' => 'nullable|date|after_or_equal:today',
            'reminder_message_mean' => 'nullable',
            'congratulation_message' => 'nullable',
            'congratulation_message_date' => 'nullable|date|after_or_equal:today',
            'congratulation_message_mean' => 'nullable',
        ], [], [
            'mentor_id' => 'mentor',
            'session_duration' => 'duración de la sesión',
            'points' => 'puntos',
            'required_points' => 'puntos requeridos',
            'cancellation_deadline' => 'fecha limite de cancelacion',
            'reminder_message' => 'Mensaje recordatorio',
            'reminder_message_date' => 'Fecha Mensaje recordatorio',
            'reminder_message_mean' => 'Medio Mensaje recordatorio',
            'congratulation_message' => 'Mensaje felicitacion',
            'congratulation_message_date' => 'Fecha Mensaje felicitacion',
            'congratulation_message_mean' => 'Medio Mensaje felicitacion',
        ]);

        $mentor = new Mentor();
        $mentor->mentor_id = $this->mentor_id;
        $mentor->session_duration = $this->session_duration;
        $mentor->points = $this->points;
        $mentor->required_points = $this->required_points ?: null;
        $mentor->cancellation_deadline = $this->cancellation_deadline ?: null;
        $mentor->reminder_message = $this->reminder_message;
        $mentor->reminder_message_date = $this->reminder_message_date ?: null;
        $mentor->reminder_message_mean = $this->reminder_message_mean;
        $mentor->congratulation_message = $this->congratulation_message;
        $mentor->congratulation_message_date = $this->congratulation_message_date ?: null;
        $mentor->congratulation_message_mean = $this->congratulation_message_mean;
        $mentor->step_id = $this->stepId;
        $mentor->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Mentor creado correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->mentorId = $id;

        $mentor = Mentor::find($id);
        $this->mentor_id = $mentor->mentor_id;
        $this->session_duration = $mentor->session_duration;
        $this->points = $mentor->points;
        $this->required_points = $mentor->required_points;
        $this->cancellation_deadline = $mentor->cancellation_deadline;
        $this->reminder_message = $mentor->reminder_message;
        $this->reminder_message_date = $mentor->reminder_message_date;
        $this->reminder_message_mean = $mentor->reminder_message_mean;
        $this->congratulation_message = $mentor->congratulation_message;
        $this->congratulation_message_date = $mentor->congratulation_message_date;
        $this->congratulation_message_mean = $mentor->congratulation_message_mean;
    }

    public function update()
    {
        $this->validate([
            'mentor_id' => 'required',
            'session_duration' => 'required|numeric',
            'points' => 'nullable|numeric|min:1',
            'required_points' => 'nullable|numeric|min:1',
            'cancellation_deadline' => 'nullable|date',
            'reminder_message' => 'nullable',
            'reminder_message_date' => 'nullable|date|after_or_equal:today',
            'reminder_message_mean' => 'nullable',
            'congratulation_message' => 'nullable',
            'congratulation_message_date' => 'nullable|date|after_or_equal:today',
            'congratulation_message_mean' => 'nullable',
        ], [], [
            'mentor_id' => 'mentor',
            'session_duration' => 'duración de la sesión',
            'points' => 'puntos',
            'required_points' => 'puntos requeridos',
            'cancellation_deadline' => 'fecha limite de cancelacion',
            'reminder_message' => 'Mensaje recordatorio',
            'reminder_message_date' => 'Fecha Mensaje recordatorio',
            'reminder_message_mean' => 'Medio Mensaje recordatorio',
            'congratulation_message' => 'Mensaje felicitacion',
            'congratulation_message_date' => 'Fecha Mensaje felicitacion',
            'congratulation_message_mean' => 'Medio Mensaje felicitacion',
        ]);

        $mentor = Mentor::find($this->mentorId);
        $mentor->mentor_id = $this->mentor_id;
        $mentor->session_duration = $this->session_duration;
        $mentor->points = $this->points;
        $mentor->required_points = $this->required_points ?: null;
        $mentor->cancellation_deadline = $this->cancellation_deadline ?: null;
        $mentor->reminder_message = $this->reminder_message;
        $mentor->reminder_message_date = $this->reminder_message_date ?: null;
        $mentor->reminder_message_mean = $this->reminder_message_mean;
        $mentor->congratulation_message = $this->congratulation_message;
        $mentor->congratulation_message_date = $this->congratulation_message_date ?: null;
        $mentor->congratulation_message_mean = $this->congratulation_message_mean;
        $mentor->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Mentor actualizado correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->mentorId = $id;
    }

    public function destroy()
    {
        $mentor = Mentor::find($this->mentorId);
        $mentor->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Mentor eliminado correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->mentor_id = '';
        $this->session_duration = '';
        $this->points = '';
        $this->required_points = '';
        $this->cancellation_deadline = '';
        $this->reminder_message = '';
        $this->reminder_message_date = '';
        $this->reminder_message_mean = '';
        $this->congratulation_message = '';
        $this->congratulation_message_date = '';
        $this->congratulation_message_mean = '';
        $this->mentorId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
