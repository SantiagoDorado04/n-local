<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions;

use App\Http\Livewire\Admin\OnlineRegistrationCharacterizations\OrCharacterizationOptions\OrCharacterizationOptionsComponent;
use App\Models\OnlineRegistration;
use App\Models\OnlineRegistrationCategory;
use App\Models\OnlineRegistrationCharacterization;
use App\Models\OnlineRegistrationCourse;
use App\Models\OnlineRegistrationCourseSession;
use App\Models\OnlineRegistrationLessonContent;
use App\Models\OnlineRegistrationLessonStep;
use App\Models\OnlineRegistrationSessionContent;
use App\Models\OnlineRegistrationSlideContent;
use App\Models\OnlineRegistrationTestChoice;
use App\Models\OnlineRegistrationTestContent;
use App\Models\OnlineRegistrationTestItem;
use App\Models\OnlineRegistrationVideoContent;
use App\Models\OrCharacterizationOption;
use App\Models\OrCharacterizationQuestion;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class OnlineRegistrationCoursesSessionsComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $name,
        $description,
        $start_date,
        $end_date,
        $non_attendance_message,
        $online_registration_course_session_id;

    public
        $or_course_id, $onlineRegistrationCourse;

    public $searchName;

    public $processes, $categories = [], $courses = [], $sessions = [];
    public $processM, $categoriesM, $coursesM, $sessionsM, $option;
    public $onlineRegistrationCourseSession;

    public $user_created_at, $user_updated_at;

    public function mount($id)
    {

        $this->or_course_id = $id;
        $this->onlineRegistrationCourse = OnlineRegistrationCourse::find($this->or_course_id);
        $this->processes = OnlineRegistration::all();
    }

    public function render()
    {

        $courseSessions = OnlineRegistrationCourseSession::when($this->searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })
            ->where('or_course_id', '=', $this->or_course_id)
            ->paginate(6);

        $firstItem = $courseSessions->firstItem();
        $lastItem = $courseSessions->lastItem();

        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$courseSessions->total()} registros";

        return view('livewire.admin.online-registration-courses.sessions.online-registration-courses-sessions-component', [
            'courseSessions' => $courseSessions,
            'paginationText' => $paginationText,
        ]);
    }

    public function show($id)
    {
        $this->online_registration_course_session_id = $id;

        $courseSession = OnlineRegistrationCourseSession::find($id);
        $this->name = $courseSession->name;
        $this->description = $courseSession->description;
        $this->start_date = $courseSession->start_date;
        $this->end_date = $courseSession->end_date;
        $this->non_attendance_message = $courseSession->non_attendance_message;
        $userCreate = User::find($courseSession->user_created_at);
        $this->user_created_at = $userCreate ? $userCreate->name : 'Sin creador';
        $userUpdate = User::find($courseSession->user_updated_at);
        $this->user_updated_at = $userUpdate ? $userUpdate->name : 'Sin modificación';
    }

    public function store()
    {
        $this->validate([
            'name' => [
                'required',
                Rule::unique('online_registrations_courses_sessions')->where(function ($query) {
                    return $query->where('or_course_id', $this->or_course_id);
                })
            ],
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'non_attendance_message' => 'nullable',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripcion',
            'start_date' => 'fecha de inicio de la sesion',
            'end_date' => 'fecha de fin de la sesion',
            'non_attendance_message' => 'mensaje de no asistencia',
        ], [], []);

        $courseSession = new OnlineRegistrationCourseSession();
        $courseSession->name = $this->name;
        $courseSession->description = $this->description;
        $courseSession->start_date = $this->start_date;
        $courseSession->end_date = $this->end_date;
        $courseSession->non_attendance_message = $this->non_attendance_message;
        $courseSession->or_course_id = $this->or_course_id;
        $courseSession->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Sesion del curso creada correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->online_registration_course_session_id = $id;
        $onlineRegistrationCourseSession = OnlineRegistrationCourseSession::find($id);

        $this->name = $onlineRegistrationCourseSession->name;
        $this->description = $onlineRegistrationCourseSession->description;
        $this->start_date = $onlineRegistrationCourseSession->start_date;
        $this->end_date = $onlineRegistrationCourseSession->end_date;
        $this->non_attendance_message = $onlineRegistrationCourseSession->non_attendance_message;
    }

    public function update()
    {
        $this->validate([
            'name' => [
                'required',
                Rule::unique('online_registrations_courses_sessions')
                    ->where(function ($query) {
                        return $query->where('or_course_id', $this->or_course_id);
                    })
                    ->ignore($this->online_registration_course_session_id),
            ],
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'non_attendance_message' => 'nullable',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripcion',
            'start_date' => 'fecha de inicio de la sesion',
            'end_date' => 'fecha de fin de la sesion',
            'non_attendance_message' => 'mensaje de no asistencia',
        ]);

        $onlineRegistrationCourseSession = OnlineRegistrationCourseSession::find($this->online_registration_course_session_id);
        $onlineRegistrationCourseSession->name = $this->name;
        $onlineRegistrationCourseSession->description = $this->description;
        $onlineRegistrationCourseSession->start_date = $this->start_date;
        $onlineRegistrationCourseSession->end_date = $this->end_date;
        $onlineRegistrationCourseSession->non_attendance_message = $this->non_attendance_message;

        $onlineRegistrationCourseSession->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Sesion del curso actualizada correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->online_registration_course_session_id = $id;
    }

    public function destroy()
    {
        // $onlineRegistrationCourseSession = OnlineRegistrationCourseSession::with('form')->find($this->online_registration_course_id);
        $onlineRegistrationCourseSession = OnlineRegistrationCourseSession::find($this->online_registration_course_session_id);

        $onlineRegistrationCourseSession->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Contenido del curso eliminado correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->online_registration_course_session_id = '';
        $this->start_date = null;
        $this->end_date = null;
        $this->non_attendance_message = '';
        $this->user_created_at = '';
        $this->user_updated_at = '';
    }


    public function updatedProcessM($value)
    {
        // Filtrar categorías según el proceso seleccionado
        $this->categories = OnlineRegistrationCategory::where('online_registration_id', $value)->get();
        $this->categoriesM = null;
        $this->courses = [];
        $this->sessions = [];
        $this->option = null;
    }

    public function updatedCategoriesM($value)
    {
        // Filtrar cursos según la categoría seleccionada
        $this->courses = OnlineRegistrationCourse::where('or_category_id', $value)->get();
        $this->coursesM = null;
        $this->sessions = [];
        $this->option = null;
    }

    public function updatedCoursesM($value)
    {
        // Filtrar sesiones según el curso seleccionado
        $this->sessions = OnlineRegistrationCourseSession::where('or_course_id', $value)->get();
        $this->sessionsM = null;
        $this->option = null;
    }

    public function duplicate()
    {
        if (!$this->sessionsM) {
            return;
        }

        DB::transaction(
            function () {
                $originalSession = OnlineRegistrationCourseSession::find($this->sessionsM);
                if (!$originalSession) {
                    return;
                }
                $newSession = $originalSession->replicate();
                $newSession->name = $originalSession->name;
                $newSession->description = $originalSession->description;
                $newSession->start_date = $originalSession->start_date;
                $newSession->end_date = $originalSession->end_date;
                $newSession->non_attendance_message = $originalSession->non_attendance_message;
                $newSession->or_course_id = $this->or_course_id;
                $newSession->save();
                $newSessionId = $newSession->id;


                if ($this->option == 'T') {
                    DB::transaction(function () use ($newSessionId) {
                        // 🔹 1️⃣ Duplicar CARACTERIZACIONES (SF)
                        $characterizations = OnlineRegistrationCharacterization::where('session_id', $this->sessionsM)->get();
                        $characterizationMap = [];
                        $questionMap = [];

                        foreach ($characterizations as $characterization) {
                            $newCharacterization = $characterization->replicate();
                            $newCharacterization->session_id = $newSessionId;
                            $newCharacterization->save();
                            $characterizationMap[$characterization->id] = $newCharacterization->id;
                        }

                        // 🔹 2️⃣ Duplicar PREGUNTAS relacionadas con las caracterizaciones
                        $or_characterizations_questions = OrCharacterizationQuestion::whereIn('characterization_id', array_keys($characterizationMap))->get();
                        foreach ($or_characterizations_questions as $question) {
                            $newQuestion = $question->replicate();
                            $newQuestion->characterization_id = $characterizationMap[$question->characterization_id];
                            $newQuestion->save();
                            $questionMap[$question->id] = $newQuestion->id;
                        }

                        // 🔹 3️⃣ Duplicar OPCIONES relacionadas con las preguntas
                        $or_characterizations_options = OrCharacterizationOption::whereIn('question_id', array_keys($questionMap))->get();
                        foreach ($or_characterizations_options as $option) {
                            $newOption = $option->replicate();
                            $newOption->question_id = $questionMap[$option->question_id];
                            $newOption->save();
                        }

                        // 🔹 4️⃣ Duplicar CONTENIDOS DE SESIÓN (SC)
                        $sessionContents = OnlineRegistrationSessionContent::where('session_id', $this->sessionsM)->get();
                        $testContentMap = [];
                        $lessonContentMap = [];

                        foreach ($sessionContents as $content) {
                            $newContent = $content->replicate();
                            $newContent->session_id = $newSessionId;
                            $newContent->save();

                            // Si el contenido es tipo TEST ('T')
                            if ($content->type == 'T') {
                                $testContent = OnlineRegistrationTestContent::where('content_id', $content->id)->first();
                                if ($testContent) {
                                    $newTestContent = $testContent->replicate();
                                    $newTestContent->content_id = $newContent->id;
                                    $newTestContent->save();
                                    $testContentMap[$testContent->id] = $newTestContent->id;
                                }
                            }

                            // Si el contenido es tipo LESSON ('L')
                            if ($content->type == 'L') {
                                $lessonContent = OnlineRegistrationLessonContent::where('content_id', $content->id)->first();
                                if ($lessonContent) {
                                    $newLessonContent = $lessonContent->replicate();
                                    $newLessonContent->content_id = $newContent->id;
                                    $newLessonContent->save();
                                    $lessonContentMap[$lessonContent->id] = $newLessonContent->id;
                                }
                            }

                            // Si el contenido es tipo VIDEO ('V')
                            if ($content->type == 'V') {
                                $videoContent = OnlineRegistrationVideoContent::where('content_id', $content->id)->first();
                                if ($videoContent) {
                                    $newVideoContent = $videoContent->replicate();
                                    $newVideoContent->content_id = $newContent->id;
                                    $newVideoContent->save();
                                }
                            }

                            // Si el contenido es tipo SLIDE ('S')
                            if ($content->type == 'S') {
                                $slideContent = OnlineRegistrationSlideContent::where('content_id', $content->id)->first();
                                if ($slideContent) {
                                    $newSlideContent = $slideContent->replicate();
                                    $newSlideContent->content_id = $newContent->id;

                                    // Duplicar la imagen asociada, si existe
                                    if ($slideContent->banner_image) {
                                        $originalPath = storage_path('app/public/' . $slideContent->banner_image); // Ruta completa de la imagen original
                                        $newImageName = uniqid('slide_') . '.' . pathinfo($originalPath, PATHINFO_EXTENSION); // Nombre único para la nueva imagen
                                        $newImagePath = 'slides/' . $newImageName; // Nueva ubicación en 'slides/'

                                        // Verificar si la imagen existe antes de intentar copiarla
                                        if (Storage::exists('public/' . $slideContent->banner_image)) {
                                            Storage::copy('public/' . $slideContent->banner_image, 'public/' . $newImagePath); // Copiar la imagen al nuevo path
                                            $newSlideContent->banner_image = $newImagePath; // Guardar la nueva ruta en el modelo
                                        } else {
                                        }
                                    }

                                    $newSlideContent->save(); // Guardar el nuevo slide con la imagen duplicada (si aplica)
                                }
                            }
                        }


                        // 🔹 5️⃣ Duplicar TEST ITEMS
                        $testItems = OnlineRegistrationTestItem::whereIn('or_test_id', array_keys($testContentMap))->get();
                        $testItemMap = [];

                        foreach ($testItems as $testItem) {
                            if (!isset($testContentMap[$testItem->test_content_id])) continue;

                            $newTestItem = $testItem->replicate();
                            $newTestItem->test_content_id = $testContentMap[$testItem->test_content_id];
                            $newTestItem->save();
                            $testItemMap[$testItem->id] = $newTestItem->id;
                        }

                        // 🔹 6️⃣ Duplicar TEST CHOICES
                        $testChoices = OnlineRegistrationTestChoice::whereIn('or_item_id', array_keys($testItemMap))->get();
                        foreach ($testChoices as $testChoice) {
                            if (!isset($testItemMap[$testChoice->test_item_id])) continue;

                            $newTestChoice = $testChoice->replicate();
                            $newTestChoice->test_item_id = $testItemMap[$testChoice->test_item_id];
                            $newTestChoice->save();
                        }

                        // 🔹 7️⃣ Duplicar LESSON STEPS
                        $lessonSteps = OnlineRegistrationLessonStep::whereIn('or_lesson_id', array_keys($lessonContentMap))->get();
                        foreach ($lessonSteps as $lessonStep) {
                            if (!isset($lessonContentMap[$lessonStep->or_lesson_id])) continue;

                            $newLessonStep = $lessonStep->replicate();
                            $newLessonStep->or_lesson_id = $lessonContentMap[$lessonStep->or_lesson_id];

                            // Duplicar la imagen asociada, si existe
                            if ($lessonStep->image) {
                                $originalPath = storage_path('app/public/' . $lessonStep->image);
                                $newImageName = uniqid('lesson_step_') . '.' . pathinfo($originalPath, PATHINFO_EXTENSION);
                                $newImagePath = 'lesson/' . $newImageName;

                                if (Storage::exists('public/' . $lessonStep->image)) {
                                    Storage::copy('public/' . $lessonStep->image, 'public/' . $newImagePath);
                                    $newLessonStep->image = $newImagePath;
                                }
                            }

                            $newLessonStep->save();
                        }
                    });
                } elseif ($this->option == 'SF') {
                    DB::transaction(function () use ($newSessionId) {
                        // Obtener caracterizaciones originales
                        $characterizations = OnlineRegistrationCharacterization::where('session_id', $this->sessionsM)->get();

                        // Mapeo para enlazar IDs viejos con nuevos
                        $characterizationMap = [];
                        $questionMap = [];

                        foreach ($characterizations as $characterization) {
                            // Clonar caracterización
                            $newCharacterization = $characterization->replicate();
                            $newCharacterization->session_id = $newSessionId;
                            $newCharacterization->save();

                            // Guardamos el id antiguo y el nuevo
                            $characterizationMap[$characterization->id] = $newCharacterization->id;
                        }

                        // Obtener preguntas originales
                        $or_characterizations_questions = OrCharacterizationQuestion::whereIn('characterization_id', array_keys($characterizationMap))->get();

                        foreach ($or_characterizations_questions as $question) {
                            // Clonar pregunta
                            $newQuestion = $question->replicate();
                            $newQuestion->characterization_id = $characterizationMap[$question->characterization_id];

                            $newQuestion->save();

                            // Guardamos el ID viejo y nuevo para enlazar opciones
                            $questionMap[$question->id] = $newQuestion->id;
                        }

                        // Obtener opciones originales
                        $or_characterizations_options = OrCharacterizationOption::whereIn('question_id', array_keys($questionMap))->get();

                        foreach ($or_characterizations_options as $option) {
                            // Clonar opción
                            $newOption = $option->replicate();
                            $newOption->question_id = $questionMap[$option->question_id];
                            $newOption->save();
                        }
                    });
                } elseif ($this->option == 'SC') {

                    DB::transaction(function () use ($newSessionId) {
                        // 1️⃣ Obtener y duplicar los contenidos de sesión
                        $sessionContents = OnlineRegistrationSessionContent::where('session_id', $this->sessionsM)->get();
                        $testContentMap = []; // Mapeo de IDs originales a nuevos (Tests)
                        $lessonContentMap = []; // Mapeo de IDs originales a nuevos (Lessons)

                        foreach ($sessionContents as $content) {
                            $newContent = $content->replicate();
                            $newContent->session_id = $newSessionId;
                            $newContent->save();

                            // Si el contenido es tipo TEST ('T')
                            if ($content->type == 'T') {
                                $testContent = OnlineRegistrationTestContent::where('content_id', $content->id)->first();
                                if ($testContent) {
                                    $newTestContent = $testContent->replicate();
                                    $newTestContent->content_id = $newContent->id;
                                    $newTestContent->save();
                                    $testContentMap[$testContent->id] = $newTestContent->id;
                                }
                            }

                            // Si el contenido es tipo LESSON ('L')
                            if ($content->type == 'L') {
                                $lessonContent = OnlineRegistrationLessonContent::where('content_id', $content->id)->first();
                                if ($lessonContent) {
                                    $newLessonContent = $lessonContent->replicate();
                                    $newLessonContent->content_id = $newContent->id;
                                    $newLessonContent->save();
                                    $lessonContentMap[$lessonContent->id] = $newLessonContent->id;
                                }
                            }

                            // Si el contenido es tipo VIDEO ('V')
                            if ($content->type == 'V') {
                                $videoContent = OnlineRegistrationVideoContent::where('content_id', $content->id)->first();
                                if ($videoContent) {
                                    $newVideoContent = $videoContent->replicate();
                                    $newVideoContent->content_id = $newContent->id;
                                    $newVideoContent->save();
                                }
                            }

                            // Si el contenido es tipo SLIDE ('S')
                            if ($content->type == 'S') {
                                $slideContent = OnlineRegistrationSlideContent::where('content_id', $content->id)->first();
                                if ($slideContent) {
                                    $newSlideContent = $slideContent->replicate();
                                    $newSlideContent->content_id = $newContent->id;

                                    // Duplicar la imagen asociada, si existe
                                    if ($slideContent->banner_image) {
                                        $originalPath = storage_path('app/public/' . $slideContent->banner_image); // Ruta completa de la imagen original
                                        $newImageName = uniqid('slide_') . '.' . pathinfo($originalPath, PATHINFO_EXTENSION); // Nombre único para la nueva imagen
                                        $newImagePath = 'slides/' . $newImageName; // Nueva ubicación en 'slides/'

                                        // Verificar si la imagen existe antes de intentar copiarla
                                        if (Storage::exists('public/' . $slideContent->banner_image)) {
                                            Storage::copy('public/' . $slideContent->banner_image, 'public/' . $newImagePath); // Copiar la imagen al nuevo path
                                            $newSlideContent->banner_image = $newImagePath; // Guardar la nueva ruta en el modelo
                                        } else {
                                        }
                                    }

                                    $newSlideContent->save(); // Guardar el nuevo slide con la imagen duplicada (si aplica)
                                }
                            }
                        }


                        // 2️⃣ Obtener y duplicar TestItems
                        $testItems = OnlineRegistrationTestItem::whereIn('or_test_id', array_keys($testContentMap))->get();
                        $testItemMap = [];

                        foreach ($testItems as $testItem) {
                            if (!isset($testContentMap[$testItem->test_content_id])) continue;

                            $newTestItem = $testItem->replicate();
                            $newTestItem->test_content_id = $testContentMap[$testItem->test_content_id];
                            $newTestItem->save();
                            $testItemMap[$testItem->id] = $newTestItem->id;
                        }

                        // 3️⃣ Obtener y duplicar TestChoices
                        $testChoices = OnlineRegistrationTestChoice::whereIn('or_item_id', array_keys($testItemMap))->get();
                        foreach ($testChoices as $testChoice) {
                            if (!isset($testItemMap[$testChoice->test_item_id])) continue;

                            $newTestChoice = $testChoice->replicate();
                            $newTestChoice->test_item_id = $testItemMap[$testChoice->test_item_id];
                            $newTestChoice->save();
                        }

                        // 4️⃣ Obtener y duplicar LessonSteps
                        $lessonSteps = OnlineRegistrationLessonStep::whereIn('or_lesson_id', array_keys($lessonContentMap))->get();
                        foreach ($lessonSteps as $lessonStep) {
                            if (!isset($lessonContentMap[$lessonStep->or_lesson_id])) continue;

                            $newLessonStep = $lessonStep->replicate();
                            $newLessonStep->or_lesson_id = $lessonContentMap[$lessonStep->or_lesson_id];

                            // Duplicar la imagen asociada, si existe
                            if ($lessonStep->image) {
                                $originalPath = storage_path('app/public/' . $lessonStep->image);
                                $newImageName = uniqid('lesson_step_') . '.' . pathinfo($originalPath, PATHINFO_EXTENSION);
                                $newImagePath = 'lesson/' . $newImageName;

                                if (Storage::exists('public/' . $lessonStep->image)) {
                                    Storage::copy('public/' . $lessonStep->image, 'public/' . $newImagePath);
                                    $newLessonStep->image = $newImagePath;
                                }
                            }

                            $newLessonStep->save();
                        }
                    });
                }
            }
        );
        // Emitir alerta de éxito
        $this->emit('alert', ['type' => 'success', 'message' => 'Contenido del curso duplicado correctamente']);
        $this->cancel();
    }

    public function cancel()
    {

        $this->resetInputImport();
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
    public function resetInputImport()
    {
        $this->processM = '';
        $this->categoriesM = '';
        $this->coursesM = '';
        $this->sessionsM = '';
        $this->option = '';
        $this->emit('close-modal');
    }
}
