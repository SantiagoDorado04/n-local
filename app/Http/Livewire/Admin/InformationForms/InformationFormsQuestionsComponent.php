<?php

namespace App\Http\Livewire\Admin\InformationForms;

use App\Models\InformationForm;
use App\Models\InformationFormQuestion;
use Livewire\Component;
use Livewire\WithPagination;

class InformationFormsQuestionsComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $questionId,
        $text,
        $type,
        $position;

    public $searchName;

    public $formId;

    public function mount($id)
    {
        $this->formId = $id;
    }

    public function render()
    {
        $questions = InformationFormQuestion::when($this->searchName, function ($query, $searchName) {
            return $query->where('text', 'like', '%' . $searchName . '%');
        })
            ->where('information_form_id', '=', $this->formId)
            ->orderBy('position')
            ->paginate(20);

        $firstItem = $questions->firstItem();
        $lastItem = $questions->lastItem();
        $form = InformationForm::find($this->formId);

        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$questions->total()} registros";

        return view('livewire.admin.information-forms.information-forms-questions-component', [
            'questions' => $questions,
            'paginationText' => $paginationText,
            'form' => $form
        ]);
    }

    public function show($id)
    {
        $this->questionId = $id;

        $question = InformationFormQuestion::find($id);

        $this->text = $question->text;
        $this->type = $question->type;
        $this->position = $question->position;
        $this->formId = $question->information_form_id;
    }

    public function store()
    {
        $this->validate([
            'text' => [
                'required',
                function ($attribute, $value, $fail) {
                    $existingQuestion = InformationFormQuestion::where('text', $value)
                        ->where('information_form_id', $this->formId)
                        ->where('id', '!=', $this->questionId) //
                        ->first();
                    if ($existingQuestion) {
                        $fail('El nombre de la pregunta ya existe en este formulario.');
                    }
                },
            ],
            'type' => 'required',
            'position' => 'sometimes|nullable|integer',
        ], [], [
            'text' => 'texto',
            'type' => 'tipo',
            'position' => 'posición',
        ]);

        if ($this->position == '') {
            $maxPosition = InformationFormQuestion::where('information_form_id', $this->formId)->max('position');
            $this->position = is_null($maxPosition) ? 1 : $maxPosition + 1;
        }

        $question = new InformationFormQuestion();
        $question->text = $this->text;
        $question->type = $this->type;
        $question->position = $this->position;
        $question->information_form_id = $this->formId;
        $question->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Pregunta creada correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->questionId = $id;

        $question = InformationFormQuestion::find($id);
        $this->text = $question->text;
        $this->type = $question->type;
        $this->position = $question->position;
    }

    public function update()
    {

        $this->validate([
            'text' => [
                'required',
                function ($attribute, $value, $fail) {
                    $existingQuestion = InformationFormQuestion::where('text', $value)
                        ->where('information_form_id', $this->formId)
                        ->where('id', '!=', $this->questionId) //
                        ->first();
                    if ($existingQuestion) {
                        $fail('El nombre de la pregunta ya existe en este formulario.');
                    }
                },
            ],
            'type' => 'required',
            'position' => 'required',
        ], [], [
            'text' => 'texto',
            'type' => 'tipo',
            'position' => 'posicion',
        ]);

        $question = InformationFormQuestion::find($this->questionId);
        $question->text = $this->text;
        $question->type = $this->type;
        $question->position = $this->position;
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
        $question = InformationFormQuestion::find($this->questionId);

        if ($question && $question->answers()->count() === 0) {
            $question->delete();

            $this->emit('alert', ['type' => 'success', 'message' => 'Pregunta eliminada correctamente']);
            $this->cancel();
        } else {
            $this->emit('alert', ['type' => 'error', 'message' => 'No se puede eliminar la pregunta, porque ya tiene respuestas asociadas.']);
        }
    }



    public function resetInputFields()
    {
        $this->text = '';
        $this->type = '';
        $this->position = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
    public function updateQuestionOrder($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            $options = InformationFormQuestion::find($id);
            $options->position = $index + 1;
            $options->save();

            $this->emit('alert', ['type' => 'success', 'message' => 'Orden actualizado correctamente']);
        }
    }
}
