<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\TestContents;

use App\Models\OnlineRegistration;
use App\Models\OnlineRegistrationContactTest;
use App\Models\OnlineRegistrationTestChoice;
use App\Models\OnlineRegistrationTestContent;
use App\Models\OnlineRegistrationTestItem;
use App\Models\OnlineRegistrationTestResponse;
use Livewire\Component;

class OnlineRegistrationTestContentsResultsComponent extends Component
{
    public $test_id;
    public $test;
    public $testId;
    public $userRegistered;
    public $questions = [];
    public $responses = [];
    public $contactId;
    public $responseText = [];
    public $is_correct_Text;


    public function mount($id)
    {
        $this->test_id = $id;
    }
    public function render()
    {
        $this->test = OnlineRegistrationTestContent::find($this->test_id);
        $this->userRegistered = OnlineRegistrationContactTest::where('or_test_id', $this->test_id)
            ->get();
        return view('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.test-contents.online-registration-test-contents-results-component');
    }

    public function show($testId, $contactId)
    {
        $this->contactId = $contactId;

        $this->questions = OnlineRegistrationTestItem::where('or_test_id', $testId)
            ->with('choices')
            ->orderBy('position')
            ->get();

        $this->responses = OnlineRegistrationTestResponse::where('or_test_id', $testId)
            ->where('contact_id', $contactId)
            ->get();

         foreach ($this->responses as $response) {
           // $this->responseText = OnlineRegistrationTestChoice::where('id', $response->response)->pluck('text');
            $this->responseText = $this->responses->map(function ($response) {
                return OnlineRegistrationTestChoice::where('id', $response->response)->pluck('text')->first();
            })->toArray(); // Convertir el resultado final a un array
        }

    }
    public function cancel()
    {
        $this->responseText = [];
        $this->is_correct_Text = null;
        $this->emit('close-modal');
    }
}
