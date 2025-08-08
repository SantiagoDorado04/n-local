<?php

namespace App\Http\Livewire\Admin\PresentialActivities;

use App\Models\PresentialActivity;
use App\Models\Step;
use Livewire\Component;
use Livewire\WithPagination;

class PresentialActivitiesComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';


    public $name,
        $date,
        $hour,
        $location,
        $facilitator,
        $duration,
        $registration_link,
        $event_type,
        $virtual_link,
        $activityId,
        $points,
        $required_points,
        $cancellation_deadline,
        $reminder_message,
        $reminder_message_date,
        $reminder_message_mean,
        $congratulation_message,
        $congratulation_message_date,
        $congratulation_message_mean
        ;

    public $step_id;

    public $searchName;

    public function mount($id)
    {
        $this->step_id = $id;
    }

    public function render()
    {
        $presentialActivities = PresentialActivity::when($this->searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })
            ->where('step_id','=',$this->step_id)
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        $firstItem = $presentialActivities->firstItem();
        $lastItem = $presentialActivities->lastItem();
        $step = Step::find($this->step_id);

        $paginationText = "Mostrando de {$firstItem} a {$lastItem} de {$presentialActivities->total()} registros";

        return view('livewire.admin.presential-activities.presential-activities-component', [
            'presentialActivities' => $presentialActivities,
            'paginationText' => $paginationText,
            'step' => $step
        ]);
    }

    public function show($id)
    {
        $this->activityId = $id;

        $presentialActivity = PresentialActivity::find($id);
        $this->name = $presentialActivity->name;
        $this->date = $presentialActivity->date;
        $this->hour = $presentialActivity->hour;
        $this->location = $presentialActivity->location;
        $this->facilitator = $presentialActivity->facilitator;
        $this->duration = $presentialActivity->duration;
        $this->registration_link = $presentialActivity->registration_link;
        $this->event_type = $presentialActivity->event_type;
        $this->virtual_link = $presentialActivity->virtual_link;
        $this->points = $presentialActivity->points;
        $this->required_points = $presentialActivity->required_points;
        $this->cancellation_deadline = $presentialActivity->cancellation_deadline;
        $this->reminder_message = $presentialActivity->reminder_message;
        $this->reminder_message_date = $presentialActivity->reminder_message_date;
        $this->reminder_message_mean = $presentialActivity->reminder_message_mean;
        $this->congratulation_message = $presentialActivity->congratulation_message;
        $this->congratulation_message_date = $presentialActivity->congratulation_message_date;
        $this->congratulation_message_mean = $presentialActivity->congratulation_message_mean;
    }

    public function store()
    {
        $rules = [
            'name' => [
                'required',
                function ($attribute, $value, $fail) {
                    $existingPresentialActivity = PresentialActivity::where('name', $value)
                        ->where('step_id', $this->step_id)
                        ->where('id', '!=', $this->activityId) //
                        ->first();
                    if ($existingPresentialActivity) {
                        $fail('El nombre de la actividad ya existe en este paso.');
                    }
                },
            ],
            'date' => 'required|date',//|after_or_equal:today
            'hour' => 'required',
            'facilitator' => 'required',
            'duration' => 'required',
            'registration_link' => 'required',
            'event_type' => 'required',
            'points' => 'nullable|numeric|min:1',
            'required_points' => 'nullable|numeric|min:1',
            'cancellation_deadline' => 'nullable|date',
            'reminder_message' => 'nullable',
            'reminder_message_date' => 'nullable|date|after_or_equal:today',
            'reminder_message_mean' => 'nullable',
            'congratulation_message' => 'nullable',
            'congratulation_message_date' => 'nullable|date|after_or_equal:today',
            'congratulation_message_mean' => 'nullable',
        ];

        if ($this->event_type == 'virtual') {
            $rules['virtual_link'] = 'required';
        }

        if ($this->event_type == 'presential') {
            $rules['location'] = 'required';
        }

        $this->validate($rules);

        $presentialActivity = new PresentialActivity();
        $presentialActivity->name = $this->name;
        $presentialActivity->date = $this->date;
        $presentialActivity->hour = $this->hour;
        $presentialActivity->location = $this->location;
        $presentialActivity->facilitator = $this->facilitator;
        $presentialActivity->duration = $this->duration;
        $presentialActivity->registration_link = $this->registration_link;
        $presentialActivity->event_type = $this->event_type;
        $presentialActivity->virtual_link = $this->virtual_link;
        $presentialActivity->points = $this->points;
        $presentialActivity->required_points = $this->required_points ?: null;
        $presentialActivity->cancellation_deadline = $this->cancellation_deadline ?: null;
        $presentialActivity->reminder_message = $this->reminder_message;
        $presentialActivity->reminder_message_date = $this->reminder_message_date ?: null;
        $presentialActivity->reminder_message_mean = $this->reminder_message_mean;
        $presentialActivity->congratulation_message = $this->congratulation_message;
        $presentialActivity->congratulation_message_date = $this->congratulation_message_date ?: null;
        $presentialActivity->congratulation_message_mean = $this->congratulation_message_mean;
        $presentialActivity->step_id = $this->step_id;
        $presentialActivity->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Actividad presencial creada correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->activityId = $id;

        $presentialActivity = PresentialActivity::find($id);

        $this->name = $presentialActivity->name;
        $this->date = $presentialActivity->date;
        $this->hour = $presentialActivity->hour;
        $this->location = $presentialActivity->location;
        $this->facilitator = $presentialActivity->facilitator;
        $this->duration = $presentialActivity->duration;
        $this->registration_link = $presentialActivity->registration_link;
        $this->event_type = $presentialActivity->event_type;
        $this->virtual_link = $presentialActivity->virtual_link;
        $this->points = $presentialActivity->points;
        $this->required_points = $presentialActivity->required_points;
        $this->cancellation_deadline = $presentialActivity->cancellation_deadline;
        $this->reminder_message = $presentialActivity->reminder_message;
        $this->reminder_message_date = $presentialActivity->reminder_message_date;
        $this->reminder_message_mean = $presentialActivity->reminder_message_mean;
        $this->congratulation_message = $presentialActivity->congratulation_message;
        $this->congratulation_message_date = $presentialActivity->congratulation_message_date;
        $this->congratulation_message_mean = $presentialActivity->congratulation_message_mean;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|unique:presential_activities,name,' . $this->activityId,
            'date' => 'required|date',//|after_or_equal:today
            'hour' => 'required',
            'location' => 'required_if:event_type,presential',
            'facilitator' => 'required',
            'duration' => 'required',
            'registration_link' => 'required',
            'event_type' => 'required',
            'virtual_link' => $this->event_type == 'virtual' ? 'required' : '',
            'points' => 'nullable|numeric|min:1',
            'required_points' => 'nullable|numeric|min:1',
            'cancellation_deadline' => 'nullable|date',
            'reminder_message' => 'nullable',
            'reminder_message_date' => 'nullable|date|after_or_equal:today',
            'reminder_message_mean' => 'nullable',
            'congratulation_message' => 'nullable',
            'congratulation_message_date' => 'nullable|date|after_or_equal:today',
            'congratulation_message_mean' => 'nullable',
        ], [], [
            'name' => 'nombre',
            'date' => 'fecha',
            'hour' => 'hora',
            'location' => 'ubicacion',
            'facilitator' => 'facilitador',
            'duration' => 'duracion',
            'registration_link' => 'link de registro',
            'event_type' => 'tipo de evento',
            'virtual_link' => 'link virtual',
            'points' => 'puntos',
            'required_points' => 'puntos requeridos',
            'cancellation_deadline' => 'fecha de cancelacion',
            'reminder_message' => 'Mensaje recordatorio',
            'reminder_message_date' => 'Fecha Mensaje recordatorio',
            'reminder_message_mean' => 'Medio Mensaje recordatorio',
            'congratulation_message' => 'Mensaje felicitacion',
            'congratulation_message_date' => 'Fecha Mensaje felicitacion',
            'congratulation_message_mean' => 'Medio Mensaje felicitacion',
        ]);

        $presentialActivity = PresentialActivity::find($this->activityId);
        $presentialActivity->name = $this->name;
        $presentialActivity->date = $this->date;
        $presentialActivity->hour = $this->hour;
        $presentialActivity->location = $this->location;
        $presentialActivity->facilitator = $this->facilitator;
        $presentialActivity->duration = $this->duration;
        $presentialActivity->registration_link = $this->registration_link;
        $presentialActivity->event_type = $this->event_type;
        $presentialActivity->virtual_link = $this->virtual_link;
        $presentialActivity->points = $this->points;
        $presentialActivity->required_points = $this->required_points ?: null;
        $presentialActivity->cancellation_deadline = $this->cancellation_deadline ?: null;
        $presentialActivity->reminder_message = $this->reminder_message;
        $presentialActivity->reminder_message_date = $this->reminder_message_date ?: null;
        $presentialActivity->reminder_message_mean = $this->reminder_message_mean;
        $presentialActivity->congratulation_message = $this->congratulation_message;
        $presentialActivity->congratulation_message_date = $this->congratulation_message_date ?: null;
        $presentialActivity->congratulation_message_mean = $this->congratulation_message_mean;
        $presentialActivity->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Actividad presencial actualizada correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->activityId = $id;
    }

    public function destroy()
    {
        $presentialActivity = PresentialActivity::find($this->activityId);
        $presentialActivity->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Actividad presencial eliminada correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->date = '';
        $this->hour = '';
        $this->location = '';
        $this->facilitator = '';
        $this->duration = '';
        $this->registration_link = '';
        $this->event_type = '';
        $this->virtual_link = '';
        $this->activityId = '';
        $this->points = '';
        $this->required_points = '';
        $this->cancellation_deadline = '';
        $this->reminder_message = '';
        $this->reminder_message_date = '';
        $this->reminder_message_mean = '';
        $this->congratulation_message = '';
        $this->congratulation_message_date = '';
        $this->congratulation_message_mean = '';
    }

    public function cancel()
    {
        $this->resetInputFields();

        $this->resetErrorBag();
        $this->resetValidation();

        $this->emit('close-modal');
    }
}
