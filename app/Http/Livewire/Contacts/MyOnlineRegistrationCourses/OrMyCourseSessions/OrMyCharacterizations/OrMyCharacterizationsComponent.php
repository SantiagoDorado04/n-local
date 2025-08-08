<?php

namespace App\Http\Livewire\Contacts\MyOnlineRegistrationCourses\OrMyCourseSessions\OrMyCharacterizations;

use App\Contact;
use App\Models\OnlineRegistrationCharacterization;
use App\Models\OnlineRegistrationCourseSession;
use App\Models\OrAssignedCharacterization;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class OrMyCharacterizationsComponent extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $name, $description;

    public $session_id, $session;

    public $contactId;

    public $searchName;

    public function mount($id)
    {
        $this->session_id = $id;
        $user = Auth::user();
        $contact = Contact::where('user_id', '=', $user->id)->first();
        $this->contactId = $contact->id;
        $session = OnlineRegistrationCourseSession::find($this->session_id);
        $this->session = $session;
    }

    public function render()
    {
        $assignments = OrAssignedCharacterization::where('contact_id', $this->contactId) // Solo asignaciones del usuario autenticado
            ->whereHas('characterization', function ($query) {
                $query->where('session_id', $this->session_id); // Solo caracterizaciones de la sesión actual
            })
            ->with('characterization') // Cargar relación
            ->when($this->searchName, function ($query, $searchName) {
                return $query->whereHas('characterization', function ($subQuery) use ($searchName) {
                    $subQuery->where('name', 'like', '%' . $searchName . '%');
                });
            })
            ->paginate(6);

        $firstItem = $assignments->firstItem();
        $lastItem = $assignments->lastItem();
        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$assignments->total()} registros";

        return view('livewire.contacts.my-online-registration-courses.or-my-course-sessions.or-my-characterizations.or-my-characterizations-component', [
            'assignments' => $assignments,
            'paginationText' => $paginationText
        ]);
    }
    public function show($id)
    {
        $session = OnlineRegistrationCharacterization::findOrFail($id);
        $this->name = $session->name;
        $this->description = $session->description;
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->emit('close-modal');
    }

    private function resetInputFields()
    {
        $this->description = '';
        $this->name = '';
    }
}
