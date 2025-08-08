<?php

namespace App\Http\Livewire\Admin\OnlineRegistrations;

use Livewire\Component;
use App\Models\OnlineRegistration;
use App\Models\User;
use Livewire\WithPagination;


class OnlineRegistrationsComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $currentUser;

    public $name,
        $description,
        $onlineRegistrationId,
        $course_limit = 0,
        $active = 1;

    public $user_created_at, $user_updated_at, $user_deleted_at;

    public $searchName;

    public function render()
    {

        $onlineRegistrations = OnlineRegistration::when($this->searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })->paginate(6);

        $firstItem = $onlineRegistrations->firstItem();
        $lastItem = $onlineRegistrations->lastItem();

        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$onlineRegistrations->total()} registros";

        return view('livewire..admin.online-registrations.online-registrations-component', [
            'onlineRegistrations' => $onlineRegistrations,
            'paginationText' => $paginationText,

        ]);
    }

    public function show($id)
    {
        $this->onlineRegistrationId = $id;
        $onlineRegistration = OnlineRegistration::find($id);
        $this->name = $onlineRegistration->name;
        $this->description = $onlineRegistration->description;
        $this->course_limit = $onlineRegistration->course_limit;
        $this->active = $onlineRegistration->active;
        $userCreate = User::find($onlineRegistration->user_created_at);
        $this->user_created_at = $userCreate->name;
        $userUpdate = User::find($onlineRegistration->user_updated_at);
        $this->user_updated_at = $userUpdate ? $userUpdate->name : 'Sin modificación';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|unique:online_registrations,name',
            'description' => 'required',
            'course_limit' => 'required|integer',
            'active' => 'required',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
            'course_limit' => 'limite de curso',
            'active' => 'activo',
        ]);

        $onlineRegistration = new OnlineRegistration();
        $onlineRegistration->name = $this->name;
        $onlineRegistration->description = $this->description;
        $onlineRegistration->course_limit = $this->course_limit;
        $onlineRegistration->active = $this->active;
        $onlineRegistration->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Control de registros creado correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->onlineRegistrationId = $id;

        $onlineRegistration = OnlineRegistration::find($id);
        $this->name = $onlineRegistration->name;
        $this->description = $onlineRegistration->description;
        $this->course_limit = $onlineRegistration->course_limit;
        $this->active = $onlineRegistration->active;
    }

    public function update()
    {

        $this->validate([
            'name' => 'required|unique:online_registrations,name,' . $this->onlineRegistrationId,
            'description' => 'required',
            'course_limit' => 'required|integer',
            'active' => 'required',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
            'course_limit' => 'limite de curso',
            'active' => 'activo',
        ]);

        $onlineRegistration = OnlineRegistration::find($this->onlineRegistrationId);
        $onlineRegistration->name = $this->name;
        $onlineRegistration->description = $this->description;
        $onlineRegistration->course_limit = $this->course_limit;
        $onlineRegistration->active = $this->active;
        $onlineRegistration->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Control de registros actualizado correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->onlineRegistrationId = $id;
    }

    public function destroy()
    {
        $onlineRegistration = OnlineRegistration::find($this->onlineRegistrationId);
        $this->name = $onlineRegistration->name;

        // if ($onlineRegistration->assistanceRegisters->isNotEmpty()) {
        //     $this->emit('alert', ['type' => 'error', 'message' => 'No se puede eliminar el Control de registros porque tiene registros asociados']);
        //     return;
        // }

        $onlineRegistration->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Control de registos eliminado correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->course_limit = '';
        $this->active = 1;
        $this->onlineRegistrationId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();

        $this->resetErrorBag();
        $this->resetValidation();

        $this->emit('close-modal');
    }
}
