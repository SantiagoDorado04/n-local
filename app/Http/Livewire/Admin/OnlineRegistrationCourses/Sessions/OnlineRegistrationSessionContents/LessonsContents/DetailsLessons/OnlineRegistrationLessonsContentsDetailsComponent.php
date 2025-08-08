<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\LessonsContents\DetailsLessons;

use App\Models\OnlineRegistrationLessonContent;
use App\Models\OnlineRegistrationLessonStep;
use App\Models\OnlineRegistrationSessionContent;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class OnlineRegistrationLessonsContentsDetailsComponent extends Component
{
    public $content;
    public $session_id;
    public $lesson;
    public $lessonStep;
    public $onlineRegistrationCourseSession;
    public $searchName;
    public $lessonContent;


    public function mount($id)
    {
        $this->lesson = OnlineRegistrationSessionContent::find($id);

        $this->onlineRegistrationCourseSession = $this->lesson->onlineRegistrationCourseSession;
        $this->session_id = $this->onlineRegistrationCourseSession;
        $this->lessonContent = OnlineRegistrationLessonContent::where('content_id', $this->lesson->id)->first();
    }

    public function render()
    {
        //$lessonContent = OnlineRegistrationLessonContent::where('content_id', $this->lesson->id)->first();
        $lessonForm = OnlineRegistrationLessonStep::when($this->searchName, function ($query, $searchName) {
            return $query->where('title', 'like', '%' . $searchName . '%');
        })
            ->where('or_lesson_id', '=', $this->lessonContent->id)
            ->paginate(6);

        /*         dd($lessonForm);
 */
        return view('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.lessons-contents.details-lessons.online-registration-lessons-contents-details-component', [
            'lessonForm' => $lessonForm,
        ]);
    }
    public function delete($id)
    {
        $this->lessonStep = $id;
    }
    public function destroy()
    {
        if (!$this->lessonStep) {
            session()->flash('error', 'No se encontró el contenido a eliminar.');
            return;
        }
        $lessonStep = OnlineRegistrationLessonStep::find($this->lessonStep);

        if (!$lessonStep) {
            session()->flash('error', 'El contenido ya no existe.');
            return;
        }

        if ($lessonStep->image && Storage::exists('public/' . $lessonStep->image)) {
            Storage::delete('public/' . $lessonStep->image);
        }

        $lessonStep->delete();

        $this->lessonStep = null;

        session()->flash('success', 'El contenido de la lección se eliminó correctamente.');
        $this->cancel();
    }

    public function cancel()
    {
        $this->emit('close-modal');
    }

    public function updateOrder($order)
    {
        foreach ($order as $index => $id) {
            $step = OnlineRegistrationLessonStep::find($id);

            if ($step) { // Solo actualizar si el registro existe
                $step->order = $index + 1;
                $step->save();
            }
        }

        $this->emit('orderUpdated');
    }
}
