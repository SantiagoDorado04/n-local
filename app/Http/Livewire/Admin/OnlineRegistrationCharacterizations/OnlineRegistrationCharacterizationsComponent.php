<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCharacterizations;

use App\Models\OnlineRegistrationCharacterization;
use App\Models\OnlineRegistrationContactCourse;
use App\Models\OnlineRegistrationCourseSession;
use App\Models\OrAssignedCharacterization;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class OnlineRegistrationCharacterizationsComponent extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $name,
        $description,
        $characterization_id;

    public $type = 'G';

    public $form;

    public $searchName;

    public $session_id;

    public $user_created_at, $user_updated_at;

    public function mount($id)
    {
        $this->session_id = $id;
    }

    public function render()
    {
        $characterizations = OnlineRegistrationCharacterization::when($this->searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })
            ->where('session_id', '=', $this->session_id)
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        $firstItem = $characterizations->firstItem();
        $lastItem = $characterizations->lastItem();
        $session = OnlineRegistrationCourseSession::find($this->session_id);

        $paginationText = "Mostrando de {$firstItem} a {$lastItem} de {$characterizations->total()} registros";

        return view('livewire.admin.online-registration-characterizations.online-registration-characterizations-component', [
            'characterizations' => $characterizations,
            'paginationText' => $paginationText,
            'session' => $session
        ]);
    }

    public function show($id)
    {
        $this->characterization_id = $id;

        $characterization = OnlineRegistrationCharacterization::find($id);
        $this->name = $characterization->name;
        $this->description = $characterization->description;
        $this->type = $characterization->type;
        $userCreate = User::find($characterization->user_created_at);
        $this->user_created_at = $userCreate ? $userCreate->name : 'Sin creador';
        $userUpdate = User::find($characterization->user_updated_at);
        $this->user_updated_at = $userUpdate ? $userUpdate->name : 'Sin modificación';
    }

    public function store($type)
    {
        //tipo especifico o general
        if ($type == 'S' || $type == 'G') {
            $this->validate([
                'name' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        $existingCharacterization = OnlineRegistrationCharacterization::where('name', $value)
                            ->where('session_id', $this->session_id)
                            ->where('id', '!=', $this->characterization_id)
                            ->first();
                        if ($existingCharacterization) {
                            $fail('El nombre del formulario de caracterización ya existe en este paso.');
                        }
                    },
                ],
                'description' => 'required',
                'type' => 'nullable',
            ], [], [
                'name' => 'nombre',
                'description' => 'descripción',
                'type' => 'tipo',
            ]);

            $characterization = new OnlineRegistrationCharacterization();
            $characterization->name = $this->name;
            $characterization->description = $this->description;
            $characterization->type = $type;
            $characterization->session_id = $this->session_id;
            $characterization->save();

            // Validacion: si el tipo de formulario es G o general, se asigna el formulario a todos los usuarios del curso, sino se crea el formulario especifico y si el tipo es incorrecto, arroja un error
            if ($type == 'G') {
                $this->assignCharacterizationToCourseUsers($characterization->id);
            }

            if ($type == 'S') {
                $this->emit('alert', ['type' => 'success', 'message' => 'Formulario específico creado correctamente']);
            } elseif ($type == 'G') {
                $this->emit('alert', ['type' => 'success', 'message' => 'Formulario de tipo general creado correctamente']);
            }
        } else {
            $this->emit('alert', ['type' => 'danger', 'message' => 'El tipo del formulario especificado no es correcto']);
        }

        $this->cancel();
    }

    private function assignCharacterizationToCourseUsers($characterizationId)
    {
        // Obtener la sesión asociada
        $session = OnlineRegistrationCourseSession::find($this->session_id);

        if (!$session || !$session->onlineRegistrationCourse) {
            return;
        }

        // Obtener todos los contactos registrados en el curso
        $registeredContacts = OnlineRegistrationContactCourse::where('or_course_id', $session->or_course_id)->get();

        foreach ($registeredContacts as $contactCourse) {
            OrAssignedCharacterization::create([
                'contact_id' => $contactCourse->contact_id,
                'characterization_id' => $characterizationId,
                'answered' => false, // GUARDA EL FORMULARIO SIN RESPONDER AUN
            ]);
        }
    }



    public function edit($id)
    {
        $this->characterization_id = $id;
        $characterization = OnlineRegistrationCharacterization::find($id);
        $this->name = $characterization->name;
        $this->description = $characterization->description;
        $this->type = $characterization->type;
    }


    public function update()
    {

        $this->validate([
            'name' => [
                'required',
                function ($attribute, $value, $fail) {
                    $existingCharacterization = OnlineRegistrationCharacterization::where('name', $value)
                        ->where('session_id', $this->session_id)
                        ->where('id', '!=', $this->characterization_id) //
                        ->first();
                    if ($existingCharacterization) {
                        $fail('El nombre del formulario de caracterizacion ya existe en este paso.');
                    }
                },
            ],
            'description' => 'required',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
        ]);

        $characterization = OnlineRegistrationCharacterization::find($this->characterization_id);
        $characterization->name = $this->name;
        $characterization->description = $this->description;
        $characterization->update();

        if ($this->type == 'S') {
            $this->emit('alert', ['type' => 'success', 'message' => 'Formulario especifico creado correctamente']);
        } elseif ($this->type == 'G') {
            $this->emit('alert', ['type' => 'success', 'message' => 'Formulario de tipo general creado correctamente']);
        }

        $this->cancel();
    }

    public function delete($id)
    {
        $this->characterization_id = $id;
    }

    public function destroy()
    {
        $characterization = OnlineRegistrationCharacterization::find($this->characterization_id);
        $this->type = $characterization->type;
        $characterization->delete();

        if ($this->type == 'S') {
            $this->emit('alert', ['type' => 'success', 'message' => 'Formulario de caracterizacion especifico eliminado correctamente']);
        } elseif ($this->type == 'G') {
            $this->emit('alert', ['type' => 'success', 'message' => 'Formulario de caracterizacion general eliminado correctamente']);
        }

        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->form = '';
        $this->name = '';
        $this->description = '';
        $this->type = 'G';
        $this->user_created_at = '';
        $this->user_updated_at = '';
        $this->characterization_id = '';
    }

    public function cancel()
    {
        $this->resetInputFields();

        $this->resetErrorBag();
        $this->resetValidation();

        $this->emit('close-modal');
    }

    public function preview($id)
    {
        $this->characterization_id = $id;
        $this->form = OnlineRegistrationCharacterization::with('questions')->find($this->characterization_id);
    }
}
