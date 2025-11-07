<?php

namespace App\Http\Livewire\Admin\Steps;

use App\Canva;
use App\Models\AlquimiaAgentConnection;
use App\Models\Step;
use App\Models\Stage;
use App\Models\Course;
use App\Models\Mentor;
use App\Models\Process;
use Livewire\Component;
use App\Models\Challenge;
use Livewire\WithPagination;
use App\Models\InformationForm;
use App\Models\PresentialActivity;
use App\Models\ProcessAdvisorScheduling;
use App\Models\ProcessAlquimiaAgent;
use App\Models\ProcessAlquimiaAgentQuestion;
use App\Models\ProcessComplianceVerification;
use App\Models\ProcessTest;
use Illuminate\Support\Facades\DB;

class StepsComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $stepId,
        $name,
        $description,
        $order,
        $available_from,
        $step_type;

    public $searchName;

    public $stageId;

    public $alquimiaAgentConnections;

    public $processes;
    public $stagesList = [];
    public $stepsList = [];
    public $processM;
    public $stageM;
    public $stepM;

    // embeds
    public $schedulingEmbed;
    public $complianceEmbed;


    public $requiredSteps = [];
    public $filteredRequiredSteps;
    public $selectedRequiredSteps = [];

    public $selectedAlquimiaConnection;

    public function mount($id)
    {
        $this->stageId = $id;
        $this->filteredRequiredSteps = Step::where('stage_id', $this->stageId)
            ->whereIn('step_type', ['F', 'CD', 'LZ', 'AL'])
            ->get();
        $this->processes = Process::all();
        $this->alquimiaAgentConnections = AlquimiaAgentConnection::all();
    }

    public function render()
    {
        $steps = Step::when($this->searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })
            ->where('stage_id', '=', $this->stageId)
            ->orderBy('order', 'asc')
            ->paginate(1000);

        $firstItem = $steps->firstItem();
        $lastItem = $steps->lastItem();
        $stage = Stage::find($this->stageId);

        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$steps->total()} registros";

        return view('livewire.admin.steps.steps-component', [
            'steps' => $steps,
            'paginationText' => $paginationText,
            'stage' => $stage
        ]);
    }

    public function show($id)
    {
        $this->stepId = $id;

        $step = Step::find($id);
        $this->name = $step->name;
        $this->description = $step->description;
        $this->order = $step->order;
        $this->available_from = $step->available_from;
        $this->step_type = $step->step_type;
        $this->stageId = $step->stage_id;
    }

    public function store()
    {
        $this->validate([
            'name' => [
                'required',
                function ($attribute, $value, $fail) {
                    $existingStep = Step::where('name', $value)
                        ->where('stage_id', $this->stageId)
                        ->where('id', '!=', $this->stepId)
                        ->first();
                    if ($existingStep) {
                        $fail('El nombre del paso ya existe en esta etapa.');
                    }
                },
            ],
            'description' => 'required',
            'order' => [
                'nullable',
                'integer',
                function ($attribute, $value, $fail) {
                    $existingStep = Step::where('order', $value)
                        ->where('stage_id', $this->stageId)
                        ->where('id', '!=', $this->stepId)
                        ->first();
                    if ($existingStep) {
                        $fail('El orden del paso ya existe.');
                    }
                },
            ],
            'available_from' => 'required|date',
            'step_type' => 'required',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
            'order' => 'orden',
            'available_from' => 'Disponible desde',
            'step_type' => 'tipo',
        ]);

        $lastStep = Step::where('stage_id', $this->stageId)->orderBy('order', 'desc')->first();
        $newOrder = $lastStep ? $lastStep->order + 1 : 1;

        $step = new Step();
        $step->name = $this->name;
        $step->description = $this->description;
        $step->order = $newOrder;
        $step->available_from = $this->available_from;
        $step->step_type = $this->step_type;
        $step->stage_id = $this->stageId;
        $step->save();

        switch ($this->step_type) {
            case 'LZ':
                $canva = new Canva();
                $canva->step_id = $step->id;
                $canva->save();

                $form = new InformationForm();
                $form->name = $this->name;
                $form->description = $this->description;
                $form->save();

                $canva->information_form_id = $form->id;
                $canva->update();
                break;

            case 'AL':
                $agent = new ProcessAlquimiaAgent();
                $agent->name = $this->name;
                $agent->description = $this->description;
                $agent->step_id = $step->id;
                if ($this->selectedAlquimiaConnection) {
                    $agent->alquimia_connection_id = $this->selectedAlquimiaConnection;
                }
                $agent->save();

                break;

            case 'AT':
                $processAdvisorScheduling = new ProcessAdvisorScheduling();
                $processAdvisorScheduling->step_id = $step->id;
                $processAdvisorScheduling->name = $this->name;
                $processAdvisorScheduling->embed = $this->schedulingEmbed ?? null;
                $processAdvisorScheduling->required_steps = json_encode($this->selectedRequiredSteps);
                $processAdvisorScheduling->save();
                break;

            case 'VP':
                $processComplianceVerification = new ProcessComplianceVerification();
                $processComplianceVerification->step_id = $step->id;
                $processComplianceVerification->embed = $this->complianceEmbed ?? null;
                $processComplianceVerification->required_steps = json_encode($this->selectedRequiredSteps);
                $processComplianceVerification->save();
                break;

            case 'PT':
                $processTest = new ProcessTest();
                $processTest->step_id = $step->id;
                $processTest->name = $this->name;
                $processTest->description = $this->description;
                $processTest->save();
                break;

            case 'CV':
                $processComplianceVerification = new ProcessComplianceVerification();
                $processComplianceVerification->step_id = $step->id;
                $processComplianceVerification->embed = $this->complianceEmbed ?? null;
                $processComplianceVerification->required_steps = json_encode($this->selectedRequiredSteps);
                $processComplianceVerification->save();
                break;

            default:
                break;
        }

        $this->emit('alert', ['type' => 'success', 'message' => 'Paso creado correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->stepId = $id;

        $step = Step::find($id);
        $this->name = $step->name;
        $this->description = $step->description;
        $this->order = $step->order;
        $this->available_from = $step->available_from;
        $this->step_type = $step->step_type;
        $this->stageId = $step->stage_id;

        if ($this->step_type === 'AL') {
            $agent = ProcessAlquimiaAgent::where('step_id', $step->id)->first();
            if ($agent) {
                $this->selectedAlquimiaConnection = $agent->alquimia_connection_id;
            }
        }

        if ($this->step_type === 'AT') {
            $processAdvisorScheduling = ProcessAdvisorScheduling::where('step_id', $step->id)->first();
            if ($processAdvisorScheduling) {
                $this->schedulingEmbed = $processAdvisorScheduling->embed;
                $this->selectedRequiredSteps = $processAdvisorScheduling->required_steps
                    ? json_decode($processAdvisorScheduling->required_steps, true)
                    : [];
            }
        }

        if ($this->step_type === 'CV') {
            $processComplianceVerification = ProcessComplianceVerification::where('step_id', $step->id)->first();
            if ($processComplianceVerification) {
                $this->complianceEmbed = $processComplianceVerification->embed;
                $this->selectedRequiredSteps = $processComplianceVerification->required_steps
                    ? json_decode($processComplianceVerification->required_steps, true)
                    : [];
            }
        }
    }


    public function update()
    {
        $this->validate([
            'name' => [
                'required',
                function ($attribute, $value, $fail) {
                    $existingStep = Step::where('name', $value)
                        ->where('stage_id', $this->stageId)
                        ->where('id', '!=', $this->stepId)
                        ->first();
                    if ($existingStep) {
                        $fail('El nombre del paso ya existe en esta etapa.');
                    }
                },
            ],
            'description' => 'required',
            'order' => [
                'nullable',
                'integer',
                function ($attribute, $value, $fail) {
                    $existingStep = Step::where('order', $value)
                        ->where('stage_id', $this->stageId)
                        ->where('id', '!=', $this->stepId)
                        ->first();
                    if ($existingStep) {
                        $fail('El orden del paso ya existe.');
                    }
                },
            ],
            'available_from' => 'required|date',
            'step_type' => 'required',
            'selectedAlquimiaConnection' => [
                function ($attribute, $value, $fail) {
                    if ($this->step_type === 'AL' && empty($value)) {
                        $fail('Debe seleccionar una conexión de Alquimia.');
                    }
                }
            ],
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
            'order' => 'orden',
            'available_from' => 'Disponible desde',
            'step_type' => 'tipo',
            'selectedAlquimiaConnection' => 'conexión de Alquimia',
        ]);

        $step = Step::findOrFail($this->stepId);
        $step->name = $this->name;
        $step->description = $this->description;
        $step->available_from = $this->available_from;
        $step->step_type = $this->step_type;
        $step->save();

        switch ($this->step_type) {
            case 'AL':
                $agent = ProcessAlquimiaAgent::where('step_id', $step->id)->first();
                if ($agent) {
                    $agent->name = $this->name;
                    $agent->description = $this->description;
                    $agent->alquimia_connection_id = $this->selectedAlquimiaConnection;
                    $agent->save();
                }
                break;

            case 'AT':
                $processAdvisorScheduling = ProcessAdvisorScheduling::where('step_id', $step->id)->first();
                if ($processAdvisorScheduling) {
                    $processAdvisorScheduling->name = $this->name;
                    $processAdvisorScheduling->embed = $this->schedulingEmbed;
                    $processAdvisorScheduling->required_steps = json_encode($this->selectedRequiredSteps);
                    $processAdvisorScheduling->save();
                }
                break;

            case 'VP':
                $processComplianceVerification = ProcessComplianceVerification::where('step_id', $step->id)->first();
                if ($processComplianceVerification) {
                    $processComplianceVerification->embed = $this->complianceEmbed;
                    $processComplianceVerification->required_steps = json_encode($this->selectedRequiredSteps);
                    $processComplianceVerification->save();
                }
                break;

            case 'LZ':
                $form = InformationForm::where('step_id', $step->id)->first();
                if ($form) {
                    $form->name = $this->name;
                    $form->description = $this->description;
                    $form->save();
                }
                break;

            case 'PT':
                $processTest = ProcessTest::where('step_id', $step->id)->first();
                if ($processTest) {
                    $processTest->name = $this->name;
                    $processTest->description = $this->description;
                    $processTest->save();
                }
                break;

            case 'CV':
                $processComplianceVerification = ProcessComplianceVerification::where('step_id', $step->id)->first();
                if ($processComplianceVerification) {
                    $processComplianceVerification->embed = $this->complianceEmbed;
                    $processComplianceVerification->required_steps = json_encode($this->selectedRequiredSteps);
                    $processComplianceVerification->save();
                }
                break;

            default:
                break;
        }

        $this->emit('alert', ['type' => 'success', 'message' => 'Paso actualizado correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->stepId = $id;
    }

    public function destroy()
    {
        $step = Step::find($this->stepId);
        $step->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Paso eliminado correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->order = '';
        $this->available_from = '';
        $this->step_type = '';
        $this->stepId = '';
        $this->stagesList = [];
        $this->stepsList = [];
        $this->processM = '';
        $this->stageM = '';
        $this->stepM = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }

    public function updateOrder($order)
    {
        foreach ($order as $index => $id) {
            $step = Step::find($id);
            $step->order = $index + 1;
            $step->save();
        }

        $this->emit('orderUpdated');
    }

    public function updatedProcessM($processId)
    {
        if ($processId) {
            $this->stagesList = Stage::where('process_id', '=', $processId)->get();
            $this->stepsList = [];
        } else {
            $this->stepsList = [];
            $this->stagesList = [];
        }
    }

    public function updatedStageM($stageId)
    {

        if ($stageId) {
            $this->stepsList = Step::where('stage_id', '=', $stageId)->get();
        } else {
            $this->stepsList = [];
        }
    }

    public function duplicate()
    {
        $step = step::find($this->stepM);
        if ($step) {
            $lastStep = Step::where('stage_id', $this->stageId)
                ->orderBy('order', 'desc')
                ->first();

            $newOrder = $lastStep ? $lastStep->order + 1 : 1;

            $newStep = new Step();
            $newStep->name = $step->name . '_copy';
            $newStep->description = $step->description;
            $newStep->order = $newOrder;
            $newStep->available_from = $step->available_from;
            $newStep->step_type = $step->step_type;
            $newStep->stage_id = $this->stageId;
            $newStep->save();

            switch ($newStep->step_type) {
                case 'F':
                    $formOrigin = InformationForm::where('step_id', '=', $step->id)->first();
                    if ($formOrigin) {
                        $formOriginId = $formOrigin->id;
                        DB::transaction(function () use ($formOriginId, $newStep) {
                            $originalForm = InformationForm::findOrFail($formOriginId);

                            $newForm = $originalForm->replicate();
                            $newFormName = $originalForm->name;
                            $counter = 1;
                            while (InformationForm::where('name', $newFormName)->exists()) {
                                $newFormName = $originalForm->name . '_copy' . ($counter > 1 ? $counter : '');
                                $counter++;
                            }
                            $newForm->name = $newFormName;
                            $newForm->step_id = $newStep->id;
                            $newForm->save();

                            foreach ($originalForm->questions as $question) {
                                $newQuestion = $question->replicate();
                                $newQuestion->information_form_id = $newForm->id;
                                $newQuestion->save();

                                foreach ($question->options as $option) {
                                    $newOption = $option->replicate();
                                    $newOption->information_form_question_id = $newQuestion->id;
                                    $newOption->save();
                                }
                            }
                        });
                    }

                    break;
                case 'M':
                    $mentors = Mentor::where('step_id', '=', $step->id)->get();
                    DB::transaction(function () use ($mentors, $newStep) {
                        foreach ($mentors as $mentorOrigin) {
                            $newMentor = $mentorOrigin->replicate();
                            $newMentor->step_id = $newStep->id;
                            $newMentor->save();

                            foreach ($mentorOrigin->availabilities as $availability) {
                                $newAvailability = $availability->replicate();
                                $newAvailability->mentor_id = $newMentor->id;
                                $newAvailability->save();
                            }
                        }
                    });
                    break;
                case 'CD':
                    $challenges = Challenge::where('step_id', $step->id)->get();

                    DB::transaction(function () use ($challenges, $newStep) {
                        foreach ($challenges as $challengeOrigin) {
                            $newChallenge = $challengeOrigin->replicate();
                            $newChallenge->step_id = $newStep->id;
                            $newChallenge->save();
                        }
                    });
                    break;
                case 'FAA':
                    $activities = PresentialActivity::where('step_id', '=', $step->id)->get();
                    DB::transaction(function () use ($activities, $newStep) {
                        foreach ($activities as $activityOrigin) {
                            $newActivity = $activityOrigin->replicate();
                            $newActivity->step_id = $newStep->id;
                            $newActivity->save();

                            foreach ($activityOrigin->groups as $group) {
                                $newGroup = $group->replicate();
                                $newGroup->presential_activity_id = $newActivity->id;
                                $newGroup->save();
                            }
                        }
                    });
                    break;
                case 'LMS':
                    $courses = Course::where('step_id', '=', $step->id)->get();
                    DB::transaction(function () use ($courses, $newStep) {
                        foreach ($courses as $courseOrigin) {
                            $newCourse = $courseOrigin->replicate();
                            $newCourse->step_id = $newStep->id;
                            $newCourse->save();

                            foreach ($courseOrigin->topics as $topic) {
                                $newTopic = $topic->replicate();
                                $newTopic->course_id = $newCourse->id;
                                $newTopic->save();

                                foreach ($topic->lessons as $lesson) {
                                    $newLesson = $lesson->replicate();
                                    $newLesson->topic_id = $newTopic->id;
                                    $newLesson->save();
                                }
                            }
                        }
                    });
                    break;
                case 'LZ':
                    $canvas = Canva::where('step_id', '=', $step->id)->get();
                    DB::transaction(function () use ($canvas, $newStep) {
                        foreach ($canvas as $canvaOrigin) {
                            $newCanva = $canvaOrigin->replicate();
                            $newCanva->step_id = $newStep->id;
                            $newCanva->save();


                            $originalForm = InformationForm::find($canvaOrigin->information_form_id);
                            if ($originalForm) {
                                $newForm = $originalForm->replicate();
                                $newForm->step_id = null;
                                $newForm->save();


                                $newCanva->information_form_id = $newForm->id;
                                $newCanva->save();

                                foreach ($originalForm->questions as $question) {
                                    $newQuestion = $question->replicate();
                                    $newQuestion->information_form_id = $newForm->id;
                                    $newQuestion->save();

                                    foreach ($question->options as $option) {
                                        $newOption = $option->replicate();
                                        $newOption->information_form_question_id = $newQuestion->id;
                                        $newOption->save();
                                    }
                                }
                            }
                        }
                    });
                    break;
                case 'AL':
                    $agents = ProcessAlquimiaAgent::where('step_id', $step->id)->get();

                    DB::transaction(function () use ($agents, $newStep) {
                        foreach ($agents as $agentOrigin) {
                            // 1️⃣ Duplicar el agente
                            $newAgent = $agentOrigin->replicate();
                            $newAgent->step_id = $newStep->id;
                            $newAgent->save();

                            // Mapa de correspondencia entre IDs antiguos y nuevos
                            $idMap = [];

                            // 2️⃣ Primera pasada: duplicar preguntas y guardar correspondencias
                            foreach ($agentOrigin->questions as $questionOrigin) {
                                $newQuestion = $questionOrigin->replicate();
                                $newQuestion->process_alquimia_agent_id = $newAgent->id;
                                $newQuestion->save();

                                $idMap[$questionOrigin->id] = $newQuestion->id;
                            }

                            // 3️⃣ Segunda pasada: actualizar los contexts
                            foreach ($agentOrigin->questions as $questionOrigin) {
                                if ($questionOrigin->contexts) {
                                    $originalContexts = json_decode($questionOrigin->contexts, true);

                                    if (is_array($originalContexts)) {
                                        // Reemplazar IDs antiguos por los nuevos (si existen)
                                        $newContexts = array_map(function ($oldId) use ($idMap) {
                                            return $idMap[$oldId] ?? $oldId; // si no existe, se deja igual
                                        }, $originalContexts);

                                        // Buscar la pregunta nueva correspondiente
                                        $newQuestionId = $idMap[$questionOrigin->id] ?? null;
                                        if ($newQuestionId) {
                                            ProcessAlquimiaAgentQuestion::where('id', $newQuestionId)
                                                ->update(['contexts' => json_encode($newContexts)]);
                                        }
                                    }
                                }
                            }
                        }
                    });

                    break;
                case 'PT':
                    $tests = ProcessTest::where('step_id', $step->id)
                        ->with([
                            'appreciations',
                            'categories.subcategories.questions.options',
                            'categories.appreciations',
                            'categories.subcategories.appreciations',
                            'questions.options'
                        ])
                        ->get();

                    DB::transaction(function () use ($tests, $newStep) {
                        foreach ($tests as $testOrigin) {
                            // 🟢 1️⃣ Duplicar el test principal
                            $newTest = $testOrigin->replicate();
                            $newTest->step_id = $newStep->id;
                            $newTest->name = $testOrigin->name . '_copy';
                            $newTest->save();

                            // 🟢 2️⃣ Apreciaciones del test
                            foreach ($testOrigin->appreciations as $appreciationOrigin) {
                                $newAppreciation = $appreciationOrigin->replicate();
                                $newAppreciation->process_test_id = $newTest->id;
                                $newAppreciation->save();
                            }

                            // 🟢 3️⃣ Categorías
                            foreach ($testOrigin->categories as $categoryOrigin) {
                                $newCategory = $categoryOrigin->replicate();
                                $newCategory->process_test_id = $newTest->id;
                                $newCategory->save();

                                // 3.1️⃣ Apreciaciones de categoría
                                foreach ($categoryOrigin->appreciations as $catAppreciationOrigin) {
                                    $newCatAppreciation = $catAppreciationOrigin->replicate();
                                    $newCatAppreciation->p_test_category_id = $newCategory->id;
                                    $newCatAppreciation->save();
                                }

                                // 3.2️⃣ Subcategorías
                                foreach ($categoryOrigin->subcategories as $subOrigin) {
                                    $newSub = $subOrigin->replicate();
                                    $newSub->p_test_category_id = $newCategory->id;
                                    $newSub->save();

                                    // 3.2.1️⃣ Apreciaciones de subcategoría
                                    foreach ($subOrigin->appreciations as $subAppreciationOrigin) {
                                        $newSubAppreciation = $subAppreciationOrigin->replicate();
                                        $newSubAppreciation->p_test_subcategory_id = $newSub->id;
                                        $newSubAppreciation->save();
                                    }

                                    // 3.2.2️⃣ Preguntas de subcategoría
                                    foreach ($subOrigin->questions as $questionOrigin) {
                                        $newQuestion = $questionOrigin->replicate();
                                        $newQuestion->process_test_id = $newTest->id;
                                        $newQuestion->p_test_subcategory_id = $newSub->id;
                                        $newQuestion->save();

                                        // 3.2.3️⃣ Opciones de la pregunta
                                        foreach ($questionOrigin->options as $optionOrigin) {
                                            $newOption = $optionOrigin->replicate();
                                            $newOption->process_test_id = $newTest->id;
                                            $newOption->p_test_question_id = $newQuestion->id;
                                            $newOption->save();
                                        }
                                    }
                                }
                            }

                            // 🟢 4️⃣ Preguntas directamente asociadas al test (sin subcategoría)
                            foreach ($testOrigin->questions->whereNull('p_test_subcategory_id') as $questionOrigin) {
                                $newQuestion = $questionOrigin->replicate();
                                $newQuestion->process_test_id = $newTest->id;
                                $newQuestion->save();

                                // 4.1️⃣ Opciones de estas preguntas
                                foreach ($questionOrigin->options as $optionOrigin) {
                                    $newOption = $optionOrigin->replicate();
                                    $newOption->process_test_id = $newTest->id;
                                    $newOption->p_test_question_id = $newQuestion->id;
                                    $newOption->save();
                                }
                            }
                        }
                    });

                    break;

                case 'CV':
                    $verifications = ProcessComplianceVerification::where('step_id', $step->id)
                        ->with(['questions', 'answers'])
                        ->get();

                    DB::transaction(function () use ($verifications, $newStep) {
                        foreach ($verifications as $verificationOrigin) {
                            // 🟢 1️⃣ Duplicar la verificación principal
                            $newVerification = $verificationOrigin->replicate();
                            $newVerification->step_id = $newStep->id;
                            $newVerification->required_steps = null; // vacío
                            $newVerification->save();

                            // 🟢 2️⃣ Duplicar preguntas asociadas
                            foreach ($verificationOrigin->questions as $questionOrigin) {
                                $newQuestion = $questionOrigin->replicate();
                                $newQuestion->pc_verification_id = $newVerification->id;
                                $newQuestion->save();

                                // 🟢 3️⃣ Duplicar respuestas (si existen y quieres conservarlas)
                                foreach ($questionOrigin->answers as $answerOrigin) {
                                    $newAnswer = $answerOrigin->replicate();
                                    $newAnswer->question_id = $newQuestion->id;
                                    $newAnswer->pc_verification_id = $newVerification->id;
                                    $newAnswer->save();
                                }
                            }

                            // 🟢 4️⃣ Duplicar respuestas directas de la verificación (si aplica)
                            foreach ($verificationOrigin->answers->whereNull('question_id') as $answerOrigin) {
                                $newAnswer = $answerOrigin->replicate();
                                $newAnswer->pc_verification_id = $newVerification->id;
                                $newAnswer->save();
                            }
                        }
                    });
                    break;

                case 'AT':
                    $schedulings = ProcessAdvisorScheduling::where('step_id', $step->id)->get();

                    DB::transaction(function () use ($schedulings, $newStep) {
                        foreach ($schedulings as $schedulingOrigin) {
                            $newScheduling = $schedulingOrigin->replicate();
                            $newScheduling->step_id = $newStep->id;
                            $newScheduling->save();
                        }
                    });
                    break;


                default:

                    break;
            }
            $this->emit('alert', ['type' => 'success', 'message' => 'Paso duplicado correctamente']);
            $this->cancel();
        } else {
            $this->emit('alert', ['type' => 'error', 'message' => 'no ha seleccionado un paso']);
        }
    }
}
