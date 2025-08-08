<?php

namespace App\Http\Livewire\Admin\Processes;


use App\Models\Process;
use Livewire\Component;
use Livewire\WithPagination;

class ProcessesComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $name,
        $description,
        $processId;

    public $searchName;


    public function render()
    {

        $processes = Process::when($this->searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })->paginate(6);

        $firstItem = $processes->firstItem();
        $lastItem = $processes->lastItem();

        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$processes->total()} registros";


        return view('livewire.admin.processes.processes-component', [
            'processes' => $processes,
            'paginationText' => $paginationText,
        ]);
    }

    public function show($id)
    {
        $this->processId = $id;

        $process = Process::find($id);
        $this->name = $process->name;
        $this->description = $process->description;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|unique:processes,name',
            'description' => 'required',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
        ]);

        $process = new Process();
        $process->name = $this->name;
        $process->description = $this->description;
        $process->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Proceso creado correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->processId = $id;

        $process = Process::find($id);
        $this->name = $process->name;
        $this->description = $process->description;
    }

    public function update()
    {

        $this->validate([
            'name' => 'required|unique:processes,name,' . $this->processId,
            'description' => 'required',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
        ]);

        $process = Process::find($this->processId);
        $process->name = $this->name;
        $process->description = $this->description;
        $process->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Proceso actualizado correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->processId = $id;
    }

    public function destroy()
    {
        $process = Process::with('stages')->find($this->processId);

        if ($process->stages->isNotEmpty()) {
            $this->emit('alert', ['type' => 'error', 'message' => 'No se puede eliminar el proceso porque tiene etapas asociadas']);
            return;
        }

        $process->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Proceso eliminado correctamente']);
        $this->cancel();
    }



    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->processId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();

        $this->resetErrorBag();
        $this->resetValidation();

        $this->emit('close-modal');
    }
}
