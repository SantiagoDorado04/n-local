<?php

namespace App\Http\Livewire\Admin\CommercialForms;

use App\CommercialForm;
use Livewire\Component;
use App\CommercialFormOption;
use App\CommercialFormQuestion;

class CommercialOptionComponent extends Component
{
    //vars options
    public $option,
        $value,
        $optionId;

    //vars question and form
    public $question, $form;

    public function mount($question)
    {
        //Get form and questions
        $this->question = CommercialFormQuestion::find($question);
        $this->form = CommercialForm::find($this->question->commercial_form_id);
    }

    public function render()
    {
        //Get all options
        $options = CommercialFormOption::where('commercial_form_question_id', '=', $this->question->id)->get();
        return view('livewire.admin.commercial-forms.commercial-option-component', [
            'options' => $options
        ]);
    }

    /**
     * It validates the form, creates a new CommercialFormOption, saves it, and emits an alert
     */
    public function store()
    {
        $this->validate([
            'option' => 'required',
            'value' => 'required'
        ], [], [
            'option' => 'opción',
            'value' => 'value'
        ]);

        $option = new CommercialFormOption();
        $option->option = $this->option;
        $option->value = $this->value;
        $option->commercial_form_question_id = $this->question->id;
        $option->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Opción creada correctamente']);
        $this->cancel();
    }

    /**
     * The function takes an id, finds the option with that id, and then sets the option and value to
     * the values of the object
     * 
     * @param id The id of the option you want to edit.
     */
    public function edit($id)
    {
        $this->optionId = $id;

        $option = CommercialFormOption::find($this->optionId);
        $this->option = $option->option;
        $this->value = $option->value;

        
    }

    /**
     * It validates the input, updates the option and emits an alert
     */
    public function update()
    {
        $this->validate([
            'option' => 'required',
            'value' => 'required'
        ], [], [
            'option' => 'opción',
            'value' => 'value'
        ]);

        $option = CommercialFormOption::find($this->optionId);
        $option->option = $this->option;
        $option->value = $this->value;
        $option->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Opción actualizada correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->optionId = $id;
    }

    /**
     * > The function `destroy()` is called when the user clicks the delete button. It deletes the
     * option from the database and emits an alert to the user
     */
    public function destroy()
    {
        $option = CommercialFormOption::find($this->optionId);
        $option->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Opción eliminada correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->option = '';
        $this->value = '';
        $this->optionId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
