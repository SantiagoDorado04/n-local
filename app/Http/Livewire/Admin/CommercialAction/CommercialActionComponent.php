<?php

namespace App\Http\Livewire\Admin\CommercialAction;

use Livewire\Component;
use App\CommercialAction;
use App\CommercialLand;
use App\CommercialStrategy;

class CommercialActionComponent extends Component
{
    public $name,
        $description,
        $actionId;

    public $strategy,
        $land;

    public $searchName;

    public function mount($strategy)
    {
        $this->strategy = CommercialStrategy::find($strategy);
        $this->land = CommercialLand::find($this->strategy->commercial_land_id);
    }

    public function render()
    {
        $actions = CommercialAction::when($this->searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })
            ->where('commercial_strategy_id', '=', $this->strategy->id)
            ->get();
        return view('livewire.admin.commercial-action.commercial-action-component', [
            'actions' => $actions
        ]);
    }

    public function show($id)
    {
        $this->actionId = $id;

        $action = CommercialAction::find($id);
        $this->name = $action->name;
        $this->description = $action->description;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|unique:commercial_actions,name',
            'description' => 'required',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
        ]);

        $action = new CommercialAction();
        $action->name = $this->name;
        $action->description = $this->description;
        $action->commercial_strategy_id = $this->strategy->id;
        $action->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Acción comercial creada correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->actionId = $id;

        $action = CommercialAction::find($id);
        $this->name = $action->name;
        $this->description = $action->description;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|unique:commercial_actions,name,' . $this->actionId,
            'description' => 'required',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
        ]);

        $action = CommercialAction::find($this->actionId);
        $action->name = $this->name;
        $action->description = $this->description;
        $action->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Acción comercial actualizada correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->actionId = $id;
    }

    public function destroy()
    {

        $action = CommercialAction::find($this->actionId);
        $action->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Acción comercial eliminada correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->actionId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
