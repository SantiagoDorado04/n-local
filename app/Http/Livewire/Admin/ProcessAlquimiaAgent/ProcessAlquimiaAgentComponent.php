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

    protected $listeners = ['reorderGuideFields'];


    public $guideFields = [];
    public $newGuideText;

    public $selectedQuestions = []; // IDs de preguntas seleccionadas
    public $questionsJson = ''; // JSON final con los IDs
    public $questionToAdd; // ID de la pregunta seleccionada en el select


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
            'guide' => 'sometimes|nullable|string',
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
        $question->contexts = $this->questionsJson ?: json_encode([]);
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

        // Convertir el JSON de guide a array
        $this->guideFields = $question->guide ? json_decode($question->guide, true) : [];
        $this->updateGuideJson(); // 👈 asegura que también se refleje en $this->guide


        // cargar contexts si existen
        $this->selectedQuestions = $question->contexts ? json_decode($question->contexts, true) : [];
        $this->updateQuestionsJson(); // 🔥 importante
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
        $question->contexts = $this->questionsJson ?: json_encode([]);
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
        $this->guideFields = [];
        $this->newGuideText = '';
    }

    private function convertToVariable($text)
    {
        $lowercaseText = strtolower($text);
        $underscoredText = str_replace(' ', '_', $lowercaseText);
        $variable = '${' . $underscoredText . '}';
        return $variable;
    }

    public function addGuideField()
    {
        if (!$this->newGuideText) {
            return;
        }

        $variable = $this->sanitizeVariable($this->newGuideText);

        $this->guideFields[$variable] = $this->newGuideText;
        $this->newGuideText = '';

        $this->updateGuideJson();
    }

    public function removeGuideField($variable)
    {
        unset($this->guideFields[$variable]);
        $this->updateGuideJson();
    }

    public function reorderGuideFields($orderedKeys)
    {
        $newOrder = [];
        foreach ($orderedKeys as $key) {
            if (isset($this->guideFields[$key])) {
                $newOrder[$key] = $this->guideFields[$key];
            }
        }
        $this->guideFields = $newOrder;
        $this->updateGuideJson();
    }

    private function updateGuideJson()
    {
        $this->guide = json_encode($this->guideFields, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    private function sanitizeVariable($text)
    {
        $text = strtolower($text);
        $text = preg_replace('/[áàäâ]/u', 'a', $text);
        $text = preg_replace('/[éèëê]/u', 'e', $text);
        $text = preg_replace('/[íìïî]/u', 'i', $text);
        $text = preg_replace('/[óòöô]/u', 'o', $text);
        $text = preg_replace('/[úùüû]/u', 'u', $text);
        $text = preg_replace('/[^a-z0-9]/u', '', $text);
        return $text;
    }

    public function addQuestionToList()
    {
        if (!$this->questionToAdd) {
            return;
        }

        // 🚫 Evitar agregar la misma pregunta que estoy editando
        if ($this->questionToAdd == $this->questionId) {
            $this->emit('alert', ['type' => 'warning', 'message' => 'No puedes seleccionar la misma pregunta como contexto.']);
            $this->questionToAdd = null;
            return;
        }

        // 🚫 Evitar duplicados
        if (!in_array($this->questionToAdd, $this->selectedQuestions)) {
            $this->selectedQuestions[] = $this->questionToAdd;
        }

        $this->questionToAdd = null; // reset select
        $this->updateQuestionsJson();
    }

    public function removeQuestionFromList($id)
    {
        $this->selectedQuestions = array_filter(
            $this->selectedQuestions,
            fn($q) => $q != $id
        );

        $this->updateQuestionsJson();
    }

    private function updateQuestionsJson()
    {
        $this->questionsJson = json_encode(array_values($this->selectedQuestions), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
