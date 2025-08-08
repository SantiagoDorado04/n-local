<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCharacterizations\OrCharacterizationQuestions;

use App\Models\OnlineRegistrationCharacterization;
use App\Models\OrCharacterizationQuestion;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class OrCharacterizationQuestionsComponent extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $questionId,
        $text,
        $type,
        $position;

    public $user_created_at, $user_updated_at;

    public $searchName;

    public $formId;

    public function mount($id)
    {
        $this->formId = $id;
    }

    public function render()
    {
        $questions = OrCharacterizationQuestion::when($this->searchName, function ($query, $searchName) {
            return $query->where('text', 'like', '%' . $searchName . '%');
        })
            ->where('characterization_id', '=', $this->formId)
            ->orderBy('position')
            ->paginate(20);

        $firstItem = $questions->firstItem();
        $lastItem = $questions->lastItem();
        $form = OnlineRegistrationCharacterization::find($this->formId);

        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$questions->total()} registros";

        return view('livewire.admin.online-registration-characterizations.or-characterization-questions.or-characterization-questions-component', [

            'questions' => $questions,
            'paginationText' => $paginationText,
            'form' => $form

        ]);
    }

    public function show($id)
    {
        $this->questionId = $id;

        $question = OrCharacterizationQuestion::find($id);

        $this->text = $question->text;
        $this->type = $question->type;
        $this->position = $question->position;
        $userCreate = User::find($question->user_created_at);
        $this->user_created_at = $userCreate ? $userCreate->name : 'Sin creador';
        $userUpdate = User::find($question->user_updated_at);
        $this->user_updated_at = $userUpdate ? $userUpdate->name : 'Sin modificación';
    }

    public function store()
    {
        $this->validate([
            'text' => [
                'required',
                function ($attribute, $value, $fail) {
                    $existingQuestion = OrCharacterizationQuestion::where('text', $value)
                        ->where('characterization_id', $this->formId)
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
            $maxPosition = OrCharacterizationQuestion::where('characterization_id', $this->formId)->max('position');
            $this->position = is_null($maxPosition) ? 1 : $maxPosition + 1;
        }

        $question = new OrCharacterizationQuestion();
        $question->text = $this->text;
        $question->type = $this->type;
        $question->position = $this->position;
        $question->characterization_id = $this->formId;
        $question->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Pregunta creada correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->questionId = $id;

        $question = OrCharacterizationQuestion::find($id);
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
                    $existingQuestion = OrCharacterizationQuestion::where('text', $value)
                        ->where('characterization_id', $this->formId)
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

        $question = OrCharacterizationQuestion::find($this->questionId);
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
        $question = OrCharacterizationQuestion::find($this->questionId);

        $question->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Pregunta eliminada correctamente']);
        $this->cancel();
    }

    public function updateQuestionOrder($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            $question = OrCharacterizationQuestion::find($id);
            $question->position = $index + 1;
            $question->save();
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
}
