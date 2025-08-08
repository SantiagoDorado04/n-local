<?php

namespace App\Http\Livewire\Contacts\LMS;

use App\Contact;
use App\Models\Topic;
use App\Models\Course;
use App\Models\Lesson;
use App\ContactsCourse;
use App\LessonProgress;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LmsContentComponent extends Component
{
    public $courseId;
    public $currentLessonId;
    public $currentLesson;

    public $progress;
    public $duration;
    public $lessonStartTime;

    public  $contactId;

    protected $listeners = ['lessonCompleted', 'updateProgress'];

    public $stageActive = false;

    public function mount($id)
    {
        $user = Auth::user();
        $contact = Contact::where('user_id', $user->id)->first();
        $this->contactId = $contact ? $contact->id : null;

        $this->courseId = $id;

        $course = Course::findOrFail($id);
        if ($course->step->stage->active == 1) {
            $this->stageActive = true;
        }


        $lastProgress = LessonProgress::where('contact_id', $this->contactId)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($lastProgress) {
            $nextLesson = Lesson::whereHas('topic', function ($query) {
                $query->where('course_id', $this->courseId);
            })->where('id', '>', $lastProgress->lesson_id)
                ->orderBy('id')
                ->first();

            if ($nextLesson) {
                $this->currentLessonId = $nextLesson->id;
            }
        }

        if (!$this->currentLessonId) {
            $firstLesson = Topic::where('course_id', $this->courseId)
                ->with(['lessons' => function ($query) {
                    $query->orderBy('order', 'asc');
                }])
                ->first()
                ->lessons
                ->first();

            $this->currentLessonId = $firstLesson ? $firstLesson->id : null;
        }

        $this->currentLesson = Lesson::find($this->currentLessonId);

        if ($this->currentLesson) {
            
            if (is_numeric($this->currentLesson->duration)) {
                
                $this->duration = $this->currentLesson->duration / 60;
            } elseif (preg_match('/^\d{2}:\d{2}:\d{2}$/', $this->currentLesson->duration)) {
                
                list($hours, $minutes, $seconds) = explode(':', $this->currentLesson->duration);
                $this->duration = ($hours * 3600) + ($minutes * 60) + $seconds;
            } else {
                
                $this->duration = 0;
            }
        } else {
            $this->duration = 0;
        }
        
        
        $this->progress = 0;
    }

    public function render()
    {
        $course = Course::with(['topics.lessons' => function ($query) {
            $query->orderBy('order', 'asc');
        }])->find($this->courseId);
        $progressUser = LessonProgress::where('contact_id', $this->contactId)->pluck('lesson_id')->toArray();
        return view('livewire.contacts.l-m-s.lms-content-component', [
            'course' => $course,
            'progressUser' => $progressUser,
        ]);
    }

    public function loadLesson($lessonId)
    {
/*         $currentTime = now()->timestamp;
        $elapsedTime = $currentTime - $this->lessonStartTime;
        $remainingTime = max($this->currentLesson->duration - ($elapsedTime / 60), 0); */

        $this->currentLessonId = $lessonId;
        $this->currentLesson = Lesson::find($lessonId);

        if ($this->currentLesson) {
            
            if (is_numeric($this->currentLesson->duration)) {
                
                $this->duration = $this->currentLesson->duration / 60;
            } elseif (preg_match('/^\d{2}:\d{2}:\d{2}$/', $this->currentLesson->duration)) {
                
                list($hours, $minutes, $seconds) = explode(':', $this->currentLesson->duration);
                $this->duration = ($hours * 3600) + ($minutes * 60) + $seconds;
            } else {
                
                $this->duration = 0;
            }
        } else {
            $this->duration = 0;
        }
        
        
        $this->progress = 0;

        $this->emit('restart', $this->duration);

    }

    public function resetProgress()
    {
        $this->progress = 0;

    }

    public function startLesson()
    {
        $this->emit('lessonStarted', $this->duration);
        $this->progress = 0;
    }

    public function lessonCompleted()
    {
        $progress = new LessonProgress();
        $progress->contact_id = $this->contactId;
        $progress->lesson_id = $this->currentLessonId;
        $progress->save();

        $course = Course::with(['topics' => function ($query) {
            $query->withCount('lessons');
        }])->find($this->courseId);
        $totalLessons = $course->topics->sum('lessons_count');

        $progress = ContactsCourse::where('contact_id', '=', $this->contactId)
            ->where('course_id', '=', $this->courseId)
            ->first();

        if (!$progress) {
            $progress = new ContactsCourse();
            $progress->contact_id = $this->contactId;
            $progress->course_id = $this->courseId;
            $progress->lessons_number = 1;
            $progress->total_lessons = $totalLessons;

            if ($totalLessons == 1) {
                $progress->complete = 1;
            } else {
                $progress->complete = 0;
            }

            $progress->save();

            $this->emit('alert', ['type' => 'success', 'message' => 'Lección completada! (' . $progress->lessons_number . ' de ' . $totalLessons . ' Lecciones)']);
        } else {
            $progress->lessons_number = $progress->lessons_number + 1;
            if ($progress->lessons_number >= $totalLessons) {
                $progress->complete = 1;
            } else {
                $progress->complete = 0;
            }

            $progress->total_lessons = $totalLessons;
            $progress->save();
            $this->emit('alert', ['type' => 'success', 'message' => 'Lección completada! (' . $progress->lessons_number . ' de ' . $totalLessons . ' Lecciones)']);
        }
    }


    public function updateProgress($progress)
    {
        $this->progress = $progress;
    }
}
