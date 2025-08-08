<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\TestContents;

use App\Models\OnlineRegistrationSessionContent;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;

class OnlineRegistrationTestContentsEditComponent extends Component
{

    public $session_id, $session;
    public $content_id, $content;
    public $title, $description, $instructions, $percentage = 0;

    public function mount($id)
    {
        $this->content_id = $id;
        $this->content = OnlineRegistrationSessionContent::find($id);
        $this->session_id = $this->content->session_id;
        $this->session = $this->content->onlineRegistrationCourseSession;
        $this->title = $this->content->title;
        $this->description = $this->content->description;
        $this->instructions = $this->content->test->instructions;
        $this->percentage = $this->content->test->percentage;
    }

    public function render()
    {
        return view('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.test-contents.online-registration-test-contents-edit-component');
    }

    public function update()
    {
        $this->validate([
            'title' => [
                'required',
                Rule::unique('online_registrations_sessions_contents')
                    ->where(function ($query) {
                        return $query->where('session_id', $this->session_id);
                    })
                    ->ignore($this->content_id) // Excluir el registro actual
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

        // Actualizar los datos del contenido
        $this->content->update([
            'title' => $this->title,
            'description' => $this->description,
        ]);

        if ($this->content->test) {
            $this->content->test->update([
                'instructions' => $this->instructions,
                'percentage' => $this->percentage,
            ]);
        } else {
            dd("No existe un test asociado a este contenido.");
        }

        session()->flash('success', 'Contenido actualizado correctamente');

        return redirect()->route('online-registration-sessionContent', ['id' => $this->session_id]);
    }
}
