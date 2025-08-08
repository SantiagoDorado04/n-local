<?php

namespace App\Http\Livewire\Admin\Meetings;

use App\Contact;
use App\Meeting;
use Carbon\Carbon;
use Livewire\Component;
use Spatie\GoogleCalendar\Event;
use Illuminate\Support\Facades\DB;


class MeetingsComponent extends Component
{

    public $contactId,
        $meetDate,
        $meetTime,
        $meetId,
        $meetTitle,
        $durationM,
        $durationH,
        $duration,
        $url;

    //List events
    public $events,
        $event;

    //Vars Calendar
    public $date,
        $allDay;

    public function render()
    {
        $contacts = Contact::all();
        $this->events = Meeting::select(
            'meetings.id as id',
            DB::raw('TIMESTAMP(meeting_date_start, meeting_time_start) as start'),
            DB::raw(DB::raw('TIMESTAMP(meeting_date_start, meeting_time_start)') . '+ INTERVAL duration MINUTE  as end'),
            DB::raw('CONCAT(contacts.name, \' -  \', meetings.title) AS title'),
            DB::raw('CASE  
            WHEN TIMESTAMP(meeting_date_start, meeting_time_start) < CURRENT_TIMESTAMP then "#d9534f"
            WHEN TIMESTAMP(meeting_date_start, meeting_time_start) >= CURRENT_TIMESTAMP then "#5bc0de"
            END as color'),
        )
            ->leftjoin('contacts', 'contacts.id', '=', 'meetings.contact_id')
            ->get()->toArray();


        return view('livewire.admin.meetings.meetings-component', [
            'contacts' => $contacts,
        ]);
    }

    public function store()
    {
        $this->validate([
            'contactId' => 'required',
            'meetTitle' => 'required',
            'meetDate' => 'required',
            'meetTime' => 'required',
            'duration' => 'required|numeric|min:1'
        ], [], [
            'contactId' => 'contacto',
            'meetTitle' => 'título',
            'meetDate' => 'fecha',
            'meetTime' => 'hora',
            'duration' => 'duración'
        ]);

        $meeting =  new Meeting();
        $meeting->contact_id = $this->contactId;
        $meeting->title = $this->meetTitle;
        $meeting->meeting_date_start     = $this->meetDate;
        $meeting->meeting_time_start = $this->meetTime;
        $meeting->duration = $this->duration;
        $meeting->url = $this->url;
        $meeting->save();

        $this->resetEvents();
        $this->emit('alert', ['type' => 'success', 'message' => 'Agendamiento agregado correctamente']);
        $this->cancel();
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

    //Reset list events
    public function resetEvents()
    {
        $this->events = Meeting::select(
            'meetings.id as id',
            DB::raw('TIMESTAMP(meeting_date_start, meeting_time_start) as start'),
            DB::raw(DB::raw('TIMESTAMP(meeting_date_start, meeting_time_start)') . '+ INTERVAL duration MINUTE  as end'),
            DB::raw('CONCAT(contacts.name, \' -  \', meetings.title) AS title'),
            DB::raw('CASE  
            WHEN TIMESTAMP(meeting_date_start, meeting_time_start) < CURRENT_TIMESTAMP then "#d9534f"
            WHEN TIMESTAMP(meeting_date_start, meeting_time_start) >= CURRENT_TIMESTAMP then "#5bc0de"
            END as color'),
        )
            ->leftjoin('contacts', 'contacts.id', '=', 'meetings.contact_id')
            ->get()->toArray();

            $this->dispatchBrowserEvent('clearEventCalendar', ['refresh' => true]);
            $this->dispatchBrowserEvent('refreshEventCalendar', ['refresh' => true]);
    }
    public function resetInputFields()
    {
        $this->allDay = '';
        $this->date = '';
        $this->meetDate = '';
        $this->meetTime = '';
        $this->meetId = '';
        $this->meetTitle = '';
        $this->durationM = '';
        $this->durationH = '';
        $this->duration = '';
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
