<?php

namespace App\Http\Livewire\Admin\LMS\Lessons;

use App\Models\Topic;
use App\Models\Lesson;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class LessonsComponent extends Component
{
    use WithFileUploads;

    public $topicId;

    public $title,
        $description,
        $video,
        $protectedVideo,
        $file,
        $content,
        $order,
        $duration,
        $published,
        $lessonId,
        $currentFile;

    public $hours = 00, $minutes = 00, $seconds = 00;

    public function mount($id)
    {
        $this->topicId = $id;
    }

    public function render()
    {
        $lessons = Lesson::where('topic_id', '=', $this->topicId)->get();
        $topic = Topic::find($this->topicId);

        return view('livewire.admin.l-m-s.lessons.lessons-component', [
            'lessons' => $lessons,
            'topic' => $topic
        ]);
    }

    public function show($id)
    {
        $lesson = Lesson::find($id);

        $this->topicId = $lesson->topic_id;
        $this->lessonId = $lesson->id;

        $this->title = $lesson->title;
        $this->description = $lesson->description;
        $this->video = $lesson->video;
        $this->currentFile = $lesson->file;
        $this->file = null; // Reiniciar el archivo
        $this->content = $lesson->content;
        $this->order = $lesson->order;
        $this->duration = $lesson->duration;
        $this->published = $lesson->published;
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'description' => 'required',
            'video' => 'nullable',
            'protectedVideo' => 'nullable',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:51200',
            'content' => 'nullable',
            'order' => 'required|integer',
            'hours' => 'required|integer',
            'minutes' => 'required|integer',
            'seconds' => 'required|integer',
            'published' => 'nullable|boolean',
        ], [], [
            'title' => 'título',
            'description' => 'descripción',
            'video' => 'video',
            'protectedVideo' => 'video protegido',
            'file' => 'archivo',
            'content' => 'contenido',
            'order' => 'orden',
            'hours' => 'horas',
            'minutes' => 'minutos',
            'seconds' => 'segundos',
            'published' => 'publicado',
        ]);

        $lesson = new Lesson();
        $lesson->title = $this->title;
        $lesson->description = $this->description;
        $lesson->video = $this->video;

        if (!empty($this->protectedVideo)) {
            $parsedUrl = parse_url($this->protectedVideo);
            $path = $parsedUrl['path'] ?? '';
            $pathParts = explode('/', trim($path, '/'));
            $lastPart = end($pathParts);
            $publicId = preg_replace('/\.html$/', '', $lastPart);
            array_pop($pathParts);
            $folder = implode('/', $pathParts);
            $folder = str_replace('file/', '', $folder);

            $fileInfo = app(\App\Services\PublitioService::class)->findByPublicId($publicId, $folder);

            if ($fileInfo && isset($fileInfo['id'])) {
                $lesson->protected_video = $fileInfo['id']; // Guardar el id interno correcto
            }
        }


        if ($this->file) {
            $originalFileName = $this->file->getClientOriginalName();
            $filePath = $this->file->storeAs('public/files', $originalFileName);
            $lesson->file = Storage::url($filePath);
        }

        $lesson->topic_id = $this->topicId;
        $lesson->content = $this->content;
        $lesson->order = $this->order;

        if (strlen($this->hours) === 1) $this->hours = '0' . $this->hours;
        if (strlen($this->minutes) === 1) $this->minutes = '0' . $this->minutes;
        if (strlen($this->seconds) === 1) $this->seconds = '0' . $this->seconds;
        $lesson->duration = $this->hours . ':' . $this->minutes . ':' . $this->seconds;

        $lesson->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Lección agregada correctamente']);
        $this->cancel();
    }


    public function edit($id)
    {
        $lesson = Lesson::find($id);

        $this->topicId = $lesson->topic_id;
        $this->lessonId = $lesson->id;

        $this->title = $lesson->title;
        $this->description = $lesson->description;
        $this->protectedVideo = '';
        $this->video = $lesson->video;
        $this->currentFile = $lesson->file;
        $this->file = null;
        $this->content = $lesson->content;


        $this->order = $lesson->order;

        if ($lesson->duration) {
            if (is_numeric($lesson->duration)) {
                $this->hours = '0';
                $this->minutes = $lesson->duration;
                $this->seconds = '0';
            } elseif (preg_match('/^\d{2}:\d{2}:\d{2}$/', $lesson->duration)) {
                list($this->hours, $this->minutes, $this->seconds) = explode(':', $lesson->duration);
            } else {
                $this->hours = '0';
                $this->minutes = '0';
                $this->seconds = '0';
            }
        } else {
            $this->hours = '0';
            $this->minutes = '0';
            $this->seconds = '0';
        }

        $this->published = $lesson->published;
    }

    public function removeFile()
    {
        $this->currentFile = null;
        $this->file = null;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required',
            'description' => 'required',
            'protectedVideo' => 'nullable',
            'video' => 'nullable',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:51200',
            'content' => 'nullable',
            'order' => 'required|integer',
            'hours' => 'required',
            'minutes' => 'required',
            'seconds' => 'required',
            'published' => 'nullable|boolean',
        ], [], [
            'title' => 'título',
            'description' => 'descripción',
            'protectedVideo' => 'video protegido',
            'video' => 'video',
            'file' => 'archivo',
            'content' => 'content',
            'order' => 'orden',
            'hours' => 'horas',
            'minutes' => 'minutos',
            'seconds' => 'segundos',
            'published' => 'publicado',
        ]);

        $lesson = Lesson::find($this->lessonId);
        $lesson->title = $this->title;
        $lesson->description = $this->description;
        $lesson->video = $this->video;

        if (!empty($this->protectedVideo)) {
            $parsedUrl = parse_url($this->protectedVideo);
            $path = $parsedUrl['path'] ?? '';
            $pathParts = explode('/', trim($path, '/'));
            $lastPart = end($pathParts);
            $publicId = preg_replace('/\.html$/', '', $lastPart);
            array_pop($pathParts);
            $folder = implode('/', $pathParts);
            $folder = str_replace('file/', '', $folder);
            $fileInfo = app(\App\Services\PublitioService::class)->findByPublicId($publicId, $folder);

            if ($fileInfo && isset($fileInfo['id'])) {
                $lesson->protected_video = $fileInfo['id'];
            }
        }


        if ($this->file) {
            $originalFileName = $this->file->getClientOriginalName();
            $filePath = $this->file->storeAs('public/files', $originalFileName);
            $lesson->file = Storage::url($filePath);
        } elseif ($this->currentFile === null) {
            $lesson->file = null;
        }
        $lesson->content = $this->content;
        $lesson->topic_id = $this->topicId;
        $lesson->order = $this->order;

        if (strlen($this->hours) === 1) {
            $this->hours = '0' . $this->hours;
        }
        if (strlen($this->minutes) === 1) {
            $this->minutes = '0' . $this->minutes;
        }
        if (strlen($this->seconds) === 1) {
            $this->seconds = '0' . $this->seconds;
        }
        $lesson->duration = $this->hours . ':' . $this->minutes . ':' . $this->seconds;

        $lesson->save();

        $lesson->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Lección actualizada correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->lessonId = $id;
    }

    public function destroy()
    {
        $lesson = Lesson::find($this->lessonId);
        $lesson->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Lección eliminada correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->title = '';
        $this->description = '';
        $this->video = '';
        $this->file = '';
        $this->content = '';
        $this->order = '';
        $this->duration = '';
        $this->hours = 00;
        $this->minutes = 00;
        $this->seconds = 00;
        $this->published = '';
        $this->currentFile = '';
        $this->protectedVideo = '';
    }

    public function updateOrder($order)
    {
        foreach ($order as $index => $id) {
            $lesson = Lesson::find($id);
            $lesson->order = $index + 1;
            $lesson->save();
        }

        $this->emit('orderUpdated');
    }


    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
