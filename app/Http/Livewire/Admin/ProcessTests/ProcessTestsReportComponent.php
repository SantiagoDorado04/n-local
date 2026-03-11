<?php

namespace App\Http\Livewire\Admin\ProcessTests;

use App\Models\ProcessTest;
use App\Models\ProcessContactTest;
use App\Models\ProcessTestQuestion;
use App\Models\ProcessTestAnswer;
use Livewire\Component;

class ProcessTestsReportComponent extends Component
{
    public $testId;
    public $test;
    public $questions;
    public $contactsWithAnswers = [];

    public function mount($id)
    {
        $this->testId = $id;
        $this->test = ProcessTest::find($id);
        $this->questions = ProcessTestQuestion::where('process_test_id', $id)->orderBy('position')->get();

        // Obtener contacts que respondieron
        $contactTests = ProcessContactTest::where('process_test_id', $id)->whereNotNull('date_completed')->get();

        foreach ($contactTests as $contactTest) {
            $contact = $contactTest->contact;
            $answers = ProcessTestAnswer::where('process_test_id', $id)
                ->where('contact_id', $contact->id)
                ->get()
                ->keyBy('p_test_question_id');

            $this->contactsWithAnswers[] = [
                'contact' => $contact,
                'answers' => $answers,
            ];
        }
    }

    public function render()
    {
        return view('livewire.admin.process-tests.process-tests-report-component', [
            'test' => $this->test,
            'questions' => $this->questions,
            'contactsWithAnswers' => $this->contactsWithAnswers,
        ]);
    }
}
