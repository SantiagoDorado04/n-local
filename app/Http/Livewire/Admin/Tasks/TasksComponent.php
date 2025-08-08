<?php

namespace App\Http\Livewire\Admin\Tasks;

use App\Agent;
use App\Contact;
use App\TasksType;
use App\Models\User;
use App\TasksContact;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TasksComponent extends Component
{
    //List events
    public $events,
        $event;

    //Vars Calendar
    public $date,
        $allDay;

    //Vars event
    public $taskDate,
        $taskTime,
        $agentId,
        $contactId,
        $taskId,
        $taskDescription,
        $taskObservations,
        $duration,
        $durationH,
        $durationM;

    public $filterAgent = 'all';

    public function render()
    {
        $contacts = Contact::all();
        $taskTypes = TasksType::all();
        $contacts = Contact::all();

        $agents = User::where('role_id', '=', '3')->get();


        //List evenrs
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
            ->leftjoin('tasks_types', 'tasks_types.id', '=', 'tasks_contacts.task_id')
            ->leftjoin('contacts', 'contacts.id', '=', 'tasks_contacts.contact_id')
            ->when($this->filterAgent, function ($query, $filterAgent) {

                if ($filterAgent == 'all') {
                    return $query;
                } else {
                    return $query->where('assigned_to', '=', $filterAgent);
                }
            })
            ->get()->toArray();

            /* dd( $this->events); */

        return view('livewire.admin.tasks.tasks-component', [
            'contacts' => $contacts,
            'agents' => $agents,
            'taskTypes' => $taskTypes,
            'contacts' => $contacts
        ]);
    }

    //Create Event
    public function store()
    {
        $this->validate([
            'taskDate' => 'required',
            'taskTime' => 'required',
            'agentId' => 'required',
            'taskId' => 'required',
            'duration' => 'required'
        ], [], [
            'taskDate' => 'fecha',
            'taskTime' => 'hora',
            'agentId' => 'responsable',
            'taskId' => 'tarea',
            'duration' => 'duración'
        ]);

        $task = new TasksContact();
        $task->task_id = $this->taskId;
        $task->assigned_to = $this->agentId;
        $task->contact_id = $this->contactId;
        $task->status = 'assigned';
        $task->task_date_start = $this->taskDate;
        $task->task_time_start = $this->taskTime;
        $task->duration = $this->duration;
        $task->task_observations = $this->taskObservations;
        $task->assigned_by = Auth::user()->id;
        $task->save();

        $this->resetEvents();
        $this->emit('alert', ['type' => 'success', 'message' => 'Actividad asignada correctamente']);
        $this->cancel();
    }

    //Get Info Event
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

        $this->agentId = $this->event->assigned_to;
        $this->contactId = $this->event->contact_id;
        $this->taskId = $this->event->task_id;

        $this->taskObservations = $this->event->task_observations;
        $this->taskDate = $this->event->task_date_start;
        $this->taskTime = $this->event->task_time_start;
        $this->duration = $this->event->duration;
        $this->durationM = $this->event->duration;
        $this->updatedDurationM();

        $this->updatedTaskId();
    }

    public function update()
    {
        $this->validate([
            'taskDate' => 'required',
            'taskTime' => 'required',
            'agentId' => 'required',
            'taskId' => 'required',
            'duration' => 'required'
        ], [], [
            'taskDate' => 'fecha',
            'taskTime' => 'hora',
            'agentId' => 'responsable',
            'taskId' => 'tarea',
            'duration' => 'duración'
        ]);

        $task = TasksContact::find($this->event->id);
        $task->task_id = $this->taskId;
        $task->assigned_to = $this->agentId;
        $task->contact_id = $this->contactId;
        $task->status = 'assigned';
        $task->task_date_start = $this->taskDate;
        $task->task_time_start = $this->taskTime;
        $task->duration = $this->duration;
        $task->task_observations = $this->taskObservations;
        $task->assigned_by = Auth::user()->id;
        $task->update();

        $this->resetEvents();
        $this->emit('alert', ['type' => 'success', 'message' => 'Actividad modificada correctamente']);
        $this->cancel();
    }

    //Close show modal - open edit modal
    public function editEvent()
    {
        $this->emit('select2');
        $this->emit('close-modal');
        $this->emit('open-edit-modal');
    }


    //Get time from calendar and hour if exists
    public function updatedDate()
    {
        if ($this->date != '') {
            $dateC = date('H:i:s', strtotime($this->date));
            if ($dateC != '00:00:00') {
                $this->taskDate = date('Y-m-d', strtotime($this->date));
                $this->taskTime = date('H:i:s', strtotime($this->date));
            } else {
                $this->taskDate = date('Y-m-d', strtotime($this->date));
                $this->taskTime = '';
            }
        } else {
            $this->allDay = '';
            $this->date = '';
            $this->taskDate = '';
            $this->taskTime = '';
        }
    }

    //Get task description 
    public function updatedTaskId()
    {
        if ($this->taskId != '') {
            $task = TasksType::find($this->taskId);
            $this->taskDescription = $task->description;
        } else {
            $this->taskDescription = '';
        }
    }

    //Calculate duration
    public function updatedDurationM()
    {
        if ($this->durationM != '') {
            $this->durationH = round(($this->durationM / 60), 2);
            $this->duration = $this->durationM;
        } else {
            $this->durationM = '';
            $this->durationH = '';
            $this->duration = '';
        }
    }

    //Calculate duration
    public function updatedDurationH()
    {
        if ($this->durationH != '') {
            $this->durationM = (($this->durationH) * 60) / 1;
            $this->duration = $this->durationM;
        } else {
            $this->durationM = '';
            $this->durationH = '';
            $this->duration = '';
        }
    }

    //Reset Calendar if filter by agent
    public function updatedFilterAgent()
    {
        $this->resetEvents();
    }

    //Reset list events
    public function resetEvents()
    {
        $this->events = TasksContact::select(
            'tasks_contacts.id',
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
            ->leftjoin('tasks_types', 'tasks_types.id', '=', 'tasks_contacts.task_id')
            ->leftjoin('contacts', 'contacts.id', '=', 'tasks_contacts.contact_id')
            ->when($this->filterAgent, function ($query, $filterAgent) {

                if ($filterAgent == 'all') {
                    return $query;
                } else {
                    return $query->where('assigned_to', '=', $filterAgent);
                }
            })
            ->get()->toArray();

        $this->dispatchBrowserEvent('clearEventCalendar', ['refresh' => true]);
        $this->dispatchBrowserEvent('refreshEventCalendar', ['refresh' => true]);
    }

    public function resetInputFields()
    {
        $this->allDay = '';
        $this->date = '';
        $this->taskDate = '';
        $this->taskTime = '';
        $this->taskId = '';
        $this->taskDescription = '';
        $this->durationM = '';
        $this->durationH = '';
        $this->duration = '';
        $this->duration = '';
        $this->agentId = '';
        $this->taskObservations = '';
        $this->contactId;
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }

    public function hydrate()
    {
        $this->emit('select2');
    }
}
