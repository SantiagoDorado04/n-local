<?php

namespace App\Events;

use App\Models\ContactsStage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContactsStageCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $contactsStage;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ContactsStage $contactsStage)
    {
        $this->contactsStage = $contactsStage;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
