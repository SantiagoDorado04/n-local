<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\SlideContents;

use App\Models\OnlineRegistrationSessionContent;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class OnlineRegistrationSlideContentsEditComponent extends Component
{

    use WithFileUploads;

    public $content_id, $content;
    public $session_id, $session;
    public $title, $description;

    /** @var \Livewire\TemporaryUploadedFile */
    public $file;

    public $existingFile; // Variable para la imagen actual

    public function mount($id)
    {
        $this->content_id = $id;
        $this->content = OnlineRegistrationSessionContent::find($id);
        $this->session_id = $this->content->session_id;
        $this->session = $this->content->onlineRegistrationCourseSession;
        $this->title = $this->content->title;
        $this->description = $this->content->description;

        if ($this->content->slide && $this->content->slide->banner_image) {
            $this->existingFile = asset('storage/' . $this->content->slide->banner_image);
        }
    }


    public function render()
    {
        return view('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.slide-contents.online-registration-slide-contents-edit-component');
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
            'file' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Actualizar los datos del contenido
        $this->content->update([
            'title' => $this->title,
            'description' => $this->description,
        ]);

        // Si se sube una nueva imagen
        if ($this->file) {
            // Eliminar la imagen anterior si existe
            if ($this->content->slide && $this->content->slide->banner_image) {
                $oldImagePath = 'public/' . $this->content->slide->banner_image;
                if (Storage::exists($oldImagePath)) {
                    Storage::delete($oldImagePath);
                }
            }

            // Guardar la nueva imagen
            $filePath = $this->file->store('slides', 'public'); // Guarda en storage/app/public/slides/

            // Actualizar el slide asociado con la nueva ruta relativa
            $this->content->slide->update([
                'banner_image' => $filePath, // Guarda solo "slides/archivo.png"
            ]);

            // Actualizar la vista previa con la nueva imagen
            $this->existingFile = asset('storage/' . $filePath);
        }

        session()->flash('success', 'Contenido actualizado correctamente');

        $this->cancel();
        return redirect()->route('online-registration-sessionContent', ['id' => $this->session_id]);
    }

    public function removeFile()
    {
        if ($this->existingFile) {
            $filePath = str_replace('/storage/', 'public/', $this->existingFile);

            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            // Limpiar la variable de la imagen
            $this->existingFile = null;
            $this->file = null;
        }

        $this->emit('alert', ['type' => 'success', 'message' => 'Archivo eliminado correctamente']);
    }

    public function updatedFile()
    {
        // Actualizar la vista previa cuando se seleccione una nueva imagen
        if ($this->file) {
            $this->existingFile = $this->file->temporaryUrl();
        }
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
