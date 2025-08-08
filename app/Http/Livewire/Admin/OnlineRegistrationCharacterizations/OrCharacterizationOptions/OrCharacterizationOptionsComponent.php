<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCharacterizations\OrCharacterizationOptions;

use App\Models\OnlineRegistrationCharacterization;
use App\Models\OnlineRegistrationCourseSession;
use App\Models\OrCharacterizationOption;
use App\Models\OrCharacterizationQuestion;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class OrCharacterizationOptionsComponent extends Component
{


    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $text,
        $value,
        $position,
        $optionId,
        $questionId,
        $characterization_id,
        $conditional = false;

    public $selected_characterization;

    public $searchName;

    public $user_created_at, $user_updated_at;

    public $question;

    public $characterizations;


    public function mount($id)
    {
        $this->questionId = $id;
        $this->question = OrCharacterizationQuestion::find($this->questionId);

        if ($this->question && $this->question->characterization) {
            $session = $this->question->characterization->session;

            if ($session && $session->onlineRegistrationCourse) {
                $courseId = $session->or_course_id;

                // Obtener todas las sesiones de ese curso
                $sessionIds = OnlineRegistrationCourseSession::where('or_course_id', $courseId)->pluck('id');

                // Obtener todas las caracterizaciones de esas sesiones con type 'S'
                $this->characterizations = OnlineRegistrationCharacterization::whereIn('session_id', $sessionIds)
                    ->where('type', 'S')
                    ->get();
            }
        }
    }


    public function render()
    {

        $options = OrCharacterizationOption::when($this->searchName, function ($query, $searchName) {
            return $query->where('text', 'like', '%' . $searchName . '%');
        })
            ->where('question_id', '=', $this->questionId)
            ->paginate(6);

        $firstItem = $options->firstItem();
        $lastItem = $options->lastItem();
        $question = OrCharacterizationQuestion::find($this->questionId);

        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$options->total()} registros";

        return view('livewire.admin.online-registration-characterizations.or-characterization-options.or-characterization-options-component', [
            'options' => $options,
            'paginationText' => $paginationText,
            'question' => $question
        ]);
    }

    public function show($id)
    {
        $this->optionId = $id;

        $option = OrCharacterizationOption::find($id);
        $this->text = $option->text;
        $this->value = $option->value;
        $this->position = $option->position;
        $this->conditional = $option->conditional;
        if ($option->characterization_id) {
            $characterization = OnlineRegistrationCharacterization::find($option->characterization_id);
            $this->characterization_id = $characterization->name;
        }
        $userCreate = User::find($option->user_created_at);
        $this->user_created_at = $userCreate ? $userCreate->name : 'Sin creador';
        $userUpdate = User::find($option->user_updated_at);
        $this->user_updated_at = $userUpdate ? $userUpdate->name : 'Sin modificación';
    }

    public function store()
    {
        $this->validate([
            'text' => [
                'required',
                function ($attribute, $value, $fail) {
                    $exists = OrCharacterizationOption::where('question_id', $this->questionId)
                        ->where('text', $value)
                        ->exists();
                    if ($exists) {
                        $fail('La opción ya existe en esta pregunta.');
                    }
                }
            ],
            'value' => 'required',
            'position' => 'sometimes|nullable|integer',
            'conditional' => 'required',
        ], [], [
            'text' => 'texto',
            'value' => 'valor',
            'position' => 'posicion',
            'conditional' => 'condicional',
        ]);

        if ($this->position == '') {
            $maxPosition = OrCharacterizationOption::where('question_id', $this->questionId)->max('position');
            $this->position = is_null($maxPosition) ? 1 : $maxPosition + 1;
        }

        $option = new OrCharacterizationOption();
        $option->text = $this->text;
        $option->value = $this->value;
        $option->position = $this->position;
        $option->question_id = $this->questionId;
        $option->conditional = $this->conditional;
        if ($this->selected_characterization && $this->conditional == true) {
            $option->characterization_id = $this->selected_characterization;
        } elseif ($this->conditional == false) {
            $option->characterization_id = null;
        }
        $option->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Opcion creada correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->optionId = $id;

        $option = OrCharacterizationOption::find($id);
        $this->text = $option->text;
        $this->value = $option->value;
        $this->position = $option->position;
        $this->conditional = $option->conditional;
        if ($option->characterization_id) {
            $this->selected_characterization = $option->characterization_id;
        }
    }

    public function update()
    {
        $this->validate([
            'text' => [
                'required',
                function ($attribute, $value, $fail) {
                    $exists = OrCharacterizationOption::where('question_id', $this->questionId)
                        ->where('text', $value)
                        ->where('id', '!=', $this->optionId)
                        ->exists();
                    if ($exists) {
                        $fail('El texto de la opción ya existe en esta pregunta.');
                    }
                }
            ],
            'value' => 'required',
            'position' => 'sometimes|nullable|integer',
            'conditional' => 'required',
        ], [], [
            'text' => 'texto',
            'value' => 'valor',
            'position' => 'posicion',
            'position' => 'posicion',
            'conditional' => 'condicional',
        ]);

        $option = OrCharacterizationOption::find($this->optionId);
        $option->text = $this->text;
        $option->value = $this->value;
        $option->position = $this->position;
        $option->conditional = $this->conditional;
        if ($this->selected_characterization && $this->conditional == true) {
            $option->characterization_id = $this->selected_characterization;
        } elseif ($this->conditional == false) {
            $option->characterization_id = null;
        }
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
        $option = OrCharacterizationOption::find($this->optionId);
        $option->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Opcion eliminada correctamente']);
        $this->cancel();
    }

    public function updateOptionOrder($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            $options = OrCharacterizationOption::find($id);
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
        $this->conditional = false;
        $this->selected_characterization = '';
        $this->characterization_id = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
