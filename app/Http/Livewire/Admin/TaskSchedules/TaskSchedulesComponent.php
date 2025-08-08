<?php

namespace App\Http\Livewire\Admin\TaskSchedules;

/* php artisan make:livewire Admin/TaskSchedules/TaskSchedulesComponent */

use App\Agent;
use App\TasksContact;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TaskSchedulesComponent extends Component
{
    public $events,
        $event;

    public $dateCompleted, $timeCompleted, $observationsCompleted;

    public function render()
    {

        $this->events = TasksContact::select(
            'tasks_contacts.id as id',
            DB::raw('TIMESTAMP(task_date_start, task_time_start) as start'),
            DB::raw(DB::raw('TIMESTAMP(task_date_start, task_time_start)') . '+ INTERVAL duration MINUTE  as end'),
            DB::raw('CONCAT(contacts.name, \' -  \', tasks_types.title) AS title'),
            DB::raw('CASE  
            WHEN status = "assigned" AND TIMESTAMP(task_date_start, task_time_start) < CURRENT_TIMESTAMP then "#d9534f"
            WHEN status = "assigned" AND TIMESTAMP(task_date_start, task_time_start) >= CURRENT_TIMESTAMP then "#5bc0de"
            WHEN status = "completed" THEN "#5cb85c"
            END as color'),
            'tasks_contacts.status',
        )
            ->leftjoin('agents', 'agents.id', '=', 'tasks_contacts.assigned_to')
            ->leftjoin('tasks_types', 'tasks_types.id', '=', 'tasks_contacts.task_id')
            ->leftjoin('contacts', 'contacts.id', '=', 'tasks_contacts.contact_id')
            ->where('assigned_to', '=', Auth::user()->id)
            ->get()->toArray();
            
        return view('livewire.admin.task-schedules.task-schedules-component');
    }

    public function getEvent($id)
    {

        $this->event = TasksContact::select(
            'tasks_contacts.id',
            'contacts.nit',
            'contacts.name',
            'contacts.phone',
            'contacts.email',
            'contacts.whatsapp',
            'contacts.contact_person_name',
            'contacts.name as contact_name',
            'tasks_contacts.contact_id',
            'tasks_contacts.assigned_to',
            'tasks_contacts.task_id',
            'tasks_contacts.task_observations',
            'tasks_contacts.task_date_start',
            'tasks_contacts.task_time_start',
            'tasks_contacts.duration',
            'tasks_contacts.status',
            'tasks_contacts.task_date_completed',
            'tasks_contacts.task_time_completed',
            'tasks_contacts.task_observations_completed',
            'users.name as agent_name',
            'tasks_types.title as task_title',
            'tasks_types.description as task_description',
        )
            ->leftjoin('agents', 'agents.id', '=', 'tasks_contacts.assigned_to')
            ->leftjoin('users', 'users.id', '=', 'agents.user_id')
            ->leftjoin('tasks_types', 'tasks_types.id', '=', 'tasks_contacts.task_id')
            ->leftjoin('contacts', 'contacts.id', '=', 'tasks_contacts.contact_id')
            ->where('tasks_contacts.id', '=', $id)
            ->first();
    }

    //Close show modal - open edit modal
    public function editEvent()
    {
        $this->emit('select2');
        $this->emit('close-modal');
        $this->emit('open-edit-modal');
    }

    public function update()
    {
        $this->validate([
            'dateCompleted' => 'required',
            'timeCompleted' => 'required',
            'observationsCompleted' => 'required',
        ], [], [
            'dateCompleted' => 'fecha finalización',
            'timeCompleted' => 'hora finzalización',
            'observationsCompleted' => 'observaciones finzalización',
        ]);

        $event = TasksContact::find($this->event->id);
        $event->task_date_completed = $this->dateCompleted;
        $event->task_time_completed = $this->timeCompleted;
        $event->task_observations_completed = $this->observationsCompleted;
        $event->status = 'completed';
        $event->update();

        $this->resetEvents();
        $this->emit('alert', ['type' => 'success', 'message' => 'Actividad actualizada correctamente']);
        $this->cancel();
    }
    //Reset list events
    public function resetEvents()
    {
        $agent = Agent::where('user_id', '=', Auth::user()->id)->first();

        $this->events = TasksContact::select(
            'tasks_contacts.id as id',
            DB::raw('TIMESTAMP(task_date_start, task_time_start) as start'),
            DB::raw(DB::raw('TIMESTAMP(task_date_start, task_time_start)') . '+ INTERVAL duration MINUTE  as end'),
            DB::raw('CONCAT(contacts.name, \' -  \', tasks_types.title) AS title'),
            DB::raw('CASE  
            WHEN status = "assigned" AND TIMESTAMP(task_date_start, task_time_start) < CURRENT_TIMESTAMP then "#d9534f"
            WHEN status = "assigned" AND TIMESTAMP(task_date_start, task_time_start) >= CURRENT_TIMESTAMP then "#5bc0de"
            WHEN status = "completed" THEN "#5cb85c"
            END as color'),
            'tasks_contacts.status',
        )
            ->leftjoin('agents', 'agents.id', '=', 'tasks_contacts.assigned_to')
            ->leftjoin('tasks_types', 'tasks_types.id', '=', 'tasks_contacts.task_id')
            ->leftjoin('contacts', 'contacts.id', '=', 'tasks_contacts.contact_id')
            ->where('assigned_to', '=', $agent->id)
            ->get()->toArray();

        $this->dispatchBrowserEvent('clearEventCalendar', ['refresh' => true]);
        $this->dispatchBrowserEvent('refreshEventCalendar', ['refresh' => true]);
    }

    public function resetInputFields()
    {
        $this->dateCompleted = '';
        $this->timeCompleted = '';
        $this->observationsCompleted = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
