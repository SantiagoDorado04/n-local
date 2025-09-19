<?php

namespace App\Http\Livewire\Admin\ProcessTests;

use App\Models\ProcessTest;
use App\Models\ProcessTestAppreciation;
use App\Models\Step;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ProcessTestAppreciationsComponent extends Component
{

    public $process_test_id;
    public $processTest;
    public $step_id;
    public $title, $appreciation, $start_points, $end_points;
    public $appreciationId;

    public function mount($id)
    {
        $this->step_id = $id;
        $this->processTest = ProcessTest::where('step_id', $this->step_id)->first();
        $this->process_test_id = $this->processTest->id;
    }

    public function render()
    {

        $appreciations = ProcessTestAppreciation::where('process_test_id', '=', $this->process_test_id)
            ->paginate(6);

        $firstItem = $appreciations->firstItem();
        $lastItem = $appreciations->lastItem();

        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$appreciations->total()} registros";

        $step = Step::find($this->step_id);

        return view('livewire..admin.process-tests.process-test-appreciations-component', [
            'appreciations' => $appreciations,
            'processTest' => $this->processTest,
            'paginationText' => $paginationText,
            'step' => $step,
        ]);
    }

    public function show($id)
    {
        $this->appreciationId = $id;

        $appreciation = ProcessTestAppreciation::find($id);
        $this->title = $appreciation->title;
        $this->appreciation = $appreciation->appreciation;
        $this->start_points = $appreciation->start_points;
        $this->end_points = $appreciation->end_points;
    }

    public function store()
    {
        $this->validate([
            'title' => [
                'required',
                Rule::unique('process_test_appreciations')->where(function ($query) {
                    return $query->where('process_test_id', $this->process_test_id);
                })
            ],
            'appreciation' => 'required',
            'start_points' => 'required|integer',
            'end_points' => 'required|integer',
        ], [], [
            'title' => 'título',
            'appreciation' => 'apreciacion',
            'start_points' => 'puntos de inicio',
            'end_points' => 'puntos de fin',
        ]);

        $appreciation = new ProcessTestAppreciation();
        $appreciation->title = $this->title;
        $appreciation->appreciation = $this->appreciation;
        $appreciation->start_points = $this->start_points;
        $appreciation->end_points = $this->end_points;
        $appreciation->process_test_id = $this->process_test_id;
        $appreciation->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Apreciacion creada correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->appreciationId = $id;
        $appreciation = ProcessTestAppreciation::findOrFail($id);

        $this->title = $appreciation->title;
        $this->appreciation = $appreciation->appreciation;
        $this->start_points = $appreciation->start_points;
        $this->end_points = $appreciation->end_points;
        $this->process_test_id = $appreciation->process_test_id;
    }


    public function update()
    {
        $this->validate([
            'title' => [
                'required',
                Rule::unique('process_test_appreciations')
                    ->where(fn($query) => $query->where('process_test_id', $this->process_test_id))
                    ->ignore($this->appreciationId),
            ],
            'appreciation' => 'required',
            'start_points' => 'required|integer',
            'end_points' => 'required|integer',
        ], [], [
            'title' => 'título',
            'appreciation' => 'apreciación',
            'start_points' => 'puntos de inicio',
            'end_points' => 'puntos de fin',
        ]);

        $appreciation = ProcessTestAppreciation::findOrFail($this->appreciationId);
        $appreciation->title = $this->title;
        $appreciation->appreciation = $this->appreciation;
        $appreciation->start_points = $this->start_points;
        $appreciation->end_points = $this->end_points;
        $appreciation->process_test_id = $this->process_test_id;
        $appreciation->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Apreciación actualizada correctamente']);
        $this->cancel();
    }


    public function delete($id)
    {
        $this->appreciationId = $id;
    }

    public function destroy()
    {
        $appreciation = ProcessTestAppreciation::findOrFail($this->appreciationId);

        $appreciation->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Apreciación eliminada correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->title = '';
        $this->appreciation = '';
        $this->start_points = '';
        $this->appreciationId = '';
        $this->end_points = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
