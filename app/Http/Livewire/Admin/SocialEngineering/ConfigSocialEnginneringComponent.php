<?php

namespace App\Http\Livewire\Admin\SocialEngineering;

use App\CommercialLand;
use App\SocialQuestion;
use Livewire\Component;
use App\CommercialAction;
use App\CommercialStrategy;
use Illuminate\Support\Facades\DB;

class ConfigSocialEnginneringComponent extends Component
{

    public $question,
        $visibility,
        $questionId;

    public $searchType, $searchQuestion,$searchVisibility;

    public $lands, $strategies, $actions;
    public $landId, $strategyId, $actionId;

    public function mount()
    {
        //Lists dropdowns filter
        $this->lands = CommercialLand::all();
        $this->strategies = collect();
        $this->actions = collect();

    }

    public function render()
    {
        $questions = SocialQuestion::select(
            'social_questions.*',
            'commercial_actions.name as action_name',
            'commercial_strategies.name as strategy_name',
            'commercial_lands.name as land_name'
        )
            ->leftjoin('commercial_actions', 'commercial_actions.id', '=', 'social_questions.commercial_action_id')
            ->leftjoin('commercial_strategies', 'commercial_strategies.id', '=', 'commercial_actions.commercial_strategy_id')
            ->leftjoin('commercial_lands', 'commercial_lands.id', '=', 'commercial_strategies.commercial_land_id')
            ->when($this->searchVisibility, function ($query, $searchVisibility) {
                return $query->where('social_questions.visibility', '=',  $searchVisibility);
            })
            ->when($this->searchQuestion, function ($query, $searchQuestion) {
                return $query->where('social_questions.name', 'like', '%' . $searchQuestion . '%');
            })
            ->when($this->searchType, function ($query, $searchType) {
                switch ($searchType) {
                    case 'g':
                        return $query->whereNull('social_questions.commercial_action_id');
                        break;
                    case 'a':
                        return $query->whereNotNull('social_questions.commercial_action_id');
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

        return view('livewire.admin.social-engineering.config-social-enginnering-component', [
            'questions' => $questions
        ]);
    }

    public function store()
    {
        $this->validate([
            'question' => 'required|unique:social_questions,question',
            'visibility' => 'required'
        ], [], [
            'question' => 'pregunta',
            'visibility' => 'visibilidad'
        ]);

        $question = new SocialQuestion();
        $question->question = $this->question;
        if ($this->visibility == '') {
            $question->visibility = '0';
        } else {
            $question->visibility = $this->visibility;
        }
        $question->save();

        //Add column to table results
        $nameDatabase = DB::connection()->getDatabaseName();
        $nameTable = 'social_engineering_answers';
        $nameColumn = $question->id;
        
        $arrayColumns = array();
        array_push($arrayColumns, " ADD COLUMN question_" . $nameColumn . " TEXT NULL ");
        $stringCampos = implode(" , ", $arrayColumns);

        $createTable =
            "ALTER TABLE $nameDatabase.$nameTable  " . $stringCampos . ";";
        DB::statement($createTable);

        $this->emit('alert', ['type' => 'success', 'message' => 'Pregunta agregada correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->questionId = $id;

        $question = SocialQuestion::find($this->questionId);
        $this->question = $question->question;
        if ($question->visibility == '0') {
            $this->visibility = '';
        } else {
            $this->visibility = $question->visibility;
        }
    }

    public function update()
    {
        $this->validate([
            'question' => 'required|unique:social_questions,question,' . $this->questionId,
            'visibility' => 'required'
        ], [], [
            'question' => 'pregunta',
            'visibility' => 'visibilidad'
        ]);

        $question = SocialQuestion::find($this->questionId);
        $question->question = $this->question;
        if ($this->visibility == '') {
            $question->visibility = '0';
        } else {
            $question->visibility = $this->visibility;
        }
        $question->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Pregunta modificada correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->questionId = $id;
    }

    public function destroy()
    {
        $question = SocialQuestion::find($this->questionId);
        $question->delete();

        //Delete column table results
        $nameDatabase = DB::connection()->getDatabaseName();
        $nameTable = 'answers_form_' . $this->form->id;

        $editTable =
            "ALTER TABLE $nameDatabase.$nameTable  DROP COLUMN question_$this->questionId;";
        DB::statement($editTable);

        $this->emit('alert', ['type' => 'success', 'message' => 'Pregunta eliminada correctamente']);
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
            $this->lands=collect();
            $this->strategies = collect();
            $this->actions = collect();
            $this->landId = '';
            $this->strategyId = '';
            $this->actionId = '';
        }
    }

    public function resetInputFields()
    {
        $this->question = '';
        $this->visibility = '';
        $this->questionId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }

        /**
     * > When the `select2` event is emitted, the `hydrate` function is called
     */
    public function hydrate()
    {
        $this->emit('select2');
    }
}
