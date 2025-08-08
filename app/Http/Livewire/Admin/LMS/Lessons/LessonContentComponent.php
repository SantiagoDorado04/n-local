<?php

namespace App\Http\Livewire\Admin\LMS\Lessons;

use App\Models\Lesson;
use Livewire\Component;
use App\Models\Topic;

class LessonContentComponent extends Component
{
    public $lessonId;
    public $content;
    public $topicId;
    public $topic;
    public $lesson,      $currentFile;

    public function mount($id)
    {
        $this->lessonId = $id;
        $this->lesson = Lesson::with('topic.course.step.stage.process')->find($this->lessonId);
        $this->content = $this->lesson->content;
        $this->topicId = $this->lesson->topic_id;
        $this->topic = Topic::with(['course.step.stage.process', 'course.step.stage', 'course.step', 'course'])->find($this->topicId);
    }

    public function render()
    {
        return view('livewire.admin.l-m-s.lessons.lesson-content-component', [
            'lesson' => $this->lesson,
            'topic' => $this->topic
        ]);
    }

    public function store()
    {
        $this->validate([
            'content' => 'required',
        ]);

        $lesson = Lesson::find($this->lessonId);
        $lesson->content = $this->content;
        $lesson->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Contenido actualizado correctamente']);
    }

    public function update()
    {
        $this->validate([
            'content' => 'required',
        ]);

        $lesson = Lesson::find($this->lessonId);
        $lesson->content = $this->content;
        $lesson->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Contenido actualizado correctamente']);
    }
}
