<?php

namespace App\Http\Livewire\Contacts\Canvas;


use App\Canva;
use App\Prompt;
use App\Contact;
use App\Models\Step;
use Livewire\Component;
use App\Models\InformationForm;
use App\Services\OpenAIService;
// use App\Services\MistralService;
use App\Services\DeepSeekService;
use Illuminate\Support\Facades\Auth;
use App\Models\InformationFormAnswer;
use PhpOffice\PhpWord\TemplateProcessor;

class CanvasContactsComponent extends Component
{
    protected $paginationTheme = 'bootstrap';

    public $searchName;

    public $formId;
    public $stepId;
    public $form;
    public $questions;
    public $options;
    public $contactId;

    public $answers = [];
    public $message = '';
    public $count = 1;

    public $canvaId;


    //AI services:
    protected $openAIService;

    // protected $mistralService;

    protected $deepSeekService;

    public $response = [];

    public $prompt;

    public $stageActive = false;

    public function __construct()
    {
        // $this->openAIService = new OpenAIService();
        // $this->mistralService = new MistralService();
        $this->deepSeekService = new DeepSeekService();
    }

    public function mount($id)
    {

        $step = Step::with('informationForm')->findOrFail($id);

        if ($step->stage->active == 1) {
            $this->stageActive = true;
        }

        $canva = Canva::where('step_id', '=', $step->id)->first();
        $this->canvaId = $canva->id;
        $this->formId = $canva->information_form_id;
        $this->form = InformationForm::find($this->formId);
        $this->questions = $this->form->questions;

        $this->stepId = $canva->step_id;

        if (Auth::check() && (Auth::user()->role_id == 7 || Auth::user()->role_id == 4)) {
            $this->count = 2;
            $this->contactId = Auth::user()->contact->id;
        }

        // Cargar respuestas existentes
        $this->loadAnswers();

        $contact = Contact::find($this->contactId);
        $promptBd = Prompt::where('module', '=', 'canvas')->first();
        $basePrompt = $promptBd->text;

        $this->prompt = $this->generatePrompt($basePrompt, $contact);
    }

    public function generatePrompt($basePrompt, $contact)
    {
        preg_match_all('/@@(\w+)@@/', $basePrompt, $matches);

        foreach ($matches[1] as $field) {
            if (isset($contact->$field)) {
                $basePrompt = str_replace("@@$field@@", $contact->$field, $basePrompt);
            } else {
                $basePrompt = str_replace("@@$field@@", '(Ingrese aquí su información)', $basePrompt);
            }
        }

        return $basePrompt;
    }

    public function loadAnswers()
    {
        $existingAnswers = InformationFormAnswer::where('information_form_id', $this->formId)
            ->where('contact_id', $this->contactId)
            ->get();

        foreach ($existingAnswers as $answer) {
            $this->answers[$answer->question_id] = $answer->answer;
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

            InformationFormAnswer::updateOrCreate(
                [
                    'contact_id' => $this->contactId,
                    'information_form_id' => $this->formId,
                    'question_id' => $question->id,
                ],
                [
                    'answer' => $sanitizedAnswer,
                ]
            );
        }

        $this->emit('alert', ['type' => 'success', 'message' => '¡Respuestas almacenadas correctamente!']);
    }

    public function render()
    {
        $canva = Canva::where('step_id', '=', $this->stepId)->first();
        return view('livewire.contacts.canvas.canvas-contacts-component', [
            'canva' => $canva
        ]);
    }

    public function downloadTemplate()
    {
        $canva = Canva::find($this->canvaId);
        if ($canva && $canva->url_file) {
            $filePath = storage_path('app/' . $canva->url_file);
            $templateProcessor = new TemplateProcessor($filePath);

            $form = InformationForm::find($canva->information_form_id);
            $questions = $form->questions;

            foreach ($questions as $question) {
                $variableName = $this->convertToVariable($question->text);
                $answer = InformationFormAnswer::where('contact_id', $this->contactId)
                    ->where('information_form_id', $form->id)
                    ->where('question_id', $question->id)
                    ->first();

                $answerText = $answer ? $answer->answer : '';
                $templateProcessor->setValue($variableName, $answerText);
            }

            $contact = Auth::user()->contact;
            $fileName = $contact->nit . '_' . $contact->name . '_' . $canva->step->name . '_' . date('Y-m-d_H-i-s') . '.docx';
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

    // public function generateText($text)
    // {

    //     $prompt = $text;
    //     $options = [
    //         'max_tokens' => 150,
    //         'temperature' => 0.7
    //     ];

    //     $generatedText = $this->openAIService->generateText($prompt, $options);

    //     $this->response = $generatedText;
    // }

    // public function generateMistralText($text, $questionId)
    // {
    //     $generatedText = $this->mistralService->generateText($this->prompt . ' ' . $text);
    //     $this->answers[$questionId] = $generatedText;
    // }

    public function generateDeepSeekText($text, $questionId)
    {
        $generatedText = $this->deepSeekService->generateText($this->prompt . ' ' . $text);
        $this->answers[$questionId] = $generatedText;
    }


}
