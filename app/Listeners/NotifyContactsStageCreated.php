<?php

namespace App\Listeners;

use App\Contact;
use App\Notification;
use App\Events\ContactsStageCreated;
use App\Models\Process;
use App\Models\Stage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyContactsStageCreated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ContactsStageCreated $event)
    {
        $contact = Contact::find($event->contactsStage->contact_id);
        $stage = Stage::find($event->contactsStage->stage_id);
        $process = Process::find($stage->process_id);
        
        $text = 'Nuevo postulado: <strong>"' . $contact->name . '"</strong>, etapa <strong>"' . $stage->name . '"</strong> del proceso <strong>"' . $process->name . '"</strong>.';
        Notification::create([
            'message' => $text
        ]);
    }
}
