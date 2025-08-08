<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\VideosContents;

use App\Models\OnlineRegistrationCourseSession;
use App\Models\OnlineRegistrationSessionContent;
use App\Models\OnlineRegistrationVideoContent;
use Livewire\Component;

class OnlineRegistrationVideosContentsEditComponent extends Component
{
    public $session_id;
    public $content;
    public $videoContent;
    public $title;
    public $description;
    public $instruction;
    public $step;
    public $embedCode;
    public $onlineRegistrationCourseSession;

    public function mount($id)
    {
        $this->content = OnlineRegistrationSessionContent::find($id);
        $this->onlineRegistrationCourseSession = $this->content->onlineRegistrationCourseSession;
        $this->title = $this->content->title;
        $this->description = $this->content->description;
        $this->step = $this->content->step;
        $this->videoContent = OnlineRegistrationVideoContent::where('content_id', $this->content->id)->first();
        $this->session_id = $this->content->session_id;


        $this->instruction = $this->videoContent->instructions;
        $this->embedCode = $this->videoContent->embed;
    }

    public function render()
    {
        return view('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.videos-contents.online-registration-videos-contents-edit-component');
    }

    public function update($id)
    {
        $this->validate([
            'title' => 'required',
            'embedCode' => 'required',
        ], [], [
            'title' => 'título',
            'embedCode' => 'embebido',
        ]);

        // Buscar si el contenido ya existe
        $content = OnlineRegistrationSessionContent::find($id);
        $Videocontent = OnlineRegistrationVideoContent::where('content_id', $id)->first();

        if ($content || $Videocontent) {
            $content->title = $this->title;
            $content->description = $this->description;
            $content->type = 'V';
            $content->step = $this->step;
            $content->save();

            $Videocontent->instructions = $this->instruction;
            $Videocontent->embed = $this->embedCode;
            $Videocontent->save();
        }

        return redirect()->route('online-registration-sessionContent', ['id' => $this->session_id])
            ->with('success', 'El contenido de video se ha actualizado correctamente.');
    }
}
