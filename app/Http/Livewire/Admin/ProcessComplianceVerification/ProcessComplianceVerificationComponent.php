<?php

namespace App\Http\Livewire\Admin\ProcessComplianceVerification;

use App\Models\PComplianceVerificationQuestion;
use App\Models\ProcessComplianceVerification;
use App\Models\Step;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProcessComplianceVerificationComponent extends Component
{

    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $stepId;
    public $complianceId, $questionId, $text, $position;

    public function mount($id)
    {
        $this->stepId = $id;
        $this->complianceId = ProcessComplianceVerification::where('step_id', $this->stepId)->first()->id;
    }

    public function render()
    {

        $step = Step::find($this->stepId);
        $compliance = ProcessComplianceVerification::where('step_id', $this->stepId)->first();
        $questions = PComplianceVerificationQuestion::where('pc_verification_id', '=', $compliance->id)->get();

        return view('livewire..admin.process-compliance-verification.process-compliance-verification-component', [
            'step' => $step,
            'compliance' => $compliance,
            'questions' => $questions,
        ]);
    }

    public function store()
    {
        $this->validate([
            'text' => [
                'required',
                Rule::unique('p_compliance_verification_questions', 'text')->where(function ($query) {
                    return $query->where('pc_verification_id', '=', $this->complianceId);
                }),
            ],
        ], [], [
            'text' => 'texto',
        ]);

        if ($this->position == '') {
            $maxPosition = PComplianceVerificationQuestion::where('pc_verification_id', $this->complianceId)->max('position');
            $this->position = is_null($maxPosition) ? 1 : $maxPosition + 1;
        }

        $question = new PComplianceVerificationQuestion();
        $question->text = $this->text;
        $question->position = $this->position;
        $question->pc_verification_id = $this->complianceId;
        $question->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Pregunta creada correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->questionId = $id;

        $question = PComplianceVerificationQuestion::find($id);
        $this->text = $question->text;
        $this->position = $question->position;
    }


    public function update()
    {

        $this->validate([
            'text' => 'required|unique:process_alquimia_agent_questions,text,' . $this->questionId,
        ], [], [
            'text' => 'texto',
        ]);

        $question = PComplianceVerificationQuestion::find($this->questionId);
        $question->text = $this->text;
        $question->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Pregunta actualizada correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->questionId = $id;
    }

    public function destroy()
    {
        $question = PComplianceVerificationQuestion::find($this->questionId);
        $question->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Pregunta eliminada correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->text = '';
        $this->position = '';
        $this->questionId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
