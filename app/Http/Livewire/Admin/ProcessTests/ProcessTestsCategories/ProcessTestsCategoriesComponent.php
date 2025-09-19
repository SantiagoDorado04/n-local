<?php

namespace App\Http\Livewire\Admin\ProcessTests\ProcessTestsCategories;

use App\Models\ProcessTest;
use App\Models\ProcessTestCategory;
use App\Models\Step;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ProcessTestsCategoriesComponent extends Component
{
    public $process_test_id;
    public $processTest;
    public $step_id;
    public $name, $description;
    public $categoryId;

    public function mount($id)
    {
        $this->step_id = $id;
        $this->processTest = ProcessTest::where('step_id', $this->step_id)->first();
        $this->process_test_id = $this->processTest->id;
    }
    public function render()
    {
        $categories = ProcessTestCategory::where('process_test_id', '=', $this->process_test_id)
            ->paginate(6);

        $firstItem = $categories->firstItem();
        $lastItem = $categories->lastItem();

        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$categories->total()} registros";

        $step = Step::find($this->step_id);

        return view('livewire..admin.process-tests.process-tests-categories.process-tests-categories-component', [
            'categories' => $categories,
            'processTest' => $this->processTest,
            'paginationText' => $paginationText,
            'step' => $step,
        ]);
    }

    public function show($id)
    {
        $this->categoryId = $id;

        $category = ProcessTestCategory::find($id);
        $this->name = $category->name;
        $this->description = $category->description;
    }

    public function store()
    {
        $this->validate([
            'name' => [
                'required',
                Rule::unique('process_test_categories')->where(function ($query) {
                    return $query->where('process_test_id', $this->process_test_id);
                })
            ],
            'description' => 'required',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripcion',
        ]);

        $category = new ProcessTestCategory();
        $category->name = $this->name;
        $category->description = $this->description;
        $category->process_test_id = $this->process_test_id;
        $category->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Categoria de evaluacion creada correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->categoryId = $id;
        $category = ProcessTestCategory::findOrFail($id);

        $this->name = $category->name;
        $this->description = $category->description;
        $this->process_test_id = $category->process_test_id;
    }


    public function update()
    {
        $this->validate([
            'name' => [
                'required',
                Rule::unique('process_test_categories')
                    ->where(fn($query) => $query->where('process_test_id', $this->process_test_id))
                    ->ignore($this->categoryId),
            ],
            'description' => 'required',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripcion',
        ]);

        $category = ProcessTestCategory::findOrFail($this->categoryId);
        $category->name = $this->name;
        $category->description = $this->description;
        $category->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Apreciación actualizada correctamente']);
        $this->cancel();
    }


    public function delete($id)
    {
        $this->categoryId = $id;
    }

    public function destroy()
    {
        $category = ProcessTestCategory::findOrFail($this->categoryId);

        $category->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Categoria eliminada correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->categoryId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
