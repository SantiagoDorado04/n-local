<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCategories;

use App\Models\OnlineRegistrationCategory;
use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class OnlineRegistrationCategoriesComponent extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $name,
        $description,
        $active = 1,
        $categoryId;

    public $online_registration_id, $online_registration;

    public $user_created_at, $user_updated_at;

    public $searchName;

    public function mount($id)
    {
        $this->online_registration_id = $id;
    }

    public function render()
    {

        $categories = OnlineRegistrationCategory::when($this->searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })
            ->where('online_registration_id', '=', $this->online_registration_id)
            ->paginate(6);

        $firstItem = $categories->firstItem();
        $lastItem = $categories->lastItem();

        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$categories->total()} registros";

        return view('livewire.admin.online-registration-categories.online-registration-categories-component', [
            'categories' => $categories,
            'paginationText' => $paginationText,
        ]);
    }

    public function show($id)
    {
        $this->categoryId = $id;

        $category = OnlineRegistrationCategory::find($id);
        $this->name = $category->name;
        $this->description = $category->description;
        $this->active = $category->active;
        $this->online_registration = $category->onlineRegistration->name;
        $userCreate = User::find($category->user_created_at);
        $this->user_created_at = $userCreate->name;
        $userUpdate = User::find($category->user_updated_at);
        $this->user_updated_at = $userUpdate ? $userUpdate->name : 'Sin modificación';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|unique:online_registrations_categories,name',
            'description' => 'required',
            'active' => 'required',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
            'active' => 'activo',
        ]);

        $category = new OnlineRegistrationCategory();
        $category->name = $this->name;
        $category->description = $this->description;
        $category->active = $this->active;
        $category->online_registration_id = $this->online_registration_id;
        $category->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Categoria de control de registros creada correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->categoryId = $id;

        $category = OnlineRegistrationCategory::find($id);
        $this->name = $category->name;
        $this->description = $category->description;
        $this->active = $category->active;
    }

    public function update()
    {

        $this->validate([
            'name' => 'required|unique:online_registrations_categories,name,' . $this->categoryId,
            'description' => 'required',
            'active' => 'required',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
            'active' => 'activo',
        ]);

        $category = OnlineRegistrationCategory::find($this->categoryId);
        $category->name = $this->name;
        $category->description = $this->description;
        $category->active = $this->active;
        $category->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Categoria de control de registros actualizada correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->categoryId = $id;
    }

    public function destroy()
    {
        $category = OnlineRegistrationCategory::find($this->categoryId);
        $this->name = $category->name;

        $category->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Categoria de control de registros eliminada correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->categoryId = '';
        $this->user_created_at = '';
        $this->user_updated_at = '';
        $this->online_registration = '';
    }

    public function cancel()
    {
        $this->resetInputFields();

        $this->resetErrorBag();
        $this->resetValidation();

        $this->emit('close-modal');
    }
}
