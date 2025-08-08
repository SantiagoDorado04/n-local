<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\LessonsContents\DetailsLessons;

use App\Models\OnlineRegistrationLessonContent;
use App\Models\OnlineRegistrationLessonStep;
use App\Models\OnlineRegistrationSessionContent;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class OnlineRegistrationLessonDetailsEditComponent extends Component
{
    use WithFileUploads;
    public $content;
    public $session_id;
    public $lesson_session;
    public $lesson;
    public $onlineRegistrationCourseSession;
    public $lessonContent;
    public $lessonStep_id;
    public $image;
    public $title;
    public $body;
    public $existingFile;
    public $parameter = true;
    public $align_image = "right";


    public function mount($id)
    {
        $this->lessonStep_id = $id;
        $this->lesson_session = OnlineRegistrationLessonStep::find($id);
        $this->session_id = $this->lesson_session->lesson->onlineRegistrationSessionContent->onlineRegistrationCourseSession;
        // dd($this->lesson_session);

        $this->title = $this->lesson_session->title;
        $this->content = $this->lesson_session->body;
        $this->align_image = $this->lesson_session->align_image;

        if ($this->align_image == "left") {
            $this->parameter = false;
        } else {
            $this->parameter = true;
        }


        $this->existingFile = asset('storage/' . $this->lesson_session->image);

        // dd($this->existingFile);
    }

    public function render()
    {
        return view('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.lessons-contents.details-lessons.online-registration-lesson-details-edit-component');
    }
    public function toggleApprovalForm()
    {
        $this->parameter = !$this->parameter;
        $this->align_image = $this->parameter ? 'right' : 'left';
    }

    public function update()
    {
        $this->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image',
        ], [], [
            'title' => 'título',
            'content' => 'cuerpo',
            'image' => 'imagen',
        ]);

        // Buscar el registro a modificar
        $lessonStep = OnlineRegistrationLessonStep::find($this->lesson_session->id);

        if (!$lessonStep) {
            return redirect()->route('online-registration-lesson-content-detail', ['id' => $this->or_lesson_id])
                ->with('error', 'El contenido no existe.');
        }

        // Actualizar los valores
        $lessonStep->title = $this->title;
        $lessonStep->body = $this->content;
        $lessonStep->align_image = $this->align_image;

        // Si el usuario sube una nueva imagen, eliminar la anterior y actualizar
        if ($this->image instanceof \Illuminate\Http\UploadedFile) {
            // Borrar la imagen anterior si existe
            if ($lessonStep->image && Storage::disk('public')->exists($lessonStep->image)) {
                Storage::disk('public')->delete($lessonStep->image);
            }
            // Guardar la nueva imagen
            $filePath = $this->image->store('lesson', 'public');
            $lessonStep->image = $filePath;
        }

        $lessonStep->save();

        return redirect()->route('online-registration-lesson-content-detail', ['id' => $this->lesson_session->lesson->content_id])
            ->with('success', 'El contenido de la lección se ha editado correctamente.');
    }
}
