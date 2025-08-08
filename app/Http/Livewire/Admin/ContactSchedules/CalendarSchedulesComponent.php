<?php

namespace App\Http\Livewire\Admin\ContactSchedules;

use DateTime;
use DateInterval;
use Livewire\Component;
use App\ContactsSchedule;

class CalendarSchedulesComponent extends Component
{
    //Vars schedule for calendar
    public $events = '', $scheduleId, $schedule;

    //Vars schedules
    public $status,
        $date_contact,
        $time_contact,
        $observations;

    //Listeners actions calendar
    public $listeners = [
        'editSchedule' => 'editSchedule',
        'getSchedule' => 'getSchedule'
    ];

    //Get schedules, convert to array for calendar
    public function render()
    {
        $schedules = ContactsSchedule::select(
            'contacts_schedules.*',
            'contacts.name as name_contact'
        )
            ->join('contacts', 'contacts.id', '=', 'contacts_schedules.contact_id')
            ->where('user_id', '=', '2')->get();

        $array = [];

        foreach ($schedules as $schedule) {

            //Convert date and time
            $date = new DateTime($schedule->date_to_contact . " " . $schedule->time_to_contact);
            $date = $date->format('Y-m-d H:i:s');

            $dateEnd = new DateTime($schedule->date_to_contact . " " . $schedule->time_to_contact);
            $dateEnd = $dateEnd->add(new DateInterval('PT20M'));
            $dateEnd = $dateEnd->format('Y-m-d H:i:s');


            $color = '';
            //Colors for status
            switch ($schedule->status) {
                case 'assigned':
                    $color = '#84b6f4';
                    break;
                case 'completed':
                    $color = '#77dd77';
                    break;
                default:
                    break;
            }

            $array[] = [
                "schedule_id" => $schedule->id,
                "status" => $schedule->status,
                "title" => $schedule->name_contact,
                "start" => $date,
                "end" => $dateEnd,
                "color" => $color
            ];
        }

        $this->events = $array;

        return view('livewire.admin.contact-schedules.calendar-schedules-component');
    }


    public function editSchedule($id)
    {
        //Get schedule of calendar for update status

        $this->scheduleId = $id;
        $this->schedule = ContactsSchedule::find($this->scheduleId);
    }

    public function update()
    {
        //update schedule, completed
        $schedule = ContactsSchedule::find($this->scheduleId);
        $schedule->date_contact = $this->date_contact;
        $schedule->time_contact = $this->time_contact;
        $schedule->observations_user = $this->observations;
        $schedule->status = $this->status;
        $schedule->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Contacto actualizado correctamente']);
        $this->cancel();
    }

    public function getSchedule($id)
    {
         //Get schedule if is completed
        $this->scheduleId = $id;
        $this->schedule = ContactsSchedule::find($this->scheduleId);
    }


    public function resetInputFields()
    {
        $this->date_contact = '';
        $this->time_contact = '';
        $this->observations = '';
        $this->status = '';
        $this->scheduleId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
