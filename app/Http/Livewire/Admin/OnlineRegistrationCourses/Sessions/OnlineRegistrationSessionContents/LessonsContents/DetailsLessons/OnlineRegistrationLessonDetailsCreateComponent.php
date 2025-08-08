<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\LessonsContents\DetailsLessons;

use App\Models\OnlineRegistrationLessonContent;
use App\Models\OnlineRegistrationLessonStep;
use App\Models\OnlineRegistrationSessionContent;
use Livewire\WithFileUploads;
use Livewire\Component;

class OnlineRegistrationLessonDetailsCreateComponent extends Component
{
    use WithFileUploads;
    public $content;
    public $or_lesson_id;
    public $session_id;
    public $lesson;
    public $onlineRegistrationCourseSession;
    public $searchName;
    public $lessonContent;
    public $lessonStep;
    public $image;
    public $title;
    public $parameter = true;
    public $align_image = "right";


    public function mount($id)
    {
        $this->or_lesson_id = $id;
        $this->lesson = OnlineRegistrationSessionContent::find($id);
        $this->onlineRegistrationCourseSession = $this->lesson->onlineRegistrationCourseSession;
        $this->session_id = $this->onlineRegistrationCourseSession;
        $this->lessonContent = OnlineRegistrationLessonContent::where('content_id', $this->lesson->id)->first();
        $this->lessonStep = OnlineRegistrationLessonStep::where('or_lesson_id', $this->lessonContent->id)->first();
    }
    public function render()
    {
        return view('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.lessons-contents.details-lessons.online-registration-lesson-details-create-component');
    }


    public function toggleApprovalForm()
    {
        $this->parameter = !$this->parameter;
        $this->align_image = $this->parameter ? 'right' : 'left';
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'required',

        ], [], [
            'title' => 'título',
            'content' => 'cuerpo',
            'image' => 'imagen',
        ]);

        $lessonStep = new OnlineRegistrationLessonStep();
        $lessonStep->title = $this->title;
        $lessonStep->order = OnlineRegistrationLessonStep::where('or_lesson_id', $this->lessonContent->id)->max('order') + 1;
        $lessonStep->body = $this->content;
        $lessonStep->or_lesson_id = $this->lessonContent->id;

        if ($this->image) {
            $filePath = $this->image->store('lesson', 'public');
        } else {
            $filePath = null;
        }
        $lessonStep->image = $filePath;
        $lessonStep->align_image = $this->align_image;
        $lessonStep->save();


        return redirect()->route('online-registration-lesson-content-detail', ['id' => $this->or_lesson_id])->with('success', 'El contenido de la lección se ha guardado correctamente.');
    }
}
