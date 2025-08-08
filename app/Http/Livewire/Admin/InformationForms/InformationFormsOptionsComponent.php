<?php

namespace App\Http\Livewire\Admin\InformationForms;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\InformationFormOption;
use App\Models\InformationFormQuestion;

class InformationFormsOptionsComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $text,
        $value,
        $position,
        $optionId,
        $questionId;

    public $searchName;

    public function mount($id)
    {
        $this->questionId = $id;
    }

    public function render()
    {
        $options = InformationFormOption::when($this->searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })
            ->where('information_form_question_id', '=', $this->questionId)
            ->paginate(6);

        $firstItem = $options->firstItem();
        $lastItem = $options->lastItem();
        $question = InformationFormQuestion::find($this->questionId);

        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$options->total()} registros";

        return view('livewire.admin.information-forms.information-forms-options-component', [
            'options' => $options,
            'paginationText' => $paginationText,
            'question' => $question
        ]);
    }

    public function show($id)
    {
        $this->optionId = $id;

        $option = InformationFormOption::find($id);
        $this->text = $option->text;
        $this->value = $option->value;
        $this->position = $option->position;
        $this->questionId = $option->information_form_question_id;
    }

    public function store()
    {
        $this->validate([
            'text' => 'required',
            'value' => 'required',
            'position' => 'sometimes|nullable|integer',
        ], [], [
            'text' => 'texto',
            'value' => 'valor',
            'position' => 'posicion',
        ]);
        $textExist = InformationFormOption::where('text', $this->text)
            ->where('information_form_question_id', $this->questionId)
            ->exists();
        if ($textExist) {
            $this->emit('alert', ['type' => 'error', 'message' => 'Ya existe una opción con ese texto']);
            return;
        }

        if ($this->position == '') {
            $maxPosition = InformationFormOption::where('information_form_question_id', $this->questionId)->max('position');
            $this->position = is_null($maxPosition) ? 1 : $maxPosition + 1;
        }

        $option = new InformationFormOption();
        $option->text = $this->text;
        $option->value = $this->value;
        $option->position = $this->position;
        $option->information_form_question_id = $this->questionId;
        $option->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Opcion creada correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->optionId = $id;

        $option = InformationFormOption::find($id);
        $this->text = $option->text;
        $this->value = $option->value;
        $this->position = $option->position;
    }

    public function update()
    {

        $this->validate([
            'text' => 'required|unique:information_form_options,text,' . $this->optionId,
            'value' => 'required',
            'position' => 'required|integer',
        ], [], [
            'text' => 'texto',
            'value' => 'valor',
            'position' => 'posicion',
        ]);

        $option = InformationFormOption::find($this->optionId);
        $option->text = $this->text;
        $option->value = $this->value;
        $option->position = $this->position;
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
        $option = InformationFormOption::find($this->optionId);
        $option->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Opcion eliminada correctamente']);
        $this->cancel();
    }

    public function updateOptionOrder($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            $options = InformationFormOption::find($id);
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
