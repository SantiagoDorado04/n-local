<?php

namespace App\Http\Livewire\Admin\MessageManagement;


use App\CommercialLand;
use Livewire\Component;
use App\MessageTemplate;
use App\CommercialAction;
use App\CommercialStrategy;
use GuzzleHttp\Psr7\Message;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MessageManagementComponent extends Component
{

    use AuthorizesRequests;

    public $title,
        $message,
        $messageId;

    public $strategy,
        $land,
        $action;

    public $lands, $strategies, $actions;
    public $landId, $strategyId, $actionId;

    public $searchTitle, $searchType;

    public function mount($action = NULL)
    {
        //Lists dropdowns filter
        $this->lands = CommercialLand::all();
        $this->strategies = collect();
        $this->actions = collect();
    }

    public function render()
    {
        $messages = MessageTemplate::select(
            'message_templates.*',
            'commercial_actions.id as commercial_action_id',
            'commercial_actions.name as commercial_action_name',
            'commercial_strategies.id as commercial_strategy_id',
            'commercial_strategies.name as commercial_strategy_name',
            'commercial_lands.id as commercial_land_id',
            'commercial_lands.name as commercial_land_name',
        )
            ->leftjoin('commercial_actions', 'commercial_actions.id', '=', 'message_templates.commercial_action_id')
            ->leftjoin('commercial_strategies', 'commercial_strategies.id', '=', 'commercial_actions.commercial_strategy_id')
            ->leftjoin('commercial_lands', 'commercial_lands.id', '=', 'commercial_strategies.commercial_land_id')
            ->when($this->searchTitle, function ($query, $searchTitle) {
                return $query->where('title', 'like', '%' . $searchTitle . '%');
            })
            ->when($this->searchType, function ($query, $searchType) {
                switch ($searchType) {
                    case 'g':
                        return $query->whereNull('message_templates.commercial_action_id');
                        break;
                    case 'a':
                        return $query->whereNotNull('message_templates.commercial_action_id');
                        break;
                    default:
                        return $query;
                        break;
                }
            })
            ->when($this->actionId, function ($query, $actionId) {
                return $query->where('commercial_action_id', '=',  $actionId);
            })
            ->when($this->strategyId, function ($query, $strategyId) {
                return $query->where('commercial_strategy_id', '=',  $strategyId);
            })
            ->when($this->landId, function ($query, $landId) {
                return $query->where('commercial_land_id', '=',  $landId);
            })
            ->get();
        return view('livewire.admin.message-management.message-management-component', [
            'messages' => $messages
        ]);
    }

    public function show($id)
    {
        $this->messageId = $id;

        $message = MessageTemplate::find($id);
        $this->title = $message->title;
        $this->message = $message->message;
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
        $message->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Mensaje creado correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {

        $this->messageId = $id;

        $message = MessageTemplate::find($id);
        $this->title = $message->title;
        $this->message = $message->message;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|unique:message_templates,title,' . $this->messageId,
            'message' => 'required',
        ], [], [
            'title' => 'nombre',
            'message' => 'descripción',
        ]);

        $message = MessageTemplate::find($this->messageId);
        $message->title = $this->title;
        $message->message = $this->message;
        $message->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Mensaje actualizado correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->messageId = $id;
    }

    public function destroy()
    {
        $land = MessageTemplate::find($this->messageId);
        $land->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Mensaje eliminado correctamente']);
        $this->cancel();
    }

    /**
     * If the land id is not empty, then get all the strategies that have that land id
     * 
     * @param land The id of the land that was selected.
     */
    public function updatedLandId($land)
    {
        if ($land != '') {
            $this->strategies = CommercialStrategy::where('commercial_land_id', '=', $land)->get();
        } else {
            $this->searchType='';
            $this->strategies = collect();
            $this->actions = collect();
            $this->landId = '';
            $this->strategyId = '';
            $this->actionId = '';
        }
    }

    /**
     * If the strategy is not empty, then get all the actions that belong to that strategy. Otherwise,
     * set the actions to an empty collection and set the strategy and action ids to empty strings
     * 
     * @param strategy The strategy id
     */
    public function updatedStrategyId($strategy)
    {
        if ($strategy != '') {
            $this->actions = CommercialAction::where('commercial_strategy_id', '=', $strategy)->get();
        } else {
            $this->actions = collect();
            $this->strategyId = '';
            $this->actionId = '';
        }
    }

    public function updatedSearchType($id){
        if($id=='g'){
            $this->strategies = collect();
            $this->actions = collect();
            $this->landId = '';
            $this->strategyId = '';
            $this->actionId = '';
        }
    }


    public function resetInputFields()
    {
        $this->title = '';
        $this->message = '';
        $this->messageId = '';
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
