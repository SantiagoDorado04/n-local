<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\TestContents;

use App\Models\OnlineRegistrationCourseSession;
use App\Models\OnlineRegistrationSessionContent;
use App\Models\OnlineRegistrationTestContent;
use Illuminate\Validation\Rule;
use Livewire\Component;

class OnlineRegistrationTestContentsCreateComponent extends Component
{

    public $session_id, $session;
    public $title, $description, $instructions, $percentage = 0;


    public function mount($id)
    {
        $this->session_id = $id;
        $this->session = OnlineRegistrationCourseSession::find($id);
    }

    public function render()
    {
        return view('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.test-contents.online-registration-test-contents-create-component');
    }


    public function store()
    {
        $this->validate([
            'title' => [
                'required',
                Rule::unique('online_registrations_sessions_contents')->where(function ($query) {
                    return $query->where('session_id', $this->session_id);
                })
            ],
            'description' => 'required',
            'instructions' => 'nullable',
            'percentage' => 'required|numeric|min:0|max:100',
        ], [], [
            'title' => 'título',
            'description' => 'descripción',
            'instructions' => 'instrucciones',
            'percentage' => 'porcentaje de aprobacion',
        ]);

        // Obtener el último paso y definir el nuevo orden
        $lastStep = OnlineRegistrationSessionContent::where('session_id', $this->session_id)
            ->orderBy('step', 'desc')
            ->first();
        $newOrder = $lastStep ? $lastStep->step + 1 : 1;

        // Crear el contenido de la sesión
        $content = new OnlineRegistrationSessionContent();
        $content->title = $this->title;
        $content->description = $this->description;
        $content->type = 'T';
        $content->step = $newOrder;
        $content->session_id = $this->session_id;
        $content->save();

        // Crear el Test asociado
        $test = new OnlineRegistrationTestContent();
        $test->content_id = $content->id;
        $test->instructions = $this->instructions; // Guarda solo "slides/archivo.png"
        $test->percentage = $this->percentage;
        $test->save();

        // Emitir alerta de éxito
        session()->flash('success', 'Contenido de tipo test creado correctamente');
        $this->cancel();
        return redirect()->route('online-registration-sessionContent', ['id' => $this->session_id]);
    }

    public function resetInputFields()
    {
        $this->title = '';
        $this->description = '';
        $this->instructions = '';
        $this->percentage = 0;
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
