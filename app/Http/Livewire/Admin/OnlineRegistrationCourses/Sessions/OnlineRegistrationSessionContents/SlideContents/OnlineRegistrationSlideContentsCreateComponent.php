<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\SlideContents;

use App\Models\OnlineRegistrationCourseSession;
use App\Models\OnlineRegistrationSessionContent;
use App\Models\OnlineRegistrationSlideContent;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class OnlineRegistrationSlideContentsCreateComponent extends Component
{
    use WithFileUploads;

    public $session_id, $session;

    /** @var \Livewire\TemporaryUploadedFile */
    public $file;
    public $title, $description;

    public function mount($id)
    {
        $this->session_id = $id;
        $this->session = OnlineRegistrationCourseSession::find($id);
    }

    public function render()
    {
        return view('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.slide-contents.online-registration-slide-contents-create-component');
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
            'file' => 'required|image|mimes:jpg,jpeg,png|max:2048', // Validación para la imagen
        ], [], [
            'title' => 'título',
            'description' => 'descripción',
            'file' => 'banner',
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
        $content->type = 'S';
        $content->step = $newOrder;
        $content->session_id = $this->session_id;
        $content->save();

        // Guardar la imagen si se subió
        if ($this->file) {
            $filePath = $this->file->store('slides', 'public'); // Guarda la imagen en storage/app/public/slides/
        } else {
            $filePath = null;
        }

        // Crear el slide asociado
        $slide = new OnlineRegistrationSlideContent();
        $slide->content_id = $content->id;
        $slide->banner_image = $filePath; // Guarda solo "slides/archivo.png"
        $slide->save();

        // Emitir alerta de éxito
        $this->emit('alert', ['type' => 'success', 'message' => 'Contenido de tipo slide creado correctamente']);
        session()->flash('success', 'Contenido de tipo slide creado correctamente');
        $this->cancel();
        return redirect()->route('online-registration-sessionContent', ['id' => $this->session_id]);
    }


    public function removeFile()
    {
        if ($this->file) {
            // Convertir la URL en una ruta relativa válida
            $filePath = str_replace('/storage/', 'public/', $this->file);

            // Verificar si el archivo existe antes de eliminarlo
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            // Limpiar la variable de la imagen
            $this->file = null;
            $this->reset('file');
        }
        $this->emit('alert', ['type' => 'success', 'message' => 'Archivo eliminado correctamente']);
    }

    public function resetInputFields()
    {
        $this->title = '';
        $this->file = null;
        $this->description = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
