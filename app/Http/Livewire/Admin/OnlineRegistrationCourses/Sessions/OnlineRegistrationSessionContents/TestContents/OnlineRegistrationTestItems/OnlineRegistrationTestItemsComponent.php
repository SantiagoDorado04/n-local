<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\TestContents\OnlineRegistrationTestItems;

use App\Models\OnlineRegistrationTestContent;
use App\Models\OnlineRegistrationTestItem;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class OnlineRegistrationTestItemsComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $test_id, $test;

    public $text, $position, $item_id;

    public $user_created_at, $user_updated_at;

    public $searchName;

    public function mount($id)
    {
        $this->test_id = $id;
        $this->test = OnlineRegistrationTestContent::find($id);
    }

    public function render()
    {

        $items = OnlineRegistrationTestItem::when($this->searchName, function ($query, $searchName) {
            return $query->where('text', 'like', '%' . $searchName . '%');
        })
            ->where('or_test_id', '=', $this->test_id)
            ->orderBy('position')
            ->paginate(20);

        $firstItem = $items->firstItem();
        $lastItem = $items->lastItem();

        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$items->total()} registros";

        return view('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.test-contents.online-registration-test-items.online-registration-test-items-component', [
            'items' => $items,
            'paginationText' => $paginationText,
            'test' => $this->test
        ]);
    }

    public function show($id)
    {
        $this->item_id = $id;

        $item = OnlineRegistrationTestItem::find($id);

        $this->text = $item->text;
        $this->position = $item->position;
        $userCreate = User::find($item->user_created_at);
        $this->user_created_at = $userCreate ? $userCreate->name : 'Sin creador';
        $userUpdate = User::find($item->user_updated_at);
        $this->user_updated_at = $userUpdate ? $userUpdate->name : 'Sin modificación';
    }

    public function store()
    {
        $this->validate([
            'text' => [
                'required',
                function ($attribute, $value, $fail) {
                    $existingItem = OnlineRegistrationTestItem::where('text', $value)
                        ->where('or_test_id', $this->test_id)
                        ->where('id', '!=', $this->item_id) //
                        ->first();
                    if ($existingItem) {
                        $fail('Ese item ya existe en este test.');
                    }
                },
            ],
            'position' => 'sometimes|nullable|integer',
        ], [], [
            'text' => 'texto',
            'position' => 'posición',
        ]);

        if ($this->position == '') {
            $maxPosition = OnlineRegistrationTestItem::where('or_test_id', $this->test_id)->max('position');
            $this->position = is_null($maxPosition) ? 1 : $maxPosition + 1;
        }

        $item = new OnlineRegistrationTestItem();
        $item->text = $this->text;
        $item->position = $this->position;
        $item->or_test_id = $this->test_id;
        $item->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Item creado correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->item_id = $id;

        $item = OnlineRegistrationTestItem::find($id);
        $this->text = $item->text;
        $this->position = $item->position;
    }

    public function update()
    {

        $this->validate([
            'text' => [
                'required',
                function ($attribute, $value, $fail) {
                    $existingItem = OnlineRegistrationTestItem::where('text', $value)
                        ->where('or_test_id', $this->test_id)
                        ->where('id', '!=', $this->item_id) //
                        ->first();
                    if ($existingItem) {
                        $fail('Ese item ya existe en este test.');
                    }
                },
            ],
            'position' => 'required',
        ], [], [
            'text' => 'texto',
            'position' => 'posicion',
        ]);

        $item = OnlineRegistrationTestItem::find($this->item_id);
        $item->text = $this->text;
        $item->position = $this->position;
        $item->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Item actualizado correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->item_id = $id;
    }

    public function destroy()
    {
        $item = OnlineRegistrationTestItem::find($this->item_id);

        $item->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Item eliminado correctamente']);
        $this->cancel();
    }

    public function updateItemOrder($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            $item = OnlineRegistrationTestItem::find($id);
            $item->position = $index + 1;
            $item->save();
        }
    }

    public function resetInputFields()
    {
        $this->text = '';
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
