<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\LessonsContents;

use App\Models\OnlineRegistrationCourseSession;
use App\Models\OnlineRegistrationLessonContent;
use App\Models\OnlineRegistrationSessionContent;
use Livewire\Component;

class OnlineRegistrationLessonsContentsCreateComponent extends Component
{
    public $session_id;
    public $lesson;
    public $onlineRegistrationCourseSession;
    public $title;
    public $description;

    public function mount($id)
    {
        $this->session_id = $id;
        $this->onlineRegistrationCourseSession = OnlineRegistrationCourseSession::find($this->session_id);
    }
    public function render()
    {
        return view('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.lessons-contents.online-registration-lessons-contents-create-component');
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
        ], [], [
            'title' => 'título',
        ]);


        $content = new OnlineRegistrationSessionContent();
        $lastStep = OnlineRegistrationSessionContent::where('session_id', $this->session_id)->count();

        $content->title = $this->title;
        $content->description = $this->description;
        $content->type = 'L';
        $content->step = $lastStep + 1;        // Hace falta colocar el step pero quiero verlo con mas detalle
        $content->session_id = $this->session_id;
        $content->save();

        $lesson = new OnlineRegistrationLessonContent();
        $lesson->content_id = $content->id;
        $lesson->save();

        return redirect()->route('online-registration-sessionContent', ['id' => $this->session_id])->with('success', 'El contenido de la lección se ha guardado correctamente.');
    }
}
