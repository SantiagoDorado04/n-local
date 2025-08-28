<?php

namespace App\Http\Livewire\Contacts\ProcessAlquimiaAgents;

use App\Contact;
use App\Models\ProcessAlquimiaAgent;
use App\Models\ProcessAlquimiaAgentAnswer;
use App\Models\ProcessAlquimiaAgentQuestion;
use App\Models\Step;
use App\Services\AIService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use PhpOffice\PhpWord\TemplateProcessor;

class ProcessAlquimiaAgentsContactsComponent extends Component
{
    protected $paginationTheme = 'bootstrap';

    public $searchName;

    public $stepId;
    public $questions;
    public $contactId;

    public $answers = [];
    public $count = 1;

    public $processAlquimiaAgentId;


    // protected AI Service;

    protected $aiService;

    public $stageActive = false;

    public $step = '';

    public $generatedText = '';

    public $currentQuestionId = null;

    public $answerToGuide = null;

    protected $listeners = [
        'generatedTextChanged' => 'handleGeneratedTextChanged',
    ];

    public function __construct()
    {
        $this->aiService = new AIService();
    }

    public function render()
    {
        $processAlquimiaAgent = ProcessAlquimiaAgent::with('step.stage.process')
            ->findOrFail($this->processAlquimiaAgentId);
        return view('livewire..contacts.process-alquimia-agents.process-alquimia-agents-contacts-component', [
            'processAlquimiaAgent' => $processAlquimiaAgent
        ]);
    }

    public function mount($id)
    {

        $this->stepId = $id;
        $step = Step::with('processAlquimiaAgent')->findOrFail($id);
        $this->step = $step;

        if ($step->stage->active == 1) {
            $this->stageActive = true;
        }

        $processAlquimiaAgent = ProcessAlquimiaAgent::where('step_id', $step->id)->first();

        if (!$processAlquimiaAgent) {
            abort(404, 'No se encontró el Agente AlquimIA para este paso');
        }

        $this->processAlquimiaAgentId = $processAlquimiaAgent->id;
        $this->questions = $processAlquimiaAgent->questions;

        if (Auth::check() && (Auth::user()->role_id == 7 || Auth::user()->role_id == 4)) {
            $this->count = 2;
            $this->contactId = Auth::user()->contact->id;
        }

        // Cargar respuestas existentes
        $this->loadAnswers();

        $contact = Contact::find($this->contactId);
    }



    public function generateWithAI($questionId, $answerValue)
    {
        $this->currentQuestionId = $questionId;

        $question = ProcessAlquimiaAgentQuestion::find($questionId);
        if (!$question) {
            return;
        }

        $processedPrompt = $this->replaceVariables($question->prompt, $answerValue);

        $processAlquimiaAgent = ProcessAlquimiaAgent::find($this->processAlquimiaAgentId);
        $connection = $processAlquimiaAgent->alquimiaAgentConnection;

        if (!$connection) {
            $this->generatedText = "No hay conexión configurada.";
        } else {
            // LLAMA AL SERVICIO -> sin dd()
            $result = $this->aiService->generateText($processedPrompt, $connection);
            $this->generatedText = $result;
        }

        sleep(2);

        // Emitimos para que el editor del modal lo reciba
        $this->emit('refreshGeneratedText', $this->generatedText);

        // Abrimos modal desde el cliente (evita race conditions)
        $this->dispatchBrowserEvent('open-modal', ['id' => 'show-modal']);
    }

    public function handleGeneratedTextChanged($value)
    {
        // Actualizamos la propiedad cuando el editor cambie (JS -> Livewire)
        $this->generatedText = $value;
    }


    public function storeGeneratedText()
    {
        if ($this->currentQuestionId) {
            $this->answers[$this->currentQuestionId] = $this->generatedText;
        }

        // cerramos modal en cliente
        $this->cancel();
    }


    private function replaceVariables($prompt, $answerValue)
    {
        // Aquí $answerValue ya es un string, no un array
        // Si quieres que soporte formato tipo: "[var] = valor"
        $lines = preg_split('/\r\n|\r|\n/', $answerValue); // separar por saltos de línea

        foreach ($lines as $item) {
            if (strpos($item, '=') !== false) {
                [$variable, $value] = array_map('trim', explode('=', $item, 2));
                $prompt = str_replace($variable, $value, $prompt);
            }
        }

        return $prompt;
    }



    public function loadAnswers()
    {
        // Respuestas ya guardadas
        $existingAnswers = ProcessAlquimiaAgentAnswer::where('process_alquimia_agent_id', $this->processAlquimiaAgentId)
            ->where('contact_id', $this->contactId)
            ->get()
            ->keyBy('paa_question_id'); // clave por question_id para acceso rápido

        foreach ($this->questions as $question) {
            if (isset($existingAnswers[$question->id])) {
                // Si hay respuesta en BD, úsala
                $this->answers[$question->id] = $existingAnswers[$question->id]->answer;
            } else {
                // Si no hay respuesta, ponemos el "guide" de la pregunta (si existe)
                $this->answers[$question->id] = $question->guide ?? '';
            }
        }
    }


    private function sanitizeAnswer($answer)
    {
        $sanitizedAnswer = str_replace(
            ['&', '<', '>', '"', "'", '/', '\\', '|', ':', ';', '*', '?', '#', '%', '='],
            ' ',
            $answer
        );
        return $sanitizedAnswer;
    }

    public function saveAnswers()
    {
        foreach ($this->questions as $question) {
            $sanitizedAnswer = $this->sanitizeAnswer($this->answers[$question->id] ?? '');

            ProcessAlquimiaAgentAnswer::updateOrCreate(
                [
                    'contact_id' => $this->contactId,
                    'process_alquimia_agent_id' => $this->processAlquimiaAgentId,
                    'paa_question_id' => $question->id,
                ],
                [
                    'answer' => $sanitizedAnswer,
                ]
            );
        }

        $this->emit('alert', ['type' => 'success', 'message' => '¡Respuestas almacenadas correctamente!']);
    }

    public function downloadTemplate()
    {
        $processAlquimiaAgent = ProcessAlquimiaAgent::find($this->processAlquimiaAgentId);
        if ($processAlquimiaAgent && $processAlquimiaAgent->url_file) {
            $filePath = storage_path('app/' . $processAlquimiaAgent->url_file);
            $templateProcessor = new TemplateProcessor($filePath);

            $questions = $processAlquimiaAgent->questions;

            foreach ($questions as $question) {
                $variableName = $this->convertToVariable($question->text);
                $answer = ProcessAlquimiaAgentAnswer::where('contact_id', $this->contactId)
                    ->where('process_alquimia_agent_id', $processAlquimiaAgent->id)
                    ->where('paa_question_id', $question->id)
                    ->first();

                $answerText = $answer ? $answer->answer : '';
                $templateProcessor->setValue($variableName, $answerText);
            }

            $contact = Auth::user()->contact;
            $fileName = $contact->nit . '_' . $contact->name . '_' . $processAlquimiaAgent->step->name . '_' . date('Y-m-d_H-i-s') . '.docx';
            $newFilePath = storage_path('app/templates/' . $fileName);
            $templateProcessor->saveAs($newFilePath);

            return response()->download($newFilePath)->deleteFileAfterSend(true);
        }

        session()->flash('error', 'No se pudo encontrar la plantilla.');
    }

    private function convertToVariable($text)
    {
        // Convertir la cadena a minúsculas
        $lowercaseText = strtolower($text);

        // Reemplazar espacios en blanco por guiones bajos
        $underscoredText = str_replace(' ', '_', $lowercaseText);

        // Envolver en ${}
        $variable = '${' . $underscoredText . '}';

        return $variable;
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }

    public function resetInputFields()
    {
        $this->generatedText = '';
        $this->currentQuestionId = null;
        $this->answerToGuide = null;
    }

    public function resetAnswerToGuide($questionId)
    {
        $this->answerToGuide = $questionId;
    }

    public function confirmToGuide()
    {
        $question = ProcessAlquimiaAgentQuestion::find($this->answerToGuide);
        if ($question) {
            // Si tiene guide, lo asigna. Si no, lo deja vacío
            $this->answers[$this->answerToGuide] = $question->guide ?? '';
        }

        $this->cancel();
    }
}
