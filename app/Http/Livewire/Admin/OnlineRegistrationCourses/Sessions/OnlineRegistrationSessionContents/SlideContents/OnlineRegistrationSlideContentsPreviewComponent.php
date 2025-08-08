<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\SlideContents;

use App\Models\OnlineRegistrationSessionContent;
use App\Models\OnlineRegistrationSlideContent;
use Livewire\Component;

class OnlineRegistrationSlideContentsPreviewComponent extends Component
{

    public $session_id;
    public $content;
    public $slide;
    public $title;
    public $description;
    public $instruction;
    public $banner_image;
    public $onlineRegistrationCourseSession;

    public function mount($id)
    {
        $this->content = OnlineRegistrationSessionContent::find($id);
        $this->onlineRegistrationCourseSession = $this->content->onlineRegistrationCourseSession;
        $this->title = $this->content->title;
        $this->description = $this->content->description;
        $this->slide = OnlineRegistrationSlideContent::where('content_id', $this->content->id)->first();
        $this->session_id = $this->content->session_id;

        if ($this->slide && $this->slide->banner_image) {
            $this->banner_image = asset('storage/' . $this->slide->banner_image);
        }
    }

    public function render()
    {
        return view('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.slide-contents.online-registration-slide-contents-preview-component');
    }
}
