<?php

namespace App\Http\Livewire\Admin\ProcessTests\ProcessTestsCategories;

use App\Models\ProcessTestCategory;
use App\Models\PTestCategoryAppreciation;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ProcessTestCategoriesAppreciationsComponent extends Component
{

    public $p_test_category_id;
    public $category;
    public $title, $appreciation, $start_points, $end_points;
    public $appreciationId;

    public function mount($id)
    {
        $this->p_test_category_id = $id;
        $this->category = ProcessTestCategory::findOrFail($id);
    }
    public function render()
    {

        $appreciations = PTestCategoryAppreciation::where('p_test_category_id', $this->p_test_category_id)
            ->paginate(6);

        $firstItem = $appreciations->firstItem();
        $lastItem = $appreciations->lastItem();

        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$appreciations->total()} registros";

        return view('livewire..admin.process-tests.process-tests-categories.process-test-categories-appreciations-component', [
            'appreciations' => $appreciations,
            'category' => $this->category,
            'paginationText' => $paginationText,
        ]);
    }

    public function show($id)
    {
        $this->appreciationId = $id;

        $appreciation = PTestCategoryAppreciation::findOrFail($id);
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
                Rule::unique('p_test_category_appreciations')->where(function ($query) {
                    return $query->where('p_test_category_id', $this->p_test_category_id);
                })
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

        $appreciation = new PTestCategoryAppreciation();
        $appreciation->title = $this->title;
        $appreciation->appreciation = $this->appreciation;
        $appreciation->start_points = $this->start_points;
        $appreciation->end_points = $this->end_points;
        $appreciation->p_test_category_id = $this->p_test_category_id;
        $appreciation->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Apreciación de categoría creada correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->appreciationId = $id;
        $appreciation = PTestCategoryAppreciation::findOrFail($id);

        $this->title = $appreciation->title;
        $this->appreciation = $appreciation->appreciation;
        $this->start_points = $appreciation->start_points;
        $this->end_points = $appreciation->end_points;
        $this->p_test_category_id = $appreciation->p_test_category_id;
    }

    public function update()
    {
        $this->validate([
            'title' => [
                'required',
                Rule::unique('p_test_category_appreciations')
                    ->where(fn($query) => $query->where('p_test_category_id', $this->p_test_category_id))
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

        $appreciation = PTestCategoryAppreciation::findOrFail($this->appreciationId);
        $appreciation->title = $this->title;
        $appreciation->appreciation = $this->appreciation;
        $appreciation->start_points = $this->start_points;
        $appreciation->end_points = $this->end_points;
        $appreciation->p_test_category_id = $this->p_test_category_id;
        $appreciation->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Apreciación de categoría actualizada correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->appreciationId = $id;
    }

    public function destroy()
    {
        $appreciation = PTestCategoryAppreciation::findOrFail($this->appreciationId);
        $appreciation->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Apreciación de categoría eliminada correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->title = '';
        $this->appreciation = '';
        $this->start_points = '';
        $this->end_points = '';
        $this->appreciationId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
