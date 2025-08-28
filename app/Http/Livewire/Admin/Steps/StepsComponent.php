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
use App\Models\ProcessAlquimiaAgent;
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

    public $selectedAlquimiaConnection;

    public function mount($id)
    {
        $this->stageId = $id;
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

        $step = Step::find($this->stepId);
        $step->name = $this->name;
        $step->description = $this->description;
        $step->available_from = $this->available_from;
        $step->step_type = $this->step_type;
        $step->update();

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

            case 'LZ':
                $canvaUpdate = InformationForm::where('step_id', $step->id)->first();
                if ($canvaUpdate) {
                    $canvaUpdate->name = $this->name;
                    $canvaUpdate->description = $this->description;
                    $canvaUpdate->save();
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
                            // Duplicamos el agente
                            $newAgent = $agentOrigin->replicate();
                            $newAgent->step_id = $newStep->id;
                            $newAgent->save();

                            // Duplicamos sus preguntas
                            foreach ($agentOrigin->questions as $questionOrigin) {
                                $newQuestion = $questionOrigin->replicate();
                                $newQuestion->process_alquimia_agent_id = $newAgent->id;
                                $newQuestion->save();
                            }
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
