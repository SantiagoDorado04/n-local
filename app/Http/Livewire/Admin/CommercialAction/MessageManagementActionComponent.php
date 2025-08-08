<?php

namespace App\Http\Livewire\Admin\CommercialAction;


use App\CommercialLand;
use App\MessageTemplate;
use App\CommercialAction;
use App\CommercialStrategy;
use App\Http\Livewire\Admin\MessageManagement\MessageManagementComponent;

class MessageManagementActionComponent extends MessageManagementComponent
{
    public $strategy,
        $land,
        $action;

    public function mount($action= NULL)
    {
        $this->action = CommercialAction::find($action);
        $this->strategy = CommercialStrategy::find($this->action->commercial_strategy_id);
        $this->land = CommercialLand::find($this->strategy->commercial_land_id);
    }
    public function render()
    {
        $messages = MessageTemplate::when($this->searchTitle, function ($query, $searchTitle) {
            return $query->where('title', 'like', '%' . $searchTitle . '%');
        })
        ->where('commercial_action_id','=', $this->action->id)
        ->get();
        return view('livewire.admin.message-management.message-management-component', [
            'messages' => $messages
        ]);
    }

    public function store()
    {
        $this->validate([
            'title' => 'required|unique:message_templates,title',
            'message' => 'required',
        ], [], [
            'title' => 'nombre',
            'message' => 'descripción',
        ]);

        $message = new MessageTemplate();
        $message->title = $this->title;
        $message->message = $this->message;
        $message->commercial_action_id=$this->action->id;
        $message->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Mensaje creado correctamente']);
        $this->cancel();
    }
}
