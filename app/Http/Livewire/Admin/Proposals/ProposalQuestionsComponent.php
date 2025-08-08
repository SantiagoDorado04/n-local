<?php

namespace App\Http\Livewire\Admin\Proposals;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\ProposalTemplatesQuestion;

class ProposalQuestionsComponent extends Component
{
    //vars question
    public $question,$key,
        $questionId;

    //var template
    public $templateId;

    public function mount($id)
    {
        //Get form
        $this->templateId = $id;
    }

    public function render()
    {
        //Get questions
        $questions = ProposalTemplatesQuestion::where('proposal_template_id', '=', $this->templateId)->get();

        return view('livewire.admin.proposals.proposal-questions-component', [
            'questions' => $questions
        ]);
    }

    public function store()
    {
        $this->validate([
            'question' => 'required|' . Rule::unique('proposal_templates_questions', 'question')->where(function ($query) {
                return $query->where('proposal_template_id', '=', $this->templateId);
            })
        ], [], [
            'question' => 'texto de pregunta',
        ]);

        //Save question
        $question = new ProposalTemplatesQuestion();
        $question->key= $this->key;
        $question->question = $this->question;
        $question->proposal_template_id = $this->templateId;
        $question->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Pregunta creada correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->questionId = $id;

        $question = ProposalTemplatesQuestion::find($id);
        $this->question = $question->question;
        $this->key = $question->key;
    }

    public function update()
    {
        $this->validate([
            'question' => 'required|' . Rule::unique('proposal_templates_questions', 'question')->where(function ($query) {
                return $query->where('proposal_template_id', '=', $this->templateId);
            })->ignore($this->questionId),
        ], [], [
            'question' => 'texto de pregunta',
        ]);

        //Save question
        $question = ProposalTemplatesQuestion::find($this->questionId);
        $question->question = $this->question;
        $question->key= $this->key;
        $question->proposal_template_id = $this->templateId;
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
        $question = ProposalTemplatesQuestion::find($this->questionId);
        $question->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Pregunta eliminada correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->question = '';
        $this->questionId='';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
