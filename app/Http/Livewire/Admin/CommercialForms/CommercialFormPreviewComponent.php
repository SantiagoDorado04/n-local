<?php

namespace App\Http\Livewire\Admin\CommercialForms;

use App\CommercialLand;
use Livewire\Component;
use App\CommercialAction;
use App\CommercialForm;
use App\CommercialFormOption;
use App\CommercialFormQuestion;
use App\CommercialStrategy;

class CommercialFormPreviewComponent extends Component
{
    public $form,
        $action,
        $strategy,
        $land;

    public function mount($form)
    {
        $this->form = CommercialForm::find($form);
    }

    public function render()
    {
        $questions = CommercialFormQuestion::where('commercial_form_id', '=', $this->form->id)
            ->where('visibility', '=', '1')
            ->get();
        $options = CommercialFormOption::all();

        return view('livewire.admin.commercial-forms.commercial-form-preview-component', [
            'questions' => $questions,
            'options' => $options
        ]);
    }
}
