<?php

namespace App\Observers;

use App\Models\ContactsStage;
use App\Events\ContactsStageCreated;

class ContactsStageObserver
{
    /**
     * Handle the ContactsStage "created" event.
     *
     * @param  \App\Models\ContactsStage  $contactsStage
     * @return void
     */
    public function created(ContactsStage $contactsStage)
    {
        event(new ContactsStageCreated($contactsStage));
    }

    /**
     * Handle the ContactsStage "updated" event.
     *
     * @param  \App\Models\ContactsStage  $contactsStage
     * @return void
     */
    public function updated(ContactsStage $contactsStage)
    {
        //
    }

    /**
     * Handle the ContactsStage "deleted" event.
     *
     * @param  \App\Models\ContactsStage  $contactsStage
     * @return void
     */
    public function deleted(ContactsStage $contactsStage)
    {
        //
    }

    /**
     * Handle the ContactsStage "restored" event.
     *
     * @param  \App\Models\ContactsStage  $contactsStage
     * @return void
     */
    public function restored(ContactsStage $contactsStage)
    {
        //
    }

    /**
     * Handle the ContactsStage "force deleted" event.
     *
     * @param  \App\Models\ContactsStage  $contactsStage
     * @return void
     */
    public function forceDeleted(ContactsStage $contactsStage)
    {
        //
    }
}
