<?php

namespace App\Http\Livewire\Admin\ProcessTests;

use App\Models\ProcessTest;
use App\Models\ProcessTestCategory;
use App\Models\ProcessTestQuestion;
use App\Models\ProcessTestSubcategory;
use App\Models\Step;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class ProcessTestsComponent extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $process_test_id;
    public $processTest;
    public $step_id;
    public $text, $position, $p_test_subcategory_id; //variables de la creacion de las preguntas
    public $questionId;

    public $processTestCategories = [];
    public $processTestSubcategories = [];
    public $categoryM;
    public $subcategoryM;

    public function mount($id)
    {
        $this->step_id = $id;
        $this->processTest = ProcessTest::where('step_id', $this->step_id)->first();
        $this->process_test_id = $this->processTest->id;
        $this->processTestCategories = ProcessTestCategory::where('process_test_id', '=', $this->process_test_id)->get();
    }

    public function render()
    {

        $questions = ProcessTestQuestion::where('process_test_id', '=', $this->process_test_id)
            ->paginate(20);

        $firstItem = $questions->firstItem();
        $lastItem = $questions->lastItem();

        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$questions->total()} registros";

        $step = Step::find($this->step_id);

        return view('livewire..admin.process-tests.process-tests-component', [
            'questions' => $questions,
            'processTest' => $this->processTest,
            'paginationText' => $paginationText,
            'step' => $step,
        ]);
    }

    public function store()
    {
        $this->validate([
            'text' => [
                'required',
                Rule::unique('process_test_questions', 'text')->where(function ($query) {
                    return $query->where('process_test_id', '=', $this->process_test_id);
                }),
            ],
            'position' => 'sometimes|nullable|integer',
            'p_test_subcategory_id' => 'required|integer',
        ], [], [
            'text' => 'texto',
            'position' => 'posición',
            'p_test_subcategory_id' => 'subcategoría',
        ]);

        if ($this->position == '') {
            $maxPosition = ProcessTestQuestion::where('process_test_id', $this->process_test_id)->max('position');
            $this->position = is_null($maxPosition) ? 1 : $maxPosition + 1;
        }

        $question = new ProcessTestQuestion();
        $question->text = $this->text;
        $question->position = $this->position;
        $question->process_test_id = $this->process_test_id;
        $question->p_test_subcategory_id = $this->p_test_subcategory_id;
        $question->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Pregunta creada correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->questionId = $id;

        $question = ProcessTestQuestion::find($id);
        $this->text = $question->text;
        $this->position = $question->position;
        $this->categoryM = $question->subcategory->category->id;
        $this->p_test_subcategory_id = $question->p_test_subcategory_id;
    }

    public function update()
    {

        $this->validate([
            'text' => [
                'required',
                Rule::unique('process_test_questions', 'text')
                    ->where(fn($query) => $query->where('process_test_id', $this->process_test_id))
                    ->ignore($this->questionId),
            ],
            'p_test_subcategory_id' => 'required|integer',
        ], [], [
            'text' => 'texto',
            'p_test_subcategory_id' => 'subcategoría',
        ]);

        $question = ProcessTestQuestion::find($this->questionId);
        $question->text = $this->text;
        $question->p_test_subcategory_id = $this->p_test_subcategory_id;
        $question->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Pregunta actualizada correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->questionId = $id;
    }

    public function destroy()
    {
        $question = ProcessTestQuestion::find($this->questionId);
        $question->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Pregunta eliminada correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->text = '';
        $this->position = '';
        $this->p_test_subcategory_id = '';
        $this->categoryM = '';
        $this->subcategoryM = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }

    public function updatedCategoryM($categoryId)
    {

        if ($categoryId) {
            $this->processTestSubcategories = ProcessTestSubcategory::where('p_test_category_id', '=', $categoryId)->get();
        } else {
            $this->processTestSubcategories = [];
        }
    }
}
