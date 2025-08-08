<?php

namespace App\Http\Livewire\Admin\ContactSchedules;

/* php artisan make:livewire Admin/ContactSchedules/ContactSchedulesComponent */

use App\Contact;
use Livewire\Component;
use App\ContactsSchedule;

class ContactSchedulesComponent extends Component
{
    public $contact, $schedule;

    public $scheduleId;

    //Vars schedule
    public $status,
        $date_contact,
        $time_contact,
        $observations;

    //Get two lists for diferent tabs
    public function render()
    {
        $user = Auth()->user()->id;

        $pendingTasks = ContactsSchedule::select(
            'contacts_schedules.id as schedule_id',
            'contacts_schedules.contact_id as contact_id',
            'contacts_schedules.assigned_by',
            'contacts_schedules.priority',
            'contacts_schedules.date_to_contact',
            'contacts_schedules.time_to_contact',
            'contacts_schedules.date_contact',
            'contacts_schedules.time_contact',
            'contacts.nit as contact_nit',
            'contacts.name as contact_name',
            'contacts.email as contact_email',
            'contacts.phone as contact_phone',
        )
            ->leftjoin('contacts', 'contacts.id', 'contacts_schedules.contact_id')
            ->where('contacts_schedules.user_id', '=', $user)
            ->whereNull('contacts_schedules.date_contact')
            ->get();

        $completedTasks = ContactsSchedule::select(
            'contacts_schedules.id as schedule_id',
            'contacts_schedules.contact_id as contact_id',
            'contacts_schedules.assigned_by',
            'contacts_schedules.priority',
            'contacts_schedules.date_to_contact',
            'contacts_schedules.time_to_contact',
            'contacts_schedules.date_contact',
            'contacts_schedules.time_contact',
            'contacts.nit as contact_nit',
            'contacts.name as contact_name',
            'contacts.email as contact_email',
            'contacts.phone as contact_phone',
        )
            ->leftjoin('contacts', 'contacts.id', 'contacts_schedules.contact_id')
            ->where('contacts_schedules.user_id', '=', $user)
            ->where('contacts_schedules.status', '=', 'completed')
            ->get();

        return view('livewire.admin.contact-schedules.contact-schedules-component', [
            'completedTasks' => $completedTasks,
            'pendingTasks' => $pendingTasks
        ]);
    }

    public function edit($id)
    {
        //Get schedule for update
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

    public function getContact($id)
    {
        //Get info contact
        $this->contact = Contact::find($id);
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
