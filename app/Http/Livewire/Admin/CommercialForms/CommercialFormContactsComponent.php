<?php

namespace App\Http\Livewire\Admin\CommercialForms;

use App\Contact;
use App\CommercialForm;
use App\CommercialLand;
use Livewire\Component;
use App\CommercialFormAction;
use App\CommercialFormOption;
use App\CommercialFormQuestion;
use Illuminate\Support\Facades\DB;

class CommercialFormContactsComponent extends Component
{

    public $searchName;
    public $action, $form, $questions, $options, $result;
    public $lands, $strategies, $actions;
    public $landId, $strategyId, $actionId;

    public function mount($action)
    {
        $this->action = CommercialFormAction::find($action);
        $this->lands = CommercialLand::all();
        $this->strategies = collect();
        $this->actions = collect();

        $this->form = CommercialForm::find($this->action->commercial_form_id)->first();
        $this->questions=CommercialFormQuestion::where('commercial_form_id','=', $this->action->commercial_form_id)->get();
        $this->options=CommercialFormOption::all();
        
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
            'commercial_lands.name as commercial_land_name'
        )
            ->join('commercial_form_actions', 'commercial_form_actions.id', '=', 'contacts.form_action_id')
            ->join('commercial_forms', 'commercial_forms.id', '=', 'commercial_form_actions.commercial_form_id')
            ->join('commercial_actions', 'commercial_actions.id', '=', 'commercial_form_actions.commercial_action_id')
            ->join('commercial_strategies', 'commercial_strategies.id', '=', 'commercial_actions.commercial_strategy_id')
            ->join('commercial_lands', 'commercial_lands.id', '=', 'commercial_strategies.commercial_land_id')
            ->when($this->searchName, function ($query, $searchName) {
                return $query->where('name', 'like', '%' . $searchName . '%');
            })
            ->where('form_action_id', '=', $this->action->id)
            ->get();

        return view('livewire.admin.commercial-forms.commercial-form-contacts-component', [
            'contacts' => $contacts
        ]);
    }

    public function getResult($id)
    {
        $this->result = DB::table('answers_form_' . $this->action->commercial_form_id)->where('contact_id', '=', $id)->get();

    }

    public function cancel()
    {
        
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
        $this->result=[];
    }
}


/*
tengo la tabla 'announcements', la tabla 'announcements_forms' que se relaciona con 'announcements' por el campo 'announcement_id' y también se relaciona con la tabla 'commercial_forms' por el campo 'commercial_form_id'
tambien tengo la tabla  'announcements_forms_options' que tiene los campos 'announcement_form_id' que se relaciona  con la tabla 'announcements_forms', el campo '	commercial_question_id' que 
se relaciona con la tabla 'commercial_form_questions' y el campo 'commercial_question_option_id' que se relaciona con la tabla  'commercial_form_questions' COMO SERIAN LAS RELACIONES EN LARAVEL
*/