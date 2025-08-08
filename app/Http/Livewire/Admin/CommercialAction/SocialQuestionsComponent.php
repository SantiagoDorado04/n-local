<?php

namespace App\Http\Livewire\Admin\CommercialAction;

use App\CommercialLand;
use App\SocialQuestion;
use Livewire\Component;
use App\CommercialAction;
use App\CommercialStrategy;
use Illuminate\Support\Facades\DB;

class SocialQuestionsComponent extends Component
{
    public $strategy,
    $land,
    $action;

    public $question,
    $visibility,
    $questionId;

    public function mount($action)
    {
        $this->action = CommercialAction::find($action);
        $this->strategy = CommercialStrategy::find($this->action->commercial_strategy_id);
        $this->land = CommercialLand::find($this->strategy->commercial_land_id);
    }

    public function render()
    {
        $questions = SocialQuestion::where('commercial_action_id','=',$this->action->id)->get();
        return view('livewire.admin.commercial-action.social-questions-component', [
            'questions' => $questions
        ]);
    }
    
    public function resetInputFields()
    {
        $this->question = '';
        $this->visibility = '';
        $this->questionId = '';
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
        if($this->visibility==''){
            $question->visibility = '0';
        }else{
            $question->visibility = $this->visibility;
        }
        $question->commercial_action_id=$this->action->id;
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
        if($question->visibility == '0'){
            $this->visibility='';
        }else{
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
        if($this->visibility==''){
            $question->visibility = '0';
        }else{
            $question->visibility = $this->visibility;
        }
        $question->commercial_action_id=$this->action->id;
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

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
