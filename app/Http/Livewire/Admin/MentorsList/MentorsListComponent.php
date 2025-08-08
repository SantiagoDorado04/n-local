<?php

namespace App\Http\Livewire\Admin\MentorsList;

use App\Contact;
use App\MentorsList;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class MentorsListComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $identification, $name, $email, $phone, $mentorId;
    public $searchName;

    public function render()
    {
        $mentors = MentorsList::when($this->searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.mentors-list.mentors-list-component', [
            'mentors' => $mentors,
        ]);
    }

    public function show($id)
    {
        $this->mentorId = $id;

        $mentor = MentorsList::find($id);
        $this->identification = $mentor->identification;
        $this->name = $mentor->name;
        $this->email = $mentor->email;
        $this->phone = $mentor->phone;
    }

    public function store()
    {
        $this->validate([
            'identification' => 'required|unique:mentors_list,identification',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ], [], [
            'identification' => 'identificacion',
            'name' => 'nombre',
            'email' => 'correo electronico',
            'phone' => 'telefono',
        ]);

        $mentor = new MentorsList();
        $mentor->identification = $this->identification;
        $mentor->name = $this->name;
        $mentor->email = $this->email;
        $mentor->phone = $this->phone;
        $mentor->save();

        // Validar si el usuario ya existe por email
        $user = User::where('email', $this->email)->first();
        if (!$user) {
            $user = new User();
            $user->name = $this->name;
            $user->email = $this->email;
            $user->password = Hash::make($this->identification);
            $user->role_id = '8';
            $user->save();
        }

        $this->emit('alert', ['type' => 'success', 'message' => 'Mentor creado correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->mentorId = $id;

        $mentor = MentorsList::find($id);

        $this->identification = $mentor->identification;
        $this->name = $mentor->name;
        $this->email = $mentor->email;
        $this->phone = $mentor->phone;
    }

    public function update()
    {
        $this->validate([
            'identification' => 'required|unique:mentors_list,identification,' . $this->mentorId,
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ], [], [
            'identification' => 'identificación',
            'name' => 'nombre',
            'email' => 'correo electrónico',
            'phone' => 'teléfono',
        ]);

        $mentor = MentorsList::find($this->mentorId);
        $mentor->identification = $this->identification;
        $mentor->name = $this->name;
        $mentor->email = $this->email;
        $mentor->phone = $this->phone;
        $mentor->update();
        $this->emit('alert', ['type' => 'success', 'message' => 'Mentor actualizado correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->mentorId = $id;
    }

    public function destroy()
    {
        $mentor = MentorsList::find($this->mentorId);
        $mentor->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Mentor eliminado correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->identification = '';
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->mentorId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();

        $this->resetErrorBag();
        $this->resetValidation();

        $this->emit('close-modal');
    }
}
