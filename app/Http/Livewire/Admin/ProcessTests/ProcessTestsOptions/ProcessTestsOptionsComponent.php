<?php

namespace App\Http\Livewire\Admin\ProcessTests\ProcessTestsOptions;

use App\Models\ProcessTestOption;
use App\Models\ProcessTestQuestion;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class ProcessTestsOptionsComponent extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $text,
        $value,
        $position,
        $points = 0,
        $optionId,
        $questionId,
        $question;

    public $searchName;

    public function mount($id)
    {
        $this->questionId = $id;
        $this->question = ProcessTestQuestion::find($this->questionId);
    }

    public function render()
    {

        $options = ProcessTestOption::when($this->searchName, function ($query, $searchName) {
            return $query->where('text', 'like', '%' . $searchName . '%');
        })
            ->where('p_test_question_id', '=', $this->questionId)
            ->paginate(6);

        $firstItem = $options->firstItem();
        $lastItem = $options->lastItem();

        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$options->total()} registros";
        return view('livewire..admin.process-tests.process-tests-options.process-tests-options-component', [
            'options' => $options,
            'paginationText' => $paginationText,
            'question' => $this->question
        ]);
    }

    public function show($id)
    {
        $this->optionId = $id;

        $option = ProcessTestOption::find($id);
        $this->text = $option->text;
        $this->value = $option->value;
        $this->position = $option->position;
        $this->points = $option->points;
        $this->questionId = $option->p_test_question_id;
    }

    public function store()
    {
        $this->validate([
            'text' => 'required',
            'value' => 'required',
            'position' => 'sometimes|nullable|integer',
            'points' => 'required|integer',
        ], [], [
            'text' => 'texto',
            'value' => 'valor',
            'position' => 'posicion',
            'points' => 'puntos',
        ]);
        $textExist = ProcessTestOption::where('text', $this->text)
            ->where('p_test_question_id', $this->questionId)
            ->exists();
        if ($textExist) {
            $this->emit('alert', ['type' => 'error', 'message' => 'Ya existe una opción con ese texto']);
            return;
        }

        if ($this->position == '') {
            $maxPosition = ProcessTestOption::where('p_test_question_id', $this->questionId)->max('position');
            $this->position = is_null($maxPosition) ? 1 : $maxPosition + 1;
        }

        $option = new ProcessTestOption();
        $option->text = $this->text;
        $option->value = $this->value;
        $option->position = $this->position;
        $option->points = $this->points;
        $option->p_test_question_id = $this->questionId;
        $option->process_test_id = $this->question->process_test_id;
        $option->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Opcion creada correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->optionId = $id;

        $option = ProcessTestOption::find($id);
        $this->text = $option->text;
        $this->value = $option->value;
        $this->position = $option->position;
        $this->points = $option->points;
    }

    public function update()
    {
        $this->validate([
            'text' => [
                'required',
                Rule::unique('process_test_options', 'text')
                    ->where(function ($query) {
                        return $query->where('p_test_question_id', $this->questionId);
                    })
                    ->ignore($this->optionId),
            ],
            'value' => 'required',
            'position' => 'required|integer',
            'points' => 'required|integer',
        ], [], [
            'text' => 'texto',
            'value' => 'valor',
            'position' => 'posicion',
            'points' => 'puntos',
        ]);

        $option = ProcessTestOption::find($this->optionId);
        $option->text = $this->text;
        $option->value = $this->value;
        $option->position = $this->position;
        $option->points = $this->points;
        $option->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Opcion actualizada correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->optionId = $id;
    }

    public function destroy()
    {
        $option = ProcessTestOption::find($this->optionId);
        $option->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Opcion eliminada correctamente']);
        $this->cancel();
    }

    public function updateOptionOrder($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            $options = ProcessTestOption::find($id);
            $options->position = $index + 1;
            $options->save();

            $this->emit('alert', ['type' => 'success', 'message' => 'Orden actualizado correctamente']);
        }
    }

    public function resetInputFields()
    {
        $this->text = '';
        $this->value = '';
        $this->position = '';
        $this->points = 0;
        $this->optionId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
