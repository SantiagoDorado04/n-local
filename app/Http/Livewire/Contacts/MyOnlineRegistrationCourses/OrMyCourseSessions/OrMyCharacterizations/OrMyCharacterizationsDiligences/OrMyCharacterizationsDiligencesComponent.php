<?php

namespace App\Http\Livewire\Contacts\MyOnlineRegistrationCourses\OrMyCourseSessions\OrMyCharacterizations\OrMyCharacterizationsDiligences;

use App\Contact;
use App\Models\OnlineRegistrationCharacterization;
use App\Models\OrAssignedCharacterization;
use App\Models\OrCharacterizationAnswer;
use App\Models\OrCharacterizationOption;
use App\Models\OrCharacterizationQuestion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrMyCharacterizationsDiligencesComponent extends Component
{

    protected $paginationTheme = 'bootstrap';

    public $searchName;

    public $answers = []; // <--- Agregar esta línea
    public $formId;
    public $form;
    public $questions;
    public $options;
    public $assignedCharacterizations;
    public $contactId;
    public $courseId;

    public $input;
    public $message = '';
    public $count = 1;


    public $stageActive = false;

    public function mount($id)
    {
        $characterization = OnlineRegistrationCharacterization::with('questions.options')->findOrFail($id);
        $this->formId = $characterization->id;
        $this->form = $characterization;
        $this->questions = $this->form->questions;
        $this->options = OrCharacterizationOption::whereIn('question_id', $this->questions->pluck('id'))->get();
        $this->courseId = $this->form->session->onlineRegistrationCourse->id;

        // Obtener usuario autenticado
        $user = Auth::user();
        $contact = Contact::where('user_id', '=', $user->id)->first();
        $this->contactId = $contact->id;

        if (Auth::check() && Auth::user()->role_id == 7) {
            $this->count = 2;
        }

        $this->questions = OrCharacterizationQuestion::where('characterization_id', $this->form->id)->get();

        // Inicializar answers correctamente
        $this->answers = [];
        foreach ($this->questions as $question) {
            $this->answers["question_{$question->id}"] = [];
        }

        // Cargar respuestas previas
        $savedAnswers = OrCharacterizationAnswer::where('contact_id', $this->contactId)
            ->where('characterization_id', $this->form->id)
            ->get();

        foreach ($savedAnswers as $answer) {
            $questionKey = "question_{$answer->question_id}";
            $this->answers[$questionKey] = explode(',', $answer->answer); // Convertimos string a array
        }

        $this->assignedCharacterizations = OrAssignedCharacterization::where('contact_id', $this->contactId)
            ->pluck('characterization_id')
            ->toArray();
    }



    public function render()
    {
        $answers = OrCharacterizationAnswer::where('contact_id', '=', $this->contactId)
            ->where('characterization_id', '=', $this->formId)
            ->get()
            ->keyBy('question_id');

        return view(
            'livewire.contacts.my-online-registration-courses.or-my-course-sessions.or-my-characterizations.or-my-characterizations-diligences.or-my-characterizations-diligences-component',
            [
                'form' => $this->form,
                'hasAnswers' => $answers->isNotEmpty(),
                'answers' => $answers
            ]
        );
    }

    public function submit()
    {
        $unansweredQuestions = [];

        foreach ($this->questions as $question) {
            $questionKey = "question_{$question->id}";

            if (!isset($this->answers[$questionKey]) || empty($this->answers[$questionKey])) {
                $unansweredQuestions[] = $question->id;
            }
        }

        if (!empty($unansweredQuestions)) {
            $this->emit('alert', ['type' => 'error', 'message' => 'Debes responder todas las preguntas antes de enviar.']);
            return;
        }

        $contactForm = OrAssignedCharacterization::where('contact_id', $this->contactId)
            ->where('characterization_id', $this->form->id)
            ->firstOrFail();
        $contactForm->answered = true;
        $contactForm->save();

        foreach ($this->questions as $question) {
            $questionKey = "question_{$question->id}";

            if (isset($this->answers[$questionKey])) {
                $answerValue = $this->answers[$questionKey];

                // Guardar la respuesta correctamente
                $this->saveAnswer($question->id, $answerValue);

                // 🔹 Convertir respuestas en array en caso de que sean múltiples
                $optionIds = is_array($answerValue) ? $answerValue : explode(',', $answerValue);

                // 🔹 Buscar todas las opciones seleccionadas en la BD
                $selectedOptions = OrCharacterizationOption::where('question_id', $question->id)
                    ->whereIn('id', $optionIds) // Asegurar que busque por ID, no por 'value'
                    ->get();

                // 🔹 Recorrer opciones y asignar caracterización si es condicional
                foreach ($selectedOptions as $option) {
                    if ($option->conditional && $option->characterization_id) {
                        $this->assignCharacterization($option->characterization_id);
                    }
                }
            }
        }

        $this->emit('alert', ['type' => 'success', 'message' => 'Formulario enviado correctamente.']);
    }







    private function saveAnswer($questionId, $answerValue)
    {
        OrCharacterizationAnswer::updateOrCreate(
            [
                'contact_id' => $this->contactId,
                'characterization_id' => $this->form->id,
                'question_id' => $questionId
            ],
            [
                'answer' => is_array($answerValue) ? implode(',', $answerValue) : $answerValue
            ]
        );
    }


    private function assignCharacterization($characterizationId)
    {
        if (!in_array($characterizationId, $this->assignedCharacterizations)) {
            OrAssignedCharacterization::create([
                'contact_id' => $this->contactId,
                'characterization_id' => $characterizationId
            ]);

            $this->assignedCharacterizations[] = $characterizationId;
        }
    }

    public function updated($propertyName, $value)
    {
        if (is_array($value)) {
            $this->answers[$propertyName] = array_values($value);
        } else {
            $this->answers[$propertyName] = $value;
        }
    }
}
