<?php

namespace App\Http\Livewire\Contacts\Interviews;

use App\Contact;
use App\Interview;
use App\Models\Step;
use Livewire\Component;
use App\Services\PlayHuntService;
use Illuminate\Support\Facades\Auth;

class InterviewsContactsComponent extends Component
{
    public $contactId, $step, $stepId;

    protected $playHuntService;

    public $guid, $interview, $url;

    public $stageActive = false;

    public function mount($id)
    {
        $contact = Contact::where('user_id', '=', Auth::user()->id)->first();
        $this->contactId = $contact->id;

        $this->stepId = $id;

        $step = Step::find($id);

        if ($step->stage->active == 1) {
            $this->stageActive = true;
        }

        $this->step = Step::find($this->stepId);

        $interview = Interview::where('step_id', '=', $this->stepId)->first();
        $this->guid = $interview->interview;

        $this->playHuntService = new PlayHuntService();

        $this->loadInterview();
    }

    public function loadInterview()
    {
        try {
            $this->interview = $this->playHuntService->getInterview($this->guid);
            $this->url = $this->interview['url'];
        } catch (\Exception $e) {
            $this->interview = null;
        }
    }


    public function render()
    {
        return view('livewire.contacts.interviews.interviews-contacts-component', [
            'url' => $this->url
        ]);
    }
}
