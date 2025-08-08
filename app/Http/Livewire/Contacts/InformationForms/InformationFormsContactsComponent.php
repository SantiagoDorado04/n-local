<?php

namespace App\Http\Livewire\Contacts\InformationForms;

use Illuminate\Support\Facades\Redirect;
use App\Models\ContactsInformationForm;
use App\Models\InformationFormAnswer;
use App\Models\InformationFormOption;
use App\Models\Step;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InformationFormsContactsComponent extends Component
{
    protected $paginationTheme = 'bootstrap';

    public $searchName;

    public $formId;
    public $stepId;
    public $form;
    public $questions;
    public $options;
    public $contactId;

    public $input;
    public $message = '';
    public $count = 1;


    public $stageActive = false;

    public function mount($id)
    {
        $step = Step::with('informationForm')->findOrFail($id);

        if ($step->stage->active == 1) {
            $this->stageActive = true;
        }
        $this->formId = $step->informationForm->id;
        $this->form = $step->informationForm;
        $this->questions = $this->form->questions;
        $this->options = InformationFormOption::all();

        $this->stepId = $this->form->step_id;

        if (Auth::check() && Auth::user()->role_id == 7) {
            $this->count = 2;
            $this->contactId = Auth::user()->contact->id;
        }
    }

    public function render()
    {

        $answers = InformationFormAnswer::where('contact_id', '=', $this->contactId)
            ->where('information_form_id', '=', $this->formId)
            ->get()
            ->keyBy('question_id');

        return view(
            'livewire.contacts.information-forms.information-forms-contacts-component',
            [
                'form' => $this->form,
                'hasAnswers' => $answers->isNotEmpty(),
                'answers' => $answers
            ]
        );
    }

    public function submit($formData)
    {
        $contactForm = new ContactsInformationForm();

        $contactForm
            ->fill([
                'contact_id' => $this->contactId,
                'information_form_id' => $this->formId,
                'date_completed' => now(),
            ])
            ->save();

        foreach ($this->questions as $question) {
            $questionId = 'question_' . $question->id;
            if (isset($formData[$questionId])) {
                $answer = new InformationFormAnswer();
                $answer->contact_id = $this->contactId;
                $answer->information_form_id = $this->form->id;
                $answer->question_id = $question->id;
                $answer->answer = $formData['question_' . $question->id];
                $answer->save();
            }
        }
        $this->emit('alert', ['type' => 'success', 'message' => '¡Formulario enviado correctamente!']);
        $this->render();
    }
}
