<?php

namespace App\Http\Livewire\Admin\CommercialForms;

use App\CommercialForm;
use Livewire\Component;
use App\CommercialFormOption;
use App\CommercialFormQuestion;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CommercialQuestionComponent extends Component
{
    //vars question
    public $question,
        $type,
        $visibility,
        $order,
        $questionId;

    //var form
    public $form;

    public function mount($form)
    {
        //Get form
        $this->form = CommercialForm::find($form);
    }

    public function render()
    {
        //Get questions
        $questions = CommercialFormQuestion::where('commercial_form_id', '=', $this->form->id)->get();

        return view('livewire.admin.commercial-forms.commercial-question-component', [
            'questions' => $questions
        ]);
    }

    public function store()
    {
        $this->validate([
            'question' => 'required|'. Rule::unique('commercial_form_questions', 'question')->where(function ($query) {
                return $query->where('commercial_form_id','=',$this->form->id);
            }),
            'type' => 'required',
            'visibility'=>'required'
        ], [], [
            'question' => 'texto de pregunta',
            'type' => 'tipo',
            'visibility' => 'visibilidad'
        ]);

        //Save question
        $question = new CommercialFormQuestion();
        $question->question = $this->question;
        $question->type = $this->type;
        $question->visibility = $this->visibility;
        $question->commercial_form_id = $this->form->id;
        $question->save();

        //Add column to table results
        $nameDatabase = DB::connection()->getDatabaseName();
        $nameTable = 'answers_form_' . $this->form->id;
        $nameColumn = $question->id;
        
        $arrayColumns = array();
        array_push($arrayColumns, " ADD COLUMN question_" . $nameColumn . " TEXT NULL ");
        $stringCampos = implode(" , ", $arrayColumns);

        $createTable =
            "ALTER TABLE $nameDatabase.$nameTable  " . $stringCampos . ";";
        DB::statement($createTable);

        $this->emit('alert', ['type' => 'success', 'message' => 'Pregunta creada correctamente']);
        $this->cancel();
    }

    /**
     * It takes an id, finds the question with that id, and sets the question, type, and visibility
     * properties of the class to the values of the question, type, and visibility of the question with
     * the given id
     * 
     * @param id The id of the question you want to edit.
     */
    public function edit($id)
    {
        $this->questionId = $id;

        $question = CommercialFormQuestion::find($id);
        $this->question = $question->question;
        $this->type = $question->type;
        $this->visibility = $question->visibility;
    }

    /**
     * It updates the question in the database and emits an alert to the user
     */
    public function update()
    {
        $this->validate([
            'question' => 'required|'.Rule::unique('commercial_form_questions', 'question')->where(function ($query) {
                return $query->where('commercial_form_id','=',$this->form->id);
            })->ignore($this->questionId),
            'type' => 'required',
            'visibility' => 'required'
        ], [], [
            'question' => 'texto de pregunta',
            'type' => 'tipo',
            'visibility' => 'visibilidad'
        ]);

        $question = CommercialFormQuestion::find($this->questionId);
        $question->question = $this->question;
        $question->type = $this->type;
        $question->visibility = $this->visibility;
        $question->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Pregunta actualizada correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->questionId = $id;
    }

    public function destroy()
    {
        //Delete question
        $question = CommercialFormQuestion::find($this->questionId);
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

    public function resetInputFields()
    {
        $this->question = '';
        $this->type = '';
        $this->questionId = '';
        $this->visibility='';
        $this->questionId='';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
