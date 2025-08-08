<?php

namespace App\Http\Livewire\Admin\LMS\Courses;

use App\Models\Course;
use App\Models\Step;
use Livewire\Component;
use Livewire\WithPagination;


class CoursesComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $name, $description, $first = 0, $previous_course, $next_course, $duration, $start_date, $end_date, $points, $required_points,
        $reminder_message, $reminder_message_date, $reminder_message_mean, $congratulation_message, $congratulation_message_date,
        $congratulation_message_mean, $courseId;

    public $searchName;

    public $stepId;

    public $anterior, $siguiente;

    public function mount($id)
    {
        $this->stepId = $id;
    }

    public function render()
    {
        $courses = Course::when($this->searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })
            ->where('step_id', '=', $this->stepId)
            ->paginate(6);

        $firstItem = $courses->firstItem();
        $lastItem = $courses->lastItem();
        $step = Step::find($this->stepId);

        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$courses->total()} Registros";

        return view('livewire.admin.l-m-s.courses.courses-component', [
            'courses' => $courses,
            'paginationText' => $paginationText,
            'step' => $step
        ]);
    }

    public function show($id)
    {
        $this->courseId = $id;

        $course = Course::find($id);
        $this->name = $course->name;
        $this->description = $course->description;
        $this->first = $course->first;
        $this->anterior = $course->previousCourse ? $course->previousCourse->name : null;
        $this->siguiente = $course->nextCourse ? $course->nextCourse->name : null;
        $this->duration = $course->duration;
        $this->start_date = $course->start_date;
        $this->end_date = $course->end_date;
        $this->points = $course->points;
        $this->required_points = $course->required_points;
        $this->reminder_message = $course->reminder_message;
        $this->reminder_message_date = $course->reminder_message_date;
        $this->reminder_message_mean = $course->reminder_message_mean;
        $this->congratulation_message = $course->congratulation_message;
        $this->congratulation_message_date = $course->congratulation_message_date;
        $this->congratulation_message_mean = $course->congratulation_message_mean;
    }

    public function store()
    {
        $this->validate([
            'name' => [
                'required',
                function ($attribute, $value, $fail) {
                    $existingCourse = Course::where('name', $value)
                        ->where('step_id', $this->stepId)
                        ->where('id', '!=', $this->courseId) //
                        ->first();
                    if ($existingCourse) {
                        $fail('El nombre del curso ya existe en este paso.');
                    }
                },
            ],
            'description' => 'required',
            'first' => 'required|in:0,1',
            'previous_course' => 'nullable|exists:courses,id',
            'next_course' => 'nullable|exists:courses,id',
            'duration' => 'required|numeric',
            'start_date' => 'required|date', //|after_or_equal:today
            'end_date' => 'required|after_or_equal:start_date',
            'points' => 'nullable|numeric|min:0',
            'required_points' => 'nullable|numeric|min:0',
            'reminder_message' => 'nullable',
            'reminder_message_date' => 'nullable|date|after_or_equal:today',
            'reminder_message_mean' => 'nullable',
            'congratulation_message' => 'nullable',
            'congratulation_message_date' => 'nullable|date|after_or_equal:today',
            'congratulation_message_mean' => 'nullable',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
            'first' => 'primero',
            'previous_course' => 'curso_anterior',
            'next_course' => 'siguiente_curso',
            'duration' => 'duración',
            'start_date' => 'fecha de inicio',
            'end_date' => 'fecha final',
            'points' => 'puntos',
            'required_points' => 'puntos requeridos',
            'reminder_message' => 'Mensaje recordatorio',
            'reminder_message_date' => 'Fecha Mensaje recordatorio',
            'reminder_message_mean' => 'Medio Mensaje recordatorio',
            'congratulation_message' => 'Mensaje felicitacion',
            'congratulation_message_date' => 'Fecha Mensaje felicitacion',
            'congratulation_message_mean' => 'Medio Mensaje felicitacion',
        ]);

        $course = new Course();

        $course->name = $this->name ?: null;
        $course->description = $this->description ?: null;
        $course->first = $this->first ?: 0;
        $course->previous_course = $this->previous_course ?: null;
        $course->next_course = $this->next_course ?: null;
        $course->duration = $this->duration ?: null;
        $course->start_date = $this->start_date ?: null;
        $course->end_date = $this->end_date ?: null;
        $course->points = $this->points ?: 0;
        $course->required_points = $this->required_points ?: 0;
        $course->reminder_message = $this->reminder_message ?: null;
        $course->reminder_message_date = $this->reminder_message_date ?: null;
        $course->reminder_message_mean = $this->reminder_message_mean ?: null;
        $course->congratulation_message = $this->congratulation_message ?: null;
        $course->congratulation_message_date = $this->congratulation_message_date ?: null;
        $course->congratulation_message_mean = $this->congratulation_message_mean ?: null;
        $course->step_id = $this->stepId ?: null;

        $course->save();


        $this->emit('alert', ['type' => 'success', 'message' => 'Curso creado correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {

        $this->courseId = $id;

        $course = Course::find($id);

        $this->name = $course->name;
        $this->description = $course->description;
        $this->first = $course->first;
        $this->previous_course = $course->previous_course;
        $this->next_course = $course->next_course;
        $this->duration = $course->duration;
        $this->start_date = $course->start_date;
        $this->end_date = $course->end_date;
        $this->points = $course->points;
        $this->required_points = $course->required_points;
        $this->reminder_message = $course->reminder_message;
        $this->reminder_message_date = $course->reminder_message_date;
        $this->reminder_message_mean = $course->reminder_message_mean;
        $this->congratulation_message = $course->congratulation_message;
        $this->congratulation_message_date = $course->congratulation_message_date;
        $this->congratulation_message_mean = $course->congratulation_message_mean;
    }

    public function update()
    {

        $this->validate([
            'name' => [
                'required',
                function ($attribute, $value, $fail) {
                    $existingCourse = Course::where('name', $value)
                        ->where('step_id', $this->stepId)
                        ->where('id', '!=', $this->courseId) //
                        ->first();
                    if ($existingCourse) {
                        $fail('El nombre del curso ya existe en este paso.');
                    }
                },
            ],
            'description' => 'required',
            'first' => 'required|in:0,1',
            'previous_course' => 'nullable|exists:courses,id',
            'next_course' => 'nullable|exists:courses,id',
            'duration' => 'required|integer',
            'start_date' => 'required|date', //|after_or_equal:today
            'end_date' => 'required|after_or_equal:start_date',
            'points' => 'required|integer',
            'required_points' => 'integer|nullable',
            'reminder_message' => 'nullable',
            'reminder_message_date' => 'nullable|date|after_or_equal:today',
            'reminder_message_mean' => 'nullable',
            'congratulation_message' => 'nullable',
            'congratulation_message_date' => 'nullable|date|after_or_equal:today',
            'congratulation_message_mean' => 'nullable',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
            'first' => 'primero',
            'previous_course' => 'curso_anterior',
            'next_course' => 'siguiente_curso',
            'duration' => 'duración',
            'start_date' => 'fecha de inicio',
            'end_date' => 'fecha final',
            'points' => 'puntos',
            'required_points' => 'puntos requeridos',
            'reminder_message' => 'Mensaje recordatorio',
            'reminder_message_date' => 'Fecha Mensaje recordatorio',
            'reminder_message_mean' => 'Medio Mensaje recordatorio',
            'congratulation_message' => 'Mensaje felicitacion',
            'congratulation_message_date' => 'Fecha Mensaje felicitacion',
            'congratulation_message_mean' => 'Medio Mensaje felicitacion',
        ]);

        $course = Course::find($this->courseId);
        $course->name = $this->name;
        $course->description = $this->description;
        $course->first = $this->first;
        $course->previous_course = $this->previous_course !== '' ? $this->previous_course : null;
        $course->next_course = $this->next_course !== '' ? $this->next_course : null;
        $course->duration = $this->duration;
        $course->start_date = $this->start_date;
        $course->end_date = $this->end_date;
        $course->points = $this->points ?:0;
        $course->required_points = $this->required_points ?: 0;
        $course->reminder_message = $this->reminder_message;
        $course->reminder_message_date = $this->reminder_message_date ?: null;
        $course->reminder_message_mean = $this->reminder_message_mean;
        $course->congratulation_message = $this->congratulation_message;
        $course->congratulation_message_date = $this->congratulation_message_date ?: null;
        $course->congratulation_message_mean = $this->congratulation_message_mean;
        $course->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Curso actualizado correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->courseId = $id;
    }

    public function destroy()
    {
        $course = Course::find($this->courseId);
        $course->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Curso eliminado correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->courseId = '';
        $this->first = 0;
        $this->previous_course = '';
        $this->next_course = '';
        $this->duration = '';
        $this->start_date = '';
        $this->end_date = '';
        $this->points = '';
        $this->required_points = '';
        $this->reminder_message = '';
        $this->reminder_message_date = '';
        $this->reminder_message_mean = '';
        $this->congratulation_message = '';
        $this->congratulation_message_date = '';
        $this->congratulation_message_mean = '';
        $this->courseId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
