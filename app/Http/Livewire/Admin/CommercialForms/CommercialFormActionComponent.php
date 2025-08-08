<?php

namespace App\Http\Livewire\Admin\CommercialForms;

use App\CommercialForm;
use App\CommercialLand;
use Dirape\Token\Token;
use Livewire\Component;
use App\CommercialAction;
use App\CommercialStrategy;
use App\CommercialFormAction;

class CommercialFormActionComponent extends Component
{
    public $lands,
        $strategies,
        $actions;

    public $landId,
        $strategyId,
        $actionId;

    public $link, $token;

    public $form,
        $actionFormId;

    public function mount($form)
    {
        $this->form = CommercialForm::find($form);
        $this->lands = CommercialLand::all();
        $this->strategies = collect();
        $this->actions = collect();
    }

    public function render()
    {

        $actionsForms = CommercialFormAction::select(
            'commercial_form_actions.id as action_form_id',
            'commercial_forms.name as form_name',
            'commercial_forms.description as form_description',
            'commercial_actions.name as action_name',
            'commercial_strategies.name as strategy_name',
            'commercial_lands.name as land_name',
        )
            ->join('commercial_actions', 'commercial_actions.id', '=', 'commercial_form_actions.commercial_action_id')
            ->join('commercial_strategies', 'commercial_strategies.id', '=', 'commercial_actions.commercial_strategy_id')
            ->join('commercial_lands', 'commercial_lands.id', '=', 'commercial_strategies.commercial_land_id')
            ->join('commercial_forms', 'commercial_forms.id', '=', 'commercial_form_actions.commercial_form_id')
            ->where('commercial_form_id', '=', $this->form->id)->get();

        return view('livewire.admin.commercial-forms.commercial-form-action-component', [
            'actionsForms' => $actionsForms
        ]);

    }

    public function store()
    {
        if ($this->actionId) {

            $action = CommercialFormAction::where('commercial_action_id', '=', $this->actionId)
                ->where('commercial_form_id', '=', $this->form->id)
                ->first();

            if ($action == '') {
                $action = new CommercialFormAction();
                $action->commercial_form_id = $this->form->id;
                $action->commercial_action_id = $this->actionId;
                $action->token = (new Token())->Unique('commercial_form_actions', 'token', 20);
                $action->save();
                $this->emit('alert', ['type' => 'success', 'message' => 'Acción agragada correctamente']);

                $this->strategies = collect();
                $this->actions = collect();
                $this->landId = '';
                $this->strategyId = '';
                $this->actionId = '';
            } else {
                $this->emit('alert', ['type' => 'error', 'message' => 'La acción ya se encuentra agregada']);
            }
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

    public function delete($id)
    {
        $this->actionFormId = $id;
    }

    public function destroy()
    {
        $form = CommercialFormAction::find($this->actionFormId);
        $form->delete();

        $this->actionFormId = '';

        $this->emit('alert', ['type' => 'success', 'message' => 'Acción eliminada correctamente']);
        $this->emit('close-modal');
    }

    public function getLink($id)
    {
        $form = CommercialFormAction::where('id', '=', $id)->first();

        $this->link = url('') . '/form/' . $form->token;
    }

    public function getToken($id)
    {
        $form = CommercialFormAction::where('id', '=', $id)->first();

        $this->token = $form->token;
        
    }

    public function cancel()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }

    public function hydrate()
    {
        $this->emit('select2');
    }
}
