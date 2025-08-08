<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\VideosContents;

use App\Models\OnlineRegistrationSessionContent;
use App\Models\OnlineRegistrationVideoContent;
use Livewire\Component;

class OnlineRegistrationVideosContentsPreviewComponent extends Component
{
    public $session_id;
    public $content;
    public $videoContent;
    public $title;
    public $description;
    public $instruction;
    public $embedCode;
    public $onlineRegistrationCourseSession;

    public function mount($id)
    {
        $this->content = OnlineRegistrationSessionContent::find($id);
        $this->onlineRegistrationCourseSession = $this->content->onlineRegistrationCourseSession;
        $this->title = $this->content->title;
        $this->description = $this->content->description;
        $this->videoContent = OnlineRegistrationVideoContent::where('content_id', $this->content->id)->first();
        $this->session_id = $this->content->session_id;


        $this->instruction = $this->videoContent->instructions;
        $this->embedCode = $this->videoContent->embed;
    }
    public function render()
    {
        return view('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.videos-contents.online-registration-videos-contents-preview-component');
    }
}
