<?php

namespace App\Http\Livewire\Admin\LMS\Topics;

use App\Models\Course;
use App\Models\Topic;
use Livewire\Component;
use Livewire\WithPagination;

class TopicsComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $name,
        $description,
        $topicId,
        $courseId;

        public $searchName;

        public function mount($id){
            $this->courseId = $id;
        }

    public function render()
    {

        $topics = Topic::when($this->searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })
        ->where('course_id','=',$this->courseId)
        ->paginate(6);

        $firstItem = $topics->firstItem();
        $lastItem = $topics->lastItem();
        $course = Course::find($this->courseId);

        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$topics->total()} registros";

        return view('livewire.admin.l-m-s.topics.topics-component',[
            'topics' => $topics,
            'paginationText' => $paginationText,
            'course' => $course
        ]);
    }

    public function show($id)
    {
        $this->topicId = $id;

        $topic = Topic::find($id);
        $this->name = $topic->name;
        $this->description = $topic->description;
        $this->courseId = $topic->course_id;
    }

    public function store()
    {
        $this->validate([
           'name' => [
                'required',
                function ($attribute, $value, $fail) {
                    $existingTopic = Topic::where('name', $value)
                        ->where('course_id', $this->courseId)
                        ->where('id', '!=', $this->topicId) //
                        ->first();
                    if ($existingTopic) {
                        $fail('El nombre de la tematica ya existe en este curso.');
                    }
                },
            ],
            'description' => 'required',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
        ]);

        $topic = new Topic();
        $topic->name = $this->name;
        $topic->description = $this->description;
        $topic->course_id = $this->courseId;
        $topic->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Tematica creada correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {

        $this->topicId = $id;

        $topic = Topic::find($id);
        $this->name = $topic->name;
        $this->description = $topic->description;
    }

    public function update()
    {

        $this->validate([
            'name' => [
                'required',
                function ($attribute, $value, $fail) {
                    $existingTopic = Topic::where('name', $value)
                        ->where('course_id', $this->courseId)
                        ->where('id', '!=', $this->topicId) //
                        ->first();
                    if ($existingTopic) {
                        $fail('El nombre de la tematica ya existe en este curso.');
                    }
                },
            ],
            'description' => 'required',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
        ]);

        $topic = Topic::find($this->topicId);
        $topic->name = $this->name;
        $topic->description = $this->description;
        $topic->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Tematica actualizada correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->topicId = $id;
    }

    public function destroy()
    {
        $topic = Topic::find($this->topicId);
        $topic->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Tematica eliminada correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->topicId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
