<?php

namespace App\Http\Livewire\Admin\Stages;

use App\Models\Stage;
use App\CommercialLand;
use App\Models\Process;
use Livewire\Component;
use App\CommercialAction;
use App\CommercialStrategy;
use Livewire\WithPagination;
use App\Models\InformationForm;
use Illuminate\Validation\Rule;

class StagesComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $name,
        $description,
        $embebed,
        $link,
        $stageId,
        $processId;

    public $token;

    public $searchName;

    public $lands, $strategies, $actions;
    public $landId, $strategyId, $actionId;

    public $formType = 'internal';

    public $formId, $form, $stage;

    public  $active = 0, $embebedVideo;

    public function mount($id)
    {

        //Lists dropdowns filter
        $this->lands = CommercialLand::all();
        $this->strategies = collect();
        $this->actions = collect();
        $this->processId = $id;
    }

    public function render()
    {
        $stages = Stage::when($this->searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })
            ->where('process_id', '=', $this->processId)
            ->paginate(6);

        $firstItem = $stages->firstItem();
        $lastItem = $stages->lastItem();
        $process = Process::find($this->processId);

        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$stages->total()} registros";

        return view('livewire.admin.stages.stages-component', [
            'stages' => $stages,
            'paginationText' => $paginationText,
            'process' => $process
        ]);
    }

    public function show($id)
    {
        $this->stageId = $id;

        $stage = Stage::find($id);
        $this->name = $stage->name;
        $this->description = $stage->description;
        $this->embebed = $stage->embebed;
        $this->link = $stage->link;
        $this->processId = $stage->process_id;
        $this->landId = $stage->land ? $stage->land->name :  null;
        $this->strategyId = $stage->strategy ? $stage->strategy->name :  null;
        $this->actionId = $stage->action ? $stage->action->name :  null;
        $this->active = $stage->active;
        $this->embebedVideo = $stage->embebed_video;
    }

    public function store()
    {
        $this->validate([
            'name' => [
                'required',
                Rule::unique('stages')->where(function ($query) {
                    return $query->where('process_id', $this->processId);
                })
            ],
            'description' => 'required',
            'embebed' => 'nullable',
            'link' => 'nullable',
            'landId' => 'required',
            'strategyId' => 'required',
            'actionId' => 'required',
            'embebedVideo' => 'nullable',
            'active'=>'required'
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
            'embebed' => 'embebido',
            'link' => 'enlace',
            'landId' => 'terreno comercial',
            'strategyId' => 'estrategia comercial',
            'actionId' => 'acción comercial',
            'embebedVideo' => 'video',
            'active'=>'activo'
        ]);

        $stage = new Stage();
        $stage->name = $this->name;
        $stage->description = $this->description;
        $stage->embebed = $this->embebed;
        $stage->link = $this->link;
        $stage->process_id = $this->processId;
        $stage->land_id = $this->landId;
        $stage->strategy_id = $this->strategyId;
        $stage->action_id = $this->actionId;
        $stage->active = $this->active;
        $stage->embebed_video = $this->embebedVideo;
        $stage->save();

        $process = Process::find($this->processId);
        $form =  new InformationForm();
        $form->name = 'Formulario de inscripcion, etapa ' . $stage->name . ', proceso ' . $process->name;
        $form->description = $form->name;
        $form->stage_id = $stage->id;
        $form->token = $this->slugify($form->name);
        $form->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Etapa creado correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {

        $this->stageId = $id;
        $stage = Stage::find($id);
        $this->name = $stage->name;
        $this->description = $stage->description;
        $this->embebed = $stage->embebed;
        $this->link = $stage->link;
        $this->active = $stage->active;
        $this->embebedVideo = $stage->embebed_video;

        $this->landId = $stage->land_id;
        $this->strategies = CommercialStrategy::where('commercial_land_id', '=', $this->landId)->get();
        $this->strategyId = $stage->strategy_id;
        $this->actions = CommercialAction::where('commercial_strategy_id', '=', $this->strategyId)->get();
        $this->actionId = $stage->action_id;
    }

    public function update()
    {

        $this->validate([
            'name' => [
                'required',
                function ($attribute, $value, $fail) {
                    $existingStage = Stage::where('name', $value)
                        ->where('process_id', $this->processId)
                        ->where('id', '!=', $this->stageId)
                        ->first();
                    if ($existingStage) {
                        $fail('El nombre de la etapa ya existe en este proceso.');
                    }
                },
            ],
            'description' => 'required',
            'embebed' => 'nullable',
            'link' => 'nullable',
            'landId' => 'required',
            'strategyId' => 'required',
            'actionId' => 'required',
            'embebedVideo' => 'nullable',
            'active'=>'required'
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
            'embebed' => 'embebido',
            'link' => 'enlace',
            'landId' => 'terreno comercial',
            'strategyId' => 'estrategia comercial',
            'actionId' => 'acción comercial',
            'embebedVideo' => 'video',
            'active'=>'activo'
        ]);

        $stage = Stage::find($this->stageId);
        $stage->name = $this->name;
        $stage->description = $this->description;
        $stage->embebed = $this->embebed;
        $stage->link = $this->link;
        $stage->land_id = $this->landId;
        $stage->strategy_id = $this->strategyId;
        $stage->action_id = $this->actionId;
        $stage->active = $this->active;
        $stage->embebed_video = $this->embebedVideo;
        $stage->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Etapa actualizado correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->stageId = $id;
    }

    public function destroy()
    {
        $stage = Stage::with('contactsStages')->find($this->stageId);

        if ($stage->contactsStages->isNotEmpty()) {
            $this->emit('alert', ['type' => 'error', 'message' => 'No se puede eliminar la etapa porque tiene postulados asociados']);
            return;
        }

        $stage->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Etapa eliminada correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->embebed = '';
        $this->link = '';
        $this->stageId = '';
        $this->landId = '';
        $this->strategyId = '';
        $this->actionId = '';
        $this->formId = '';
        $this->form = '';
        $this->stage = '';
        $this->strategies = collect();
        $this->actions = collect();
        $this->active = '';
        $this->embebedVideo = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }

    public function slugify($text)
    {
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = preg_replace('~[^\\pL\d-]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        $text = preg_replace('~[-]+~', '-', $text);

        return $text;
    }

    public function getToken($id)
    {
        $stage = Stage::find($id);
        if ($stage->link) {
            $this->token = $stage->link;
        } else {
            $form = InformationForm::where('id', '=', $stage->form->id)->first();
            $token = $form->token;
            $this->token = url('external-form/' . $token);
        }
    }

    public function updatedLandId($land)
    {
        if ($land != '') {
            $this->strategies = CommercialStrategy::where('commercial_land_id', '=', $land)->get();
        } else {
            $this->strategies = collect();
            $this->actions = collect();
            $this->landId = '';
            $this->strategyId = '';
            $this->actionId = '';
        }
    }

    public function updatedStrategyId($strategy)
    {
        if ($strategy != '') {
            $this->actions = CommercialAction::where('commercial_strategy_id', '=', $strategy)->get();
        } else {
            $this->actions = collect();
            $this->strategyId = '';
            $this->actionId = '';
        }
    }

    public function preview($id)
    {
        $this->stage = Stage::find($id);
        if ($this->stage) {
            $this->form = InformationForm::where('stage_id', $this->stage->id)->first();
            $this->formId = $this->form ? $this->form->id : null;
        } else {
            $this->form = null;
            $this->formId = null;
        }
    }

    public function hydrate()
    {
        $this->emit('select2');
    }
}
