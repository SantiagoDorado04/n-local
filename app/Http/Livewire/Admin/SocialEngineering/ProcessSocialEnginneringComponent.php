<?php

namespace App\Http\Livewire\Admin\SocialEngineering;

use App\Contact;
use App\CommercialLand;
use App\SocialQuestion;
use Livewire\Component;
use App\CommercialAction;
use App\CommercialStrategy;
use App\SocialEngineeringAnswers;
use Illuminate\Support\Facades\DB;

class ProcessSocialEnginneringComponent extends Component
{

    public $searchName, $searchStorage, $searchRate, $searchStart, $searchEnd;

    public $gQuestions, $aQuestions;

    public $process;

    public $lands, $strategies, $actions;
    public $landId, $strategyId, $actionId;

    public $contactId;

    public function mount()
    {
        $this->gQuestions = SocialQuestion::whereNull('commercial_action_id')->get();

        //Lists dropdowns filter
        $this->lands = CommercialLand::all();
        $this->strategies = collect();
        $this->actions = collect();
    }

    public function render()
    {
        $contacts = Contact::select(
            'contacts.*',
            'contacts.id as contact_id',
            'commercial_form_actions.id as commercial_form_action_id',
            'commercial_actions.id as commercial_action_id',
            'commercial_actions.name as commercial_action_name',
            'commercial_forms.id as commercial_form_id',
            'commercial_forms.name as commercial_form_name',
            'commercial_strategies.id as commercial_strategy_id',
            'commercial_strategies.name as commercial_strategy_name',
            'commercial_lands.id as commercial_land_id',
            'commercial_lands.name as commercial_land_name',
            'contacts_schedules.id as schedule_id',
            'contacts_schedules.user_id as schedule_user',
            'contacts_schedules.status as schedule_status',
            'social_engineering_answers.id as process_id'
        )
            ->leftjoin('commercial_forms', 'commercial_forms.id', '=', 'contacts.commercial_form_id')
            ->leftjoin('commercial_actions', 'commercial_actions.id', '=', 'contacts.commercial_action_id')
            ->leftjoin('commercial_strategies', 'commercial_strategies.id', '=', 'commercial_actions.commercial_strategy_id')
            ->leftjoin('commercial_lands', 'commercial_lands.id', '=', 'commercial_strategies.commercial_land_id')
            ->leftjoin('commercial_form_actions', 'commercial_form_actions.id', '=', 'contacts.form_action_id')
            ->leftjoin('contacts_schedules', 'contacts_schedules.contact_id', '=', 'contacts.id')
            ->leftjoin('social_engineering_answers','social_engineering_answers.contact_id','=','contacts.id')
            ->when($this->searchName, function ($query, $searchName) {
                return $query->where('contacts.name', 'like', '%' . $searchName . '%');
            })
            ->when($this->searchStorage, function ($query, $searchStorage) {
                return $query->where('contacts.storage', '=', $searchStorage);
            })
            ->when($this->searchRate, function ($query, $searchRate) {
                return $query->where('contacts.rate', '=', $searchRate);
            })
            ->when($this->searchStart, function ($query, $searchStart) {
                if ($this->searchEnd != '') {
                    return $query->whereBetween('contacts.created_at', [$searchStart, $this->searchEnd]);
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
            ->orderBy('contacts.created_at', 'desc')
            ->get();
        return view('livewire.admin.social-engineering.process-social-enginnering-component', [
            'contacts' => $contacts
        ]);
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

    public function create($id)
    {
        $contact = Contact::find($id);
        $this->contactId = $contact->id;

        $action = $contact->commercial_action_id;

        if ($action != '') {
            $this->aQuestions = SocialQuestion::where('commercial_action_id', '=', $action)->get();
        }
    }

    public function submit($formData)
    {
        $errors = $this->getErrorBag();

        foreach ($formData as $key => $value) {
            if ($value == '') {
                $errors->add($key, 'El campo es requerido');
            }
        }

        if (!$errors->messages()) {
            /* Add the form information to Array */
            $formData['contact_id'] = $this->contactId;
            $formData['created_at'] = date('Y-m-d h:i:s');
            $formData['updated_at'] = date('Y-m-d h:i:s');

            /* Save the responses of the form in the table */
            DB::table('social_engineering_answers')->insert($formData);

            $this->emit('alert', ['type' => 'success', 'message' => 'Formulario diligenciado correctamente']);
            $this->emit('reset-form');
            $this->cancel();
        }
    }

    public function edit($id){

        $contact = Contact::find($id);
        $this->contactId = $contact->id;

        $action = $contact->commercial_action_id;

        if ($action != '') {
            $this->aQuestions = SocialQuestion::where('commercial_action_id', '=', $action)->get();
        }
        
        $this->process=SocialEngineeringAnswers::where('contact_id','=',$id)->first();
    }

    public function update($formData)
    {
        $errors = $this->getErrorBag();

        foreach ($formData as $key => $value) {
            if ($value == '') {
                $errors->add($key, 'El campo es requerido');
            }
        }

        if (!$errors->messages()) {
            /* Add the form information to Array */
            $formData['contact_id'] = $this->contactId;
            $formData['created_at'] = date('Y-m-d h:i:s');
            $formData['updated_at'] = date('Y-m-d h:i:s');

            /* Save the responses of the form in the table */
            DB::table('social_engineering_answers')->where('id','=',$this->process->id)->update($formData);

            $this->emit('alert', ['type' => 'success', 'message' => 'Formulario actualizado correctamente']);
            $this->emit('reset-form');
            $this->cancel();
        }
    }

    public function resetInputFields()
    {
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
