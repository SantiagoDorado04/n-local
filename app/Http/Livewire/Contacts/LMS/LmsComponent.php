<?php

namespace App\Http\Livewire\Contacts\LMS;

use App\Models\Course;
use App\Models\Step;
use Livewire\Component;

class LmsComponent extends Component
{
    public $description, $stepId;

    public function mount($id)
    {
        $this->stepId = $id;
    }

    public function render()
    {
        
        $step = Step::with('courses')->findOrFail($this->stepId);

        return view('livewire.contacts.l-m-s.lms-component', [
            'courses' => $step->courses,
            'step' => $step
        ]);
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);
        $this->description = $course->description;
    }

    public function resetInputFields()
    {
        $this->description = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}