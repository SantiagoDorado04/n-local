<?php

namespace App\Http\Livewire\Contacts\MyOnlineRegistrationCourses\OrMyCourseSessions\OrMySessionContents;

use App\Models\OnlineRegistrationContactTest;
use App\Models\OnlineRegistrationContentProgress;
use App\Models\OnlineRegistrationCourseSession;
use App\Models\OnlineRegistrationLessonContent;
use App\Models\OnlineRegistrationLessonStep;
use App\Models\OnlineRegistrationSessionContent;
use App\Models\OnlineRegistrationSlideContent;
use App\Models\OnlineRegistrationTestChoice;
use App\Models\OnlineRegistrationTestContent;
use App\Models\OnlineRegistrationTestItem;
use App\Models\OnlineRegistrationTestResponse;
use App\Models\OnlineRegistrationVideoContent;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrMySessionContentsComponent extends Component
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
    public $course_id;

    public $testId;
    public $user;
    public $totalQuestions;
    public $passed;
    public $sesionCourse;



    public function mount($id)
    {
        $this->sesionCourse = $id;
        $this->sessionContent = OnlineRegistrationSessionContent::where('session_id', $id)->first();
        $this->onlineRegistrationCourseSession = OnlineRegistrationCourseSession::where('id', $id)->first();
        $this->course_id =  $this->onlineRegistrationCourseSession->or_course_id;

        // $this->onlineRegistrationCourseSession = $this->sessionContent->onlineRegistrationCourseSession;
        //dd($this->onlineRegistrationCourseSession);


        $this->OnlineRegistrationSessionContent = OnlineRegistrationSessionContent::where('session_id', $id)
            ->orderBy('step', 'asc')
            ->get();

        $this->lessonContent = collect([]); // Inicializa como colección vacía
        $this->currentLessonStepIndex = 0;
        //  dd($this->onlineRegistrationCourseSession);
        $this->loadStep();
    }

    public function render()
    {
        return view('livewire.contacts.my-online-registration-courses.or-my-course-sessions.or-my-session-contents.or-my-session-contents-component');
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

                    // ✅ Validar si ya completó el test
                    $user = Auth::user();
                    $contact = $user->contact;

                    $testRecord = OnlineRegistrationContactTest::where('contact_id', $contact->id)
                        ->where('or_test_id', $test->id)
                        ->first();

                    if ($testRecord) {
                        $this->score = floatval($testRecord->hits);
                        $this->testPassed = $testRecord->approved == 1;
                        $this->showResults = true;
                        $this->count = $this->cant + 3; // Ir directamente a la sección de resultados
                    }
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


            if ($this->type = 'fin') {
                $user = Auth::user();
                $contact = $user->contact;

                // Verificamos si ya existe un progreso para este curso y contacto
                $progress = OnlineRegistrationContentProgress::firstOrNew([
                    'or_course_id' => $this->course_id,
                    'contact_id' => $contact->id,
                ]);
                $progress->finished = true;
                $progress->save();
            }
        }
    }


    public function prevStep()
    {
        if ($this->currentStepIndex > 0) {
            $this->currentStepIndex--;
            $this->loadStep();

            // Si el contenido anterior es una lección, mostrar su última tarjeta
            if ($this->type == 'L' && !empty($this->lessonContent)) {
                $this->currentLessonStepIndex = count($this->lessonContent) - 1;
                $this->updateLessonStep();
            }

            // Si el contenido anterior es un test
            if ($this->type == 'T') {
                $test = $this->test; // Asegúrate de que 'test' esté disponible en loadStep()
                if ($test) {
                    $user = Auth::user();
                    $contact = $user->contact;

                    $testRecord = OnlineRegistrationContactTest::where('contact_id', $contact->id)
                        ->where('or_test_id', $test->id)
                        ->first();

                    if ($testRecord) {
                        // Si ya completó el test, mostrar resultados directamente
                        $this->score = floatval($testRecord->hits);
                        $this->testPassed = $testRecord->approved == 1;
                        $this->showResults = true;
                        $this->count = $this->cant + 3; // Mostrar directamente la sección de resultados
                    } else {
                        // Si no completó el test, reiniciar
                        $this->count = 1;
                        $this->responses = [];
                        $this->score = 0;
                        $this->showResults = false;
                        $this->testPassed = false;
                    }
                }
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
        $user = Auth::user();
        $contact = $user->contact;
        $testId = $this->test_id;

        // ✅ Calcular el puntaje correctamente
        $this->score = $this->calculateScore();

        // ✅ Verificar que el porcentaje de aprobación está bien definido
        $passingPercentage = floatval($this->test->percentage);

        // ✅ Evaluar si el usuario ha aprobado
        $this->testPassed = $this->score >= $passingPercentage;

        // Buscar el intento del usuario
        $testRecord = OnlineRegistrationContactTest::where('contact_id', $contact->id)
            ->where('or_test_id', $testId)
            ->first();

        if ($testRecord) {
            $testRecord->update([
                'attempts' => $testRecord->attempts + 1,
                'hits' => $this->score, // ✅ Asegurar que se guarda el puntaje correcto
                'approved' => $this->testPassed ? 1 : 0,
            ]);
        } else {
            OnlineRegistrationContactTest::create([
                'contact_id' => $contact->id,
                'or_test_id' => $testId,
                'approved' => $this->testPassed ? 1 : 0,
                'attempts' => 1,
                'hits' => $this->score,
                'user_created_at' => now(),
            ]);
        }

        // ✅ Mostrar la sección de resultados
        $this->showResults = true;
        $responses = OnlineRegistrationTestResponse::where('contact_id', $contact->id)
            ->where('or_Test_id', $testId)->first();
        if ($this->showResults == true) {
            if ($responses) {
                $responses = OnlineRegistrationTestResponse::where('contact_id', $contact->id)
                    ->where('or_Test_id', $testId)->delete();

                foreach ($this->items as $item) {
                    if (isset($this->responses["item_{$item->id}"])) {
                        $selectedChoiceId = $this->responses["item_{$item->id}"];
                        $selectedChoice = $item->choices->where('id', $selectedChoiceId)->first();
                        // dd($selectedChoice,$selectedChoiceId,$item);
                        if ($selectedChoice && $selectedChoice->is_correct) {
                            $correctAnswers = true; // Si la respuesta es correcta, se suma al contador
                            // dd($item->id);
                            OnlineRegistrationTestResponse::create([
                                'contact_id' => $contact->id,
                                'or_test_id' => $testId,
                                'or_item_id' => $item->id,
                                'response' => $selectedChoice->id,
                                'is_correct' => $correctAnswers,
                            ]);
                        } else {
                            OnlineRegistrationTestResponse::create([
                                'contact_id' => $contact->id,
                                'or_test_id' => $testId,
                                'or_item_id' => $item->id,
                                'response' => $selectedChoice->id,
                                'is_correct' => false,
                            ]);
                        }
                    }
                }
            } else {
                foreach ($this->items as $item) {
                    if (isset($this->responses["item_{$item->id}"])) {
                        $selectedChoiceId = $this->responses["item_{$item->id}"];
                        $selectedChoice = $item->choices->where('id', $selectedChoiceId)->first();
                        // dd($selectedChoice,$selectedChoiceId,$item);
                        if ($selectedChoice && $selectedChoice->is_correct) {
                            $correctAnswers = true; // Si la respuesta es correcta, se suma al contador
                            // dd($item->id);
                            OnlineRegistrationTestResponse::create([
                                'contact_id' => $contact->id,
                                'or_test_id' => $testId,
                                'or_item_id' => $item->id,
                                'response' => $selectedChoice->id,
                                'is_correct' => $correctAnswers,
                            ]);
                        } else {
                            OnlineRegistrationTestResponse::create([
                                'contact_id' => $contact->id,
                                'or_test_id' => $testId,
                                'or_item_id' => $item->id,
                                'response' => $selectedChoice->id,
                                'is_correct' => false,
                            ]);
                        }
                    }
                }
            }
        }

        $this->count++; // Avanzar al siguiente paso
    }



    public function calculateScore()
    {
        $totalQuestions = count($this->items); // Número total de preguntas
        $correctAnswers = 0; // Contador de respuestas correctas

        foreach ($this->items as $item) {
            if (isset($this->responses["item_{$item->id}"])) {
                $selectedChoiceId = $this->responses["item_{$item->id}"];
                $selectedChoice = $item->choices->where('id', $selectedChoiceId)->first();

                if ($selectedChoice && $selectedChoice->is_correct) {
                    $correctAnswers++; // Si la respuesta es correcta, se suma al contador
                }
            }
        }

        // Calcular el puntaje en porcentaje
        return $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;
    }



    public function retryTest()
    {
        //dd($this->testPassed);
        $user = Auth::user();
        $contact = $user->contact;

        $testRecord = OnlineRegistrationContactTest::where('contact_id', $contact->id)
            ->where('or_test_id', $this->test_id)
            ->first();

        // Opcional: evitar retry si ya está aprobado
        if ($testRecord && $testRecord->approved) {
            return; // Ya aprobado, no se puede reintentar
        }

        $this->responses = [];
        $this->count = 1;
        $this->score = 0;
        $this->showResults = false;
        $this->testPassed = false;
    }


    public function goToStep($index)
    {
        if ($index >= 0 && $index < count($this->OnlineRegistrationSessionContent)) {
            $this->currentStepIndex = $index;
            $this->loadStep();
        }
    }
}
