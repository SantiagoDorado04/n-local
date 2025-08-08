<?php

namespace App\Http\Livewire\Admin\CommercialStrategy;

use App\CommercialLand;
use Livewire\Component;
use App\CommercialStrategy;

class CommercialStrategyComponent extends Component
{
    public $name,
        $description,
        $strategyId;
    public $land;

    public $searchName;

    public function mount($land)
    {
        $this->land = CommercialLand::find($land);
    }

    public function render()
    {
        $strategies = CommercialStrategy::when($this->searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })
            ->where('commercial_land_id', '=', $this->land->id)
            ->get();

        return view('livewire.admin.commercial-strategy.commercial-strategy-component', [
            'strategies' => $strategies
        ]);
    }

    public function show($id)
    {
        $this->strategyId = $id;

        $strategy = CommercialStrategy::find($id);
        $this->name = $strategy->name;
        $this->description = $strategy->description;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|unique:commercial_strategies,name',
            'description' => 'required',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
        ]);

        $strategy = new CommercialStrategy();
        $strategy->name = $this->name;
        $strategy->description = $this->description;
        $strategy->commercial_land_id = $this->land->id;
        $strategy->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Estrategia comercial creada correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->strategyId = $id;

        $strategy = CommercialStrategy::find($id);
        $this->name = $strategy->name;
        $this->description = $strategy->description;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|unique:commercial_strategies,name,' . $this->strategyId,
            'description' => 'required',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
        ]);

        $strategy = CommercialStrategy::find($this->strategyId);
        $strategy->name = $this->name;
        $strategy->description = $this->description;
        $strategy->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Estrategia comercial actualizada correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->strategyId = $id;
    }

    public function destroy()
    {

        $strategy = CommercialStrategy::find($this->strategyId);
        $strategy->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Estrategia comercial eliminada correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->strategyId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
