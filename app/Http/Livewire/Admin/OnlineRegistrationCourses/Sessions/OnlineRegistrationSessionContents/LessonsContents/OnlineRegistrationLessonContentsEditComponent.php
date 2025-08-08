<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\LessonsContents;

use App\Models\OnlineRegistrationCourseSession;
use App\Models\OnlineRegistrationLessonContent;
use App\Models\OnlineRegistrationSessionContent;
use Livewire\Component;

class OnlineRegistrationLessonContentsEditComponent extends Component
{
    public $content;
    public $session_id;
    public $lesson;
    public $onlineRegistrationCourseSession;
    public $title;
    public $description;
    public $step;

    public function mount($id)
    {
        $this->content = OnlineRegistrationSessionContent::find($id);

        $this->onlineRegistrationCourseSession = $this->content->onlineRegistrationCourseSession;
        $this->session_id = $this->onlineRegistrationCourseSession;


        $this->title = $this->content->title;
        $this->description = $this->content->description;
        $this->step = $this->content->step;
    }
    public function render()
    {
        return view('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.lessons-contents.online-registration-lesson-contents-edit-component');
    }

    public function update($id)
    {
        $this->validate([
            'title' => 'required',
        ], [], [
            'title' => 'título',
        ]);

        $lastStep = OnlineRegistrationSessionContent::where('session_id', $this->session_id)->count();
        $content = OnlineRegistrationSessionContent::find($id);
        if ($content) {

            $content->title = $this->title;
            $content->description = $this->description;
            $content->type = 'L';
            $content->step = $this->step;            // Hace falta colocar el step pero quiero verlo con mas detalle
            $content->save();
        }

        return redirect()->route('online-registration-sessionContent', ['id' => $this->session_id])->with('success', 'El contenido de la lección se ha modificado correctamente.');
    }
}
