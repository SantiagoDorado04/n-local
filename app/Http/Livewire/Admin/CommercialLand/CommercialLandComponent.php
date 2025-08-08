<?php

namespace App\Http\Livewire\Admin\CommercialLand;

use App\CommercialLand;
use Livewire\Component;
use Livewire\WithPagination;

class CommercialLandComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $name,
        $description,
        $landId;

    public $searchName;

    public function render()
    {
        $lands = CommercialLand::when($this->searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })->paginate(6);

        $firstItem = $lands->firstItem();
        $lastItem = $lands->lastItem();

        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$lands->total()} registros";

        return view('livewire.admin.commercial-land.commercial-land-component', [
            'lands' => $lands,
            'paginationText' => $paginationText,
        ]);
    }

    public function show($id)
    {
        $this->landId = $id;

        $land = CommercialLand::find($id);
        $this->name = $land->name;
        $this->description = $land->description;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|unique:commercial_lands,name',
            'description' => 'required',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
        ]);

        $land = new CommercialLand();
        $land->name = $this->name;
        $land->description = $this->description;
        $land->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Terreno comercial creado correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {

        $this->landId = $id;

        $land = CommercialLand::find($id);
        $this->name = $land->name;
        $this->description = $land->description;
    }

    public function update()
    {

        $this->validate([
            'name' => 'required|unique:commercial_lands,name,' . $this->landId,
            'description' => 'required',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
        ]);

        $land = CommercialLand::find($this->landId);
        $land->name = $this->name;
        $land->description = $this->description;
        $land->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Terreno comercial actualizado correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->landId = $id;
    }

    public function destroy()
    {
        $land = CommercialLand::find($this->landId);
        $land->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Terreno comercial eliminado correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->landId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
