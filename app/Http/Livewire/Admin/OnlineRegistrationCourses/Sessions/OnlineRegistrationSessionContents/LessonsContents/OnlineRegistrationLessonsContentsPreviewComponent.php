<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\LessonsContents;

use App\Models\OnlineRegistrationCourseSession;
use App\Models\OnlineRegistrationSessionContent;
use Livewire\Component;

class OnlineRegistrationLessonsContentsPreviewComponent extends Component
{

    public $lessonContent;
    public $sessionContent;
    public $title;
    public $content;
    public $image;
    public $align_image;
    public $existingFile;
    public $parameter;
    public $currentStepIndex = 0;


    public function mount($id)
    {
        $this->sessionContent = OnlineRegistrationSessionContent::find($id);
        $this->lessonContent = $this->sessionContent->lesson->steps;
        $this->loadStep();
    }
    public function loadStep()
    {
        if (isset($this->lessonContent[$this->currentStepIndex])) {
            $step = $this->lessonContent[$this->currentStepIndex];
            $this->title = $step->title;
            $this->content = $step->body;
            $this->align_image = $step->align_image;
            $this->parameter = ($this->align_image == "left") ? false : true;
            $this->existingFile = $step->image ? asset('storage/' . $step->image) : null;
        }
    }
    public function nextStep()
    {
        if ($this->currentStepIndex < count($this->lessonContent) - 1) {
            $this->currentStepIndex++;
            $this->loadStep();
        }
    }
    public function prevStep()
    {
        if ($this->currentStepIndex > 0) {
            $this->currentStepIndex--;
            $this->loadStep();
        }
    }

    public function render()
    {
        return view('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.lessons-contents.online-registration-lessons-contents-preview-component');
    }
}
