<?php

namespace App\Http\Livewire\Admin\ProcessTests\ProcessTestsCategories\ProcessTestsSubcategories;

use App\Models\ProcessTestCategory;
use App\Models\ProcessTestSubcategory;
use Livewire\Component;
use Illuminate\Validation\Rule;

class ProcessTestsSubcategoriesComponent extends Component
{
    public $p_test_category_id;
    public $category;
    public $name, $description;
    public $subcategoryId;

    public function mount($id)
    {
        // Recibimos el id de la categoría
        $this->p_test_category_id = $id;
        $this->category = ProcessTestCategory::findOrFail($this->p_test_category_id);
    }

    public function render()
    {
        $subcategories = ProcessTestSubcategory::where('p_test_category_id', $this->p_test_category_id)
            ->paginate(6);

        $firstItem = $subcategories->firstItem();
        $lastItem = $subcategories->lastItem();

        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$subcategories->total()} registros";

        return view('livewire..admin.process-tests.process-tests-categories.process-tests-subcategories.process-tests-subcategories-component', [
            'subcategories' => $subcategories,
            'category' => $this->category,
            'paginationText' => $paginationText,
        ]);
    }

    public function show($id)
    {
        $this->subcategoryId = $id;

        $subcategory = ProcessTestSubcategory::findOrFail($id);
        $this->name = $subcategory->name;
        $this->description = $subcategory->description;
    }

    public function store()
    {
        $this->validate([
            'name' => [
                'required',
                Rule::unique('process_test_subcategories')->where(function ($query) {
                    return $query->where('p_test_category_id', $this->p_test_category_id);
                })
            ],
            'description' => 'required',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
        ]);

        $subcategory = new ProcessTestSubcategory();
        $subcategory->name = $this->name;
        $subcategory->description = $this->description;
        $subcategory->p_test_category_id = $this->p_test_category_id;
        $subcategory->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Subcategoría creada correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->subcategoryId = $id;
        $subcategory = ProcessTestSubcategory::findOrFail($id);

        $this->name = $subcategory->name;
        $this->description = $subcategory->description;
        $this->p_test_category_id = $subcategory->p_test_category_id;
    }

    public function update()
    {
        $this->validate([
            'name' => [
                'required',
                Rule::unique('process_test_subcategories')
                    ->where(fn($query) => $query->where('p_test_category_id', $this->p_test_category_id))
                    ->ignore($this->subcategoryId),
            ],
            'description' => 'required',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
        ]);

        $subcategory = ProcessTestSubcategory::findOrFail($this->subcategoryId);
        $subcategory->name = $this->name;
        $subcategory->description = $this->description;
        $subcategory->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Subcategoría actualizada correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->subcategoryId = $id;
    }

    public function destroy()
    {
        $subcategory = ProcessTestSubcategory::findOrFail($this->subcategoryId);
        $subcategory->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Subcategoría eliminada correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->subcategoryId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
