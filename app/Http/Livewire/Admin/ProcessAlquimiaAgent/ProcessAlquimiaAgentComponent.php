<?php

namespace App\Http\Livewire\Admin\ProcessAlquimiaAgent;

use App\Models\ProcessAlquimiaAgent;
use App\Models\ProcessAlquimiaAgentQuestion;
use App\Models\Step;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProcessAlquimiaAgentComponent extends Component
{

    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $stepId;
    public $template;
    public $agentId, $questionId, $text, $prompt, $guide, $position;


    public function mount($id)
    {
        $this->stepId = $id;
        $this->agentId = ProcessAlquimiaAgent::where('step_id', $this->stepId)->first()->id;
    }

    public function render()
    {

        $step = Step::find($this->stepId);
        $agent = ProcessAlquimiaAgent::where('step_id', $this->stepId)->first();
        $questions = ProcessAlquimiaAgentQuestion::where('process_alquimia_agent_id', '=', $agent->id)->get();


        return view('livewire..admin.process-alquimia-agent.process-alquimia-agent-component', [
            'step' => $step,
            'agent' => $agent,
            'questions' => $questions,
            'convertToVariable' => fn($text) => $this->convertToVariable($text),
        ]);
    }

    public function upload()
    {

        $this->validate([
            'template' => 'required|file|mimes:doc,docx',
        ]);

        $path = $this->template->store('templates');

        $agent = ProcessAlquimiaAgent::where('step_id', '=', $this->stepId)->first();
        if ($agent) {
            $agent->url_file = $path;
            $agent->save();
        }

        $this->emit('alert', ['type' => 'success', 'message' => 'Archivo cargado correctamente']);
    }

    public function downloadTemplate()
    {
        $agent = ProcessAlquimiaAgent::where('step_id', $this->stepId)->first();
        if ($agent && $agent->url_file) {
            $filePath = storage_path('app/' . $agent->url_file);
            return response()->download($filePath);
        }
    }

    public function store()
    {
        $this->validate([
            'text' => [
                'required',
                Rule::unique('process_alquimia_agent_questions', 'text')->where(function ($query) {
                    return $query->where('process_alquimia_agent_id', '=', $this->agentId);
                }),
            ],
            'prompt' => 'required|string',
            'guide' => 'required|string',
        ], [], [
            'text' => 'texto',
            'prompt' => 'prompt',
            'guide' => 'guía',
        ]);

        if ($this->position == '') {
            $maxPosition = ProcessAlquimiaAgentQuestion::where('process_alquimia_agent_id', $this->agentId)->max('position');
            $this->position = is_null($maxPosition) ? 1 : $maxPosition + 1;
        }

        $question = new ProcessAlquimiaAgentQuestion();
        $question->text = $this->text;
        $question->position = $this->position;
        $question->prompt = $this->prompt;
        $question->guide = $this->guide;
        $question->process_alquimia_agent_id = $this->agentId;
        $question->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Pregunta creada correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->questionId = $id;

        $question = ProcessAlquimiaAgentQuestion::find($id);
        $this->text = $question->text;
        $this->prompt = $question->prompt;
        $this->position = $question->position;
    }

    public function update()
    {

        $this->validate([
            'text' => 'required|unique:process_alquimia_agent_questions,text,' . $this->questionId,
            'prompt' => 'sometimes|nullable|string',
            'guide' => 'sometimes|nullable|string',
        ], [], [
            'text' => 'texto',
            'prompt' => 'prompt',
            'guide' => 'guía',
        ]);

        $question = ProcessAlquimiaAgentQuestion::find($this->questionId);
        $question->text = $this->text;
        $question->prompt = $this->prompt;
        $question->guide = $this->guide;
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
        $question = ProcessAlquimiaAgentQuestion::find($this->questionId);
        $question->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Pregunta eliminada correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->text = '';
        $this->prompt = '';
        $this->guide = '';
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

    private function convertToVariable($text)
    {
        $lowercaseText = strtolower($text);
        $underscoredText = str_replace(' ', '_', $lowercaseText);
        $variable = '${' . $underscoredText . '}';
        return $variable;
    }
}
