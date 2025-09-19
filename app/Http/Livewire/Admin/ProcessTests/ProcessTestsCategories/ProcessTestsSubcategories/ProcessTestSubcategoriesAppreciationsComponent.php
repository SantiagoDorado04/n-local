<?php

namespace App\Http\Livewire\Admin\ProcessTests\ProcessTestsCategories\ProcessTestsSubcategories;

use App\Models\ProcessTestSubcategory;
use App\Models\PTestSubcategoryAppreciation;
use Livewire\Component;
use Livewire\WithPagination;

class ProcessTestSubcategoriesAppreciationsComponent extends Component
{

    use WithPagination;

    public $subcategory;
    public $title, $appreciation, $start_points, $end_points;
    public $subcategoryAppreciationId;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'title' => 'required|string|max:255',
        'appreciation' => 'required|string',
        'start_points' => 'required|integer',
        'end_points' => 'required|integer',
    ];

    public function mount($id)
    {
        $this->subcategory = ProcessTestSubcategory::findOrFail($id);
    }

    public function render()
    {

        $appreciations = PTestSubcategoryAppreciation::where('p_test_subcategory_id', $this->subcategory->id)
            ->orderBy('start_points', 'asc')
            ->paginate(9);

        $paginationText = "Mostrando " . $appreciations->firstItem() . " a " . $appreciations->lastItem() . " de " . $appreciations->total() . " resultados";


        return view('livewire..admin.process-tests.process-tests-categories.process-tests-subcategories.process-test-subcategories-appreciations-component', [
            'appreciations' => $appreciations,
            'paginationText' => $paginationText,
            'subcategory' => $this->subcategory
        ]);
    }

    public function resetInputFields()
    {
        $this->title = '';
        $this->appreciation = '';
        $this->start_points = '';
        $this->end_points = '';
        $this->subcategoryAppreciationId = null;
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }

    public function store()
    {
        $this->validate();

        PTestSubcategoryAppreciation::create([
            'title' => $this->title,
            'appreciation' => $this->appreciation,
            'start_points' => $this->start_points,
            'end_points' => $this->end_points,
            'p_test_subcategory_id' => $this->subcategory->id,
        ]);
        $this->cancel();
    }

    public function edit($id)
    {
        $record = PTestSubcategoryAppreciation::findOrFail($id);

        $this->subcategoryAppreciationId = $id;
        $this->title = $record->title;
        $this->appreciation = $record->appreciation;
        $this->start_points = $record->start_points;
        $this->end_points = $record->end_points;
    }

    public function update()
    {
        $this->validate();

        if ($this->subcategoryAppreciationId) {
            $record = PTestSubcategoryAppreciation::find($this->subcategoryAppreciationId);
            $record->update([
                'title' => $this->title,
                'appreciation' => $this->appreciation,
                'start_points' => $this->start_points,
                'end_points' => $this->end_points,
            ]);
        }

        $this->cancel();
    }

    public function delete($id)
    {
        $this->subcategoryAppreciationId = $id;
    }

    public function destroy()
    {
        if ($this->subcategoryAppreciationId) {
            PTestSubcategoryAppreciation::destroy($this->subcategoryAppreciationId);
        }

        $this->cancel();
    }

    public function show($id)
    {
        $record = PTestSubcategoryAppreciation::findOrFail($id);

        $this->title = $record->title;
        $this->appreciation = $record->appreciation;
        $this->start_points = $record->start_points;
        $this->end_points = $record->end_points;
    }
}
