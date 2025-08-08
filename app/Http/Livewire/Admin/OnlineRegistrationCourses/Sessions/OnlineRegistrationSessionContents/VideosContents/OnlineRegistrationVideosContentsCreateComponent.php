<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\VideosContents;

use App\Models\OnlineRegistrationCourse;
use App\Models\OnlineRegistrationCourseSession;
use App\Models\OnlineRegistrationSessionContent;
use App\Models\OnlineRegistrationVideoContent;
use Livewire\Component;

class OnlineRegistrationVideosContentsCreateComponent extends Component
{
    public $session_id;
    public $onlineRegistrationCourseSession;
    public $onlineRegistrationCourse;
    public $embedCode;
    public $title;
    public $description;
    public $instruction;
    public $sessions_contents;

    public function mount($id)
    {

        $this->session_id = $id;
        $this->onlineRegistrationCourseSession = OnlineRegistrationCourseSession::find($this->session_id);
    }

    public function render()
    {
        return view('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.videos-contents.online-registration-videos-contents-create-component');
    }


    public function store()
    {
        $this->validate([
            'title' => 'required',
            'embedCode' => 'required',
        ], [], [
            'title' => 'título',
            'embedCode' => 'embebido',
        ]);

        $lastStep = OnlineRegistrationSessionContent::where('session_id', $this->session_id)->count();

        $content = new OnlineRegistrationSessionContent();
        $content->title = $this->title;
        $content->description = $this->description;
        $content->type = 'V';
        $content->step = $lastStep + 1;
        // Hace falta colocar el step pero quiero verlo con mas detalle
        $content->session_id = $this->session_id;
        $content->save();

        $video = new OnlineRegistrationVideoContent();
        $video->content_id = $content->id;
        $video->instructions = $this->instruction;
        $video->embed = $this->embedCode;
        $video->save();

        return redirect()->route('online-registration-sessionContent', ['id' => $this->session_id])->with('success', 'El contenido de video se ha guardado correctamente.');
    }
}
