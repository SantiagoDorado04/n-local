<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents;

use App\Models\OnlineRegistration;
use App\Models\OnlineRegistrationCourseSession;
use App\Models\OnlineRegistrationLessonContent;
use App\Models\OnlineRegistrationLessonStep;
use App\Models\OnlineRegistrationSessionContent;
use App\Models\OnlineRegistrationSlideContent;
use App\Models\OnlineRegistrationTestChoice;
use App\Models\OnlineRegistrationTestContent;
use App\Models\OnlineRegistrationTestItem;
use App\Models\OnlineRegistrationVideoContent;
use Livewire\Component;

class OnlineRegistratioSessionContentsPreviewComponent extends Component
{
    public $sessionContent;
    public $onlineRegistrationCourseSession;
    public $OnlineRegistrationSessionContent;

    public $type;
    public $titleV, $descriptionV, $instructionV, $embedCode, $image;
    public $titleS, $descriptionS, $banner_image;
    public $titleL, $descriptionL, $existingFile, $parameter, $align_image, $content;
    public $lessonContent;
    public $currentStepIndex = 0;
    public $currentLessonStepIndex = 0;
    public $titleT;
    public $descriptionT;
    public $test_id;
    public $test;
    public $items;
    public $choices = [];
    public $cant = 0;
    public $count = 1;
    public $responses = [];
    public $score = 0;
    public $showResults = false;
    public $testPassed = false;
    public $session;


    /*  public $title;
    public $content;
    public $align_image;
    public $parameter;
    public $existingFile; */


    public function mount($id)
    {
        $this->sessionContent = OnlineRegistrationSessionContent::where('session_id', $id)->first();
        $this->onlineRegistrationCourseSession = OnlineRegistrationCourseSession::where('id', $id)->first();

        // $this->onlineRegistrationCourseSession = $this->sessionContent->onlineRegistrationCourseSession;
        //dd($this->onlineRegistrationCourseSession);


        $this->OnlineRegistrationSessionContent = OnlineRegistrationSessionContent::where('session_id', $id)
            ->orderBy('step', 'asc')
            ->get();

        $this->lessonContent = collect([]); // Inicializa como colección vacía
        $this->currentLessonStepIndex = 0;

        $this->loadStep();
    }

    public function render()
    {
        return view('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.online-registratio-session-contents-preview-component');
    }

    public function loadStep()
    {
        if ($this->currentStepIndex >= count($this->OnlineRegistrationSessionContent)) {
            $this->type = 'fin'; // Tipo especial para el mensaje de "Fin"
            if ($this->sessionContent == null) {
                $this->type = '';
            }
            return;
        }
        if (isset($this->OnlineRegistrationSessionContent[$this->currentStepIndex])) {
            $content = $this->OnlineRegistrationSessionContent[$this->currentStepIndex];
            $this->type = $content->type;

            if ($content->type == 'V') {
                $this->titleV = $content->title;
                $this->descriptionV = $content->description;
                $video = OnlineRegistrationVideoContent::where('content_id', $content->id)->first();
                $this->instructionV = $video->instructions ?? 'Sin instrucciones';
                $this->embedCode = $video->embed ?? null;
            } elseif ($content->type == 'S') {
                $this->titleS = $content->title;
                $this->descriptionS = $content->description;
                $slide = OnlineRegistrationSlideContent::where('content_id', $content->id)->first();
                $this->banner_image = $slide && $slide->banner_image ? asset('storage/' . $slide->banner_image) : null;
            } elseif ($content->type == 'L') {
                $this->titleL = $content->title;
                $this->descriptionL = $content->description;
                $lesson = OnlineRegistrationLessonContent::where('content_id', $content->id)->first();
                if ($lesson) {
                    // Obtén los pasos de la lección
                    $this->lessonContent = OnlineRegistrationLessonStep::where('or_lesson_id', $lesson->id)
                        ->orderBy('order', 'asc')
                        ->get();

                    $this->currentLessonStepIndex = 0; // Reinicia el índice de los pasos

                    if ($this->lessonContent->isNotEmpty()) {
                        $step = $this->lessonContent[$this->currentLessonStepIndex];
                        $this->titleL = $step->title;
                        $this->content = $step->body;
                        $this->align_image = $step->align_image;
                        $this->parameter = ($this->align_image == "left") ? false : true;
                        $this->existingFile = $step->image ? asset('storage/' . $step->image) : null;
                    }
                }
            } elseif ($content->type == 'T') {
                $this->titleT = $content->title;
                $this->descriptionT = $content->description;

                $test = OnlineRegistrationTestContent::where('content_id', $content->id)->first();
                if ($test) {
                    $this->test_id = $test->id;
                    $this->test = $test;
                    $this->items = OnlineRegistrationTestItem::where('or_test_id', $test->id)->get();
                    $this->choices = OnlineRegistrationTestChoice::whereIn('or_item_id', $this->items->pluck('id'))->get();
                    $this->cant = count($this->items);
                    $this->count = 1;
                    $this->responses = [];
                    $this->score = 0;
                    $this->showResults = false;
                    $this->testPassed = false;
                }
            }
        }
    }


    public function nextStep()
    {
        if ($this->currentStepIndex < count($this->OnlineRegistrationSessionContent) - 1) {
            $this->currentStepIndex++;
            $this->loadStep();
        } else {
            // 🔥 Permitir un último avance al mensaje de "Fin"
            $this->currentStepIndex++;
            $this->type = 'fin';
        }
    }


    public function prevStep()
    {
        if ($this->currentStepIndex > 0) {
            $this->currentStepIndex--;
            $this->loadStep();

            // Si el contenido anterior era una lección, mostrar su última tarjeta
            if ($this->type == 'L' && !empty($this->lessonContent)) {
                $this->currentLessonStepIndex = count($this->lessonContent) - 1;
                $this->updateLessonStep();
            }

            // Si el contenido anterior era un test, reiniciar el test
            if ($this->type == 'T') {
                $this->count = 1;
                $this->responses = [];
                $this->score = 0;
                $this->showResults = false;
                $this->testPassed = false;
            }
        }
    }


    public function nextLessonStep()
    {
        if ($this->currentLessonStepIndex < count($this->lessonContent) - 1) {
            $this->currentLessonStepIndex++;
            $this->updateLessonStep();
        } else {
            $this->nextStep();
        }
    }

    public function prevLessonStep()
    {
        if ($this->currentLessonStepIndex > 0) {
            $this->currentLessonStepIndex--;
            $this->updateLessonStep();
        } else {
            $this->prevStep();
        }
    }


    private function updateLessonStep()
    {
        if (isset($this->lessonContent[$this->currentLessonStepIndex])) {
            $step = $this->lessonContent[$this->currentLessonStepIndex];
            $this->titleL = $step->title;
            $this->content = $step->body;
            $this->align_image = $step->align_image;
            $this->parameter = ($this->align_image == "left") ? false : true;
            $this->existingFile = $step->image ? asset('storage/' . $step->image) : null;
        }
    }




    public function nextItem()
    {
        if ($this->count <= $this->cant + 1) { // Evita sobrepasar el total de preguntas
            if ($this->count > 1) {
                $itemIndex = $this->count - 2; // Ajustar el índice correctamente

                if (isset($this->items[$itemIndex])) {
                    $item = $this->items[$itemIndex];
                    $responseKey = "responses.item_{$item->id}";
                    $responseValue = $this->responses["item_{$item->id}"] ?? null;

                    if (empty($responseValue)) {
                        $this->addError($responseKey, 'Debes seleccionar una opción.');
                        return;
                    }
                }
            }

            // Limpiar errores antes de avanzar
            $this->resetErrorBag();

            // Avanzar a la siguiente pregunta
            $this->count++;

            // Forzar actualización del componente
            $this->emitSelf('refreshComponent');
        }
    }

    public function previousItem()
    {
        if ($this->count > 1) {
            $this->count--;
        }
    }

    public function submitTest()
    {
        $correctAnswers = 0;
        $totalItems = count($this->items);

        foreach ($this->items as $item) {
            $selectedChoiceId = $this->responses["item_{$item->id}"] ?? null;

            if ($selectedChoiceId) {
                $selectedChoice = $item->choices->where('id', $selectedChoiceId)->first();
                if ($selectedChoice && $selectedChoice->is_correct) {
                    $correctAnswers++;
                }
            }
        }

        // Cálculo del porcentaje
        $this->score = ($correctAnswers / $totalItems) * 100;
        $this->testPassed = $this->score >= $this->test->percentage;
        $this->showResults = true;

        // Evitar que se incremente más de lo necesario
        if ($this->count == $this->cant + 2) {
            $this->count++; // Solo avanza al siguiente paso (resultados)
        }
    }


    public function retryTest()
    {
        // Reiniciar respuestas y volver al inicio
        $this->responses = [];
        $this->count = 1;
        $this->score = 0;
        $this->showResults = false;
        $this->testPassed = false;

        // Forzar actualización del componente
    }
    public function goToStep($index)
    {
        if ($index >= 0 && $index < count($this->OnlineRegistrationSessionContent)) {
            $this->currentStepIndex = $index;
            $this->loadStep();
        }
    }
}
