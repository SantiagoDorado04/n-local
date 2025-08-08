<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\TestContents\OnlineRegistrationTestChoices;

use App\Models\OnlineRegistrationTestChoice;
use App\Models\OnlineRegistrationTestItem;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class OnlineRegistrationTestChoicesComponent extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $text,
        $value,
        $position,
        $choice_id,
        $or_item_id,
        $is_correct = false;

    public $searchName;

    public $user_created_at, $user_updated_at;

    public $item;

    public $existingCorrectChoice;

    public function mount($id)
    {
        $this->or_item_id = $id;
        $this->item = OnlineRegistrationTestItem::find($this->or_item_id);
        $this->existingCorrectChoice = OnlineRegistrationTestChoice::where('or_item_id', $this->or_item_id)
            ->where('is_correct', true)
            ->first();
    }

    public function render()
    {

        $choices = OnlineRegistrationTestChoice::when($this->searchName, function ($query, $searchName) {
            return $query->where('text', 'like', '%' . $searchName . '%');
        })
            ->where('or_item_id', '=', $this->or_item_id)
            ->paginate(6);

        $firstItem = $choices->firstItem();
        $lastItem = $choices->lastItem();
        $item = OnlineRegistrationTestItem::find($this->or_item_id);

        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$choices->total()} registros";

        return view('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.test-contents.online-registration-test-choices.online-registration-test-choices-component', [
            'choices' => $choices,
            'paginationText' => $paginationText,
            'item' => $item,
        ]);
    }

    public function show($id)
    {
        $this->choice_id = $id;

        $choice = OnlineRegistrationTestChoice::find($id);
        $this->text = $choice->text;
        $this->value = $choice->value;
        $this->position = $choice->position;
        $this->is_correct = $choice->is_correct;
        $userCreate = User::find($choice->user_created_at);
        $this->user_created_at = $userCreate ? $userCreate->name : 'Sin creador';
        $userUpdate = User::find($choice->user_updated_at);
        $this->user_updated_at = $userUpdate ? $userUpdate->name : 'Sin modificación';
    }

    public function store()
    {
        $this->validate([
            'text' => [
                'required',
                function ($attribute, $value, $fail) {
                    $exists = OnlineRegistrationTestChoice::where('or_item_id', $this->or_item_id)
                        ->where('text', $value)
                        ->exists();
                    if ($exists) {
                        $fail('La elección ya existe en este ítem.');
                    }
                }
            ],
            'value' => 'required',
            'position' => 'sometimes|nullable|integer',
            'is_correct' => 'nullable|boolean',
        ], [], [
            'text' => 'texto',
            'value' => 'valor',
            'position' => 'posición',
            'is_correct' => 'respuesta correcta',
        ]);

        if ($this->position == '') {
            $maxPosition = OnlineRegistrationTestChoice::where('or_item_id', $this->or_item_id)->max('position');
            $this->position = is_null($maxPosition) ? 1 : $maxPosition + 1;
        }

       // Cambiar la respuesta correcta anterior si ya existía
       if ($this->existingCorrectChoice && $this->is_correct) {
        $this->existingCorrectChoice->update(['is_correct' => false]);
        }

        $choice = new OnlineRegistrationTestChoice();
        $choice->text = $this->text;
        $choice->value = $this->value;
        $choice->position = $this->position;
        $choice->or_item_id = $this->or_item_id;
        $choice->is_correct = $this->is_correct;
        $choice->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Elección creada correctamente']);
        $this->cancel();
    }


    public function edit($id)
    {
        $this->choice_id = $id;

        $choice = OnlineRegistrationTestChoice::find($id);
        $this->text = $choice->text;
        $this->value = $choice->value;
        $this->position = $choice->position;
        $this->is_correct = $choice->is_correct;
    }

    public function update()
    {
        $this->validate([
            'text' => [
                'required',
                function ($attribute, $value, $fail) {
                    $exists = OnlineRegistrationTestChoice::where('or_item_id', $this->or_item_id)
                        ->where('text', $value)
                        ->where('id', '!=', $this->choice_id)
                        ->exists();
                    if ($exists) {
                        $fail('La eleccion ya existe en este item.');
                    }
                }
            ],
            'value' => 'required',
            'position' => 'sometimes|nullable|integer',
            'is_correct' => 'nullable|boolean',
        ], [], [
            'text' => 'texto',
            'value' => 'valor',
            'position' => 'posicion',
            'is_correct' => 'respuesta correcta',
        ]);

        // Cambiar la respuesta correcta anterior si ya existía
       if ($this->existingCorrectChoice && $this->is_correct) {
        $this->existingCorrectChoice->update(['is_correct' => false]);
        }

        $choice = OnlineRegistrationTestChoice::find($this->choice_id);
        $choice->text = $this->text;
        $choice->value = $this->value;
        $choice->position = $this->position;
        $choice->is_correct = $this->is_correct;
        $choice->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Eleccion actualizada correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->choice_id = $id;
    }

    public function destroy()
    {
        $choice = OnlineRegistrationTestChoice::find($this->choice_id);
        $choice->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Eleccion eliminada correctamente']);
        $this->cancel();
    }

    public function updateChoiceOrder($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            $choices = OnlineRegistrationTestChoice::find($id);
            $choices->position = $index + 1;
            $choices->save();

            $this->emit('alert', ['type' => 'success', 'message' => 'Orden actualizado correctamente']);
        }
    }

    public function resetInputFields()
    {
        $this->text = '';
        $this->value = '';
        $this->position = '';
        $this->choice_id = '';
        $this->is_correct = false;
        $this->existingCorrectChoice = OnlineRegistrationTestChoice::where('or_item_id', $this->or_item_id)
            ->where('is_correct', true)
            ->first();
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }

    public function updatedIsCorrect($value)
    {
        if ($value && $this->existingCorrectChoice) {
            $this->dispatchBrowserEvent('confirm-swap');
        }
    }

    public function swapCorrectChoice()
    {
        if ($this->existingCorrectChoice) {
            $this->existingCorrectChoice->update(['is_correct' => false]);
        }
        $this->is_correct = true;
    }
}
