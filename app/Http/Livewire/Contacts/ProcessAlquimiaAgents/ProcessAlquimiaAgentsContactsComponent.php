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

    // --- NUEVAS PROPIEDADES para el chat dentro del modal ---
    public $chatKeys = [];           // lista de claves a preguntar (ej: ['nombreEmpresa','nombreProducto'])
    public $chatIndex = 0;           // índice actual en chatKeys
    public $chatHistory = [];        // [{type:'bot'|'user', text:'...'}]
    public $currentMessage = '';     // input del usuario en el chat
    public $isFinishedChat = false;  // true cuando ya respondió todas las claves
    public $tempGuideString = '';    // construye la cadena tipo "[$clave] = valor\n" que usará replaceVariables
    // -------------------------------------------------------

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
    }

    public function openChatModal($questionId)
    {
        $this->resetChat(); // limpia cualquier estado previo

        $this->currentQuestionId = $questionId;
        $question = ProcessAlquimiaAgentQuestion::find($questionId);
        if (!$question) {
            $this->chatHistory[] = ['type' => 'bot', 'text' => 'No se encontró la pregunta.'];
            $this->isFinishedChat = true;
            return;
        }

        $guide = $question->guide ?? '';
        $keys = $this->parseGuideToKeys($guide);

        $this->chatKeys = $keys;
        $this->chatIndex = 0;
        $this->chatHistory = [];

        if (!empty($this->chatKeys)) {
            $this->chatHistory[] = [
                'type' => 'bot',
                'text' => 'Hola, bienvenido a la generación con IA del agente AlquimIA, por favor ingresa la siguiente información para darte la mejor respuesta y asegurate de tener una buena conexion a internet:'
            ];

            $first = $this->chatKeys[0];
            $this->chatHistory[] = [
                'type' => 'bot',
                'text' => $first['label'] // ya no usamos humanizeKey
            ];
        } else {
            $this->chatHistory[] = [
                'type' => 'bot',
                'text' => 'No se encontraron variables en la guía. Puedes presionar Generar para usar el prompt tal cual.'
            ];
            $this->isFinishedChat = true;
        }

        $this->emit('scrollChatToBottom');
    }

    private function parseGuideToKeys($guide)
    {
        $keys = [];

        if (!$guide) {
            return $keys;
        }

        $decoded = json_decode($guide, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            foreach ($decoded as $key => $label) {
                $keys[] = ['key' => $key, 'label' => $label];
            }
            return $keys;
        }

        // fallback viejo formato
        preg_match_all('/\[\$(.*?)\]\s*=\s*(.*)/u', $guide, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            $keys[] = ['key' => $match[1], 'label' => $match[2] ?? $match[1]];
        }

        return $keys;
    }


    private function humanizeKey($key)
    {
        // Convierte camelCase / snake_case / kebab-case -> "Pretty label"
        $label = preg_replace('/([a-z])([A-Z])/', '$1 $2', $key); // camelCase -> space
        $label = str_replace(['_', '-'], ' ', $label);
        $label = trim($label);
        $label = mb_convert_case($label, MB_CASE_TITLE, "UTF-8");
        return $label;
    }

    public function sendChatAnswer()
    {
        $answer = trim($this->currentMessage);
        if ($answer === '') {
            return;
        }

        // Guardamos el mensaje del usuario en el historial
        $this->chatHistory[] = ['type' => 'user', 'text' => $answer];

        $current = $this->chatKeys[$this->chatIndex] ?? null;
        if ($current) {
            // Añadimos a la cadena temporal que usará replaceVariables
            $this->tempGuideString .= '[$' . $current['key'] . '] = ' . $answer . "\n";
        }

        $this->currentMessage = '';
        $this->chatIndex++;

        if ($this->chatIndex < count($this->chatKeys)) {
            $next = $this->chatKeys[$this->chatIndex];
            $this->chatHistory[] = [
                'type' => 'bot',
                'text' => $next['label'] // Usamos el texto humano del JSON
            ];
        } else {
            // Terminó el recorrido por claves
            $this->isFinishedChat = true;
            $this->chatHistory[] = [
                'type' => 'bot',
                'text' => 'He recibido todas tus respuestas. Pulsa "Generar" para enviar el prompt a la IA.'
            ];
        }

        // Emit para scroll en cliente
        $this->emit('scrollChatToBottom');
    }


    public function generateFromChat()
    {
        if (!$this->currentQuestionId) {
            $this->chatHistory[] = ['type' => 'bot', 'text' => 'Error interno: falta question id.'];
            return;
        }

        $question = ProcessAlquimiaAgentQuestion::find($this->currentQuestionId);
        if (!$question) {
            $this->chatHistory[] = ['type' => 'bot', 'text' => 'Error: no se encontró la pregunta.'];
            return;
        }

        // Reemplazamos usando la cadena construida por el chat (tempGuideString)
        $processedPrompt = $this->replaceVariables($question->prompt, $this->tempGuideString);

        // 🔹 Concatenamos contexto previo con preguntas ya respondidas
        $contextString = "";
        foreach ($this->questions as $q) {
            $resp = trim($this->answers[$q->id] ?? '');
            if ($resp === '' || $resp === '{}' || $resp === '[]') {
                continue; // saltar respuestas vacías
            }

            $decoded = json_decode($resp, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $flat = collect($decoded)->map(fn($v, $k) => "$k: $v")->join(", ");
                $contextString .= "- {$q->text}: {$flat}\n";
            } else {
                $contextString .= "- {$q->text}: {$resp}\n";
            }
        }

        $contextString = trim($contextString);
        if ($contextString !== "") {
            $processedPrompt .= "\n\nTen en cuenta también estas respuestas previas:\n" . $contextString;
        }


        $processAlquimiaAgent = ProcessAlquimiaAgent::find($this->processAlquimiaAgentId);
        $connection = $processAlquimiaAgent->alquimiaAgentConnection;

        if (!$connection) {
            $this->generatedText = "No hay conexión configurada.";
            $this->chatHistory[] = ['type' => 'bot', 'text' => 'No hay conexión configurada para enviar la petición a la IA.'];
            return;
        }
        set_time_limit(120);
        try {
            $this->chatHistory[] = ['type' => 'bot', 'text' => 'Enviando prompt a la IA...'];

            // Llamada al servicio AI
            /* dd($processedPrompt); */

            $processedPrompt = str_replace(['“', '”', '‘', '’'], '"', $processedPrompt);
            $result = $this->aiService->generateText($processedPrompt, $connection);
            $this->generatedText = $result ?: '';

            // Emitimos para reflejar en el textarea
            $this->emit('refreshGeneratedText', $this->generatedText);
            $this->chatHistory[] = ['type' => 'bot', 'text' => 'Respuesta recibida. Puedes editarla abajo y Aceptar.'];

            $this->emit('scrollChatToBottom');
        } catch (\Throwable $e) {
            $this->generatedText = "Error al generar texto: " . $e->getMessage();
            $this->chatHistory[] = ['type' => 'bot', 'text' => 'Error al llamar al servicio de IA.'];
        }
    }


    public function resetChat()
    {
        $this->chatKeys = [];
        $this->chatIndex = 0;
        $this->chatHistory = [];
        $this->currentMessage = '';
        $this->isFinishedChat = false;
        $this->tempGuideString = '';
        $this->generatedText = '';
        // Nota: no reseteamos generatedText aquí; se hace en cancel() si quieres.
        // Si ya hay una pregunta activa, recargamos el flujo desde la primera
        if ($this->currentQuestionId) {
            $question = ProcessAlquimiaAgentQuestion::find($this->currentQuestionId);
            if ($question) {
                $keys = $this->parseGuideToKeys($question->guide ?? '');
                $this->chatKeys = $keys;
                $this->chatIndex = 0;

                if (!empty($this->chatKeys)) {
                    $firstKey = $this->chatKeys[0];
                    // firstKey es array ['key'=>'...','label'=>'...']
                    $this->chatHistory[] = [
                        'type' => 'bot',
                        'text' => $firstKey['label'] // usar label (string)
                    ];
                } else {
                    $this->chatHistory[] = [
                        'type' => 'bot',
                        'text' => 'No se encontraron variables en la guía. Puedes presionar Generar para usar el prompt tal cual.'
                    ];
                    $this->isFinishedChat = true;
                }
            }
        }

        $this->emit('scrollChatToBottom');
    }



    public function generateWithAI($questionId, $answerValue)
    {
        // (Mantenemos la función pero por compatibilidad no la usamos desde el botón principal
        //  porque ahora abrimos el chat; si tienes llamadas externas a este método, podríamos adaptarlo)
        // Para evitar que se ejecute la IA por error, simplemente redirigimos a openChatModal:
        $this->openChatModal($questionId);
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
            $this->saveAnswers();
        }

        // cerramos modal en cliente
        $this->cancel();
    }


    private function replaceVariables($prompt, $answerValue)
    {
        // Separamos las respuestas por línea
        $lines = preg_split('/\r\n|\r|\n/', $answerValue);

        foreach ($lines as $item) {
            if (strpos($item, '=') !== false) {
                [$variable, $value] = array_map('trim', explode('=', $item, 2));

                // Normalizamos para asegurar que sea [$clave]
                $variable = preg_replace('/^\[\s*\$/', '[$', $variable);
                $variable = preg_replace('/\s*\]$/', ']', $variable);

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
                // Si no hay respuesta, deja el campo vacío
                $this->answers[$question->id] = '';
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
        $this->resetChat();
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
            $this->answers[$this->answerToGuide] = '';
        }

        $this->cancel();
    }
}
