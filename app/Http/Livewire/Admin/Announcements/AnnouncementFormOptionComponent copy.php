<?php

namespace App\Http\Livewire\Admin\Announcements;

use App\Announcement;
use App\CommercialForm;
use Livewire\Component;
use App\AnnouncementsForm;
use App\AnnouncementsFormsOption;
use App\CommercialFormOption;
use App\CommercialFormQuestion;

class AnnouncementFormOption2Component extends Component
{
    public $announcement,
        $announcementForm;

    public $form,
        $action,
        $strategy,
        $land;

    public $chQuestion,
        $chOption;

    protected $listeners = ['updateOption' => 'updateOption'];

    public function mount($form)
    {
        $this->announcementForm = AnnouncementsForm::find($form);
        $this->announcement = Announcement::find($this->announcementForm->announcement_id);

        $this->form = CommercialForm::find($this->announcementForm->commercial_form_id);
    }

    public function render()
    {
        $questions = CommercialFormQuestion::where('commercial_form_id', '=', $this->form->id)
            ->where('visibility', '=', '1')
            ->get();
        $options = CommercialFormOption::all();

        $opQuestions = AnnouncementsFormsOption::where('announcement_form_id', '=', $this->announcementForm->id)
            ->get();

        return view('livewire.admin.announcements.announcement-form-option-component', [
            'questions' => $questions,
            'options' => $options,
            'opQuestions' => $opQuestions
        ]);
    }

    public function updateOption()
    {

        if ($this->chQuestion != '' && $this->chOption != '') {
            $op = CommercialFormOption::find($this->chOption);

            $search = AnnouncementsFormsOption::where('announcement_form_id', '=', $this->announcementForm->id)
                ->where('commercial_question_id', '=', $this->chQuestion)
                ->first();

            if ($search != '') {
                $option = AnnouncementsFormsOption::find($search->id);
                $option->announcement_form_id = $this->announcementForm->id;
                $option->commercial_question_id = $this->chQuestion;
                $option->commercial_question_option_id = $this->chOption;
                $option->value = $op->value;
                $option->update();

                $this->emit('alert', ['type' => 'success', 'message' => 'Opción actualizada correctamente']);
            } else {
                $option = new AnnouncementsFormsOption();
                $option->announcement_form_id = $this->announcementForm->id;
                $option->commercial_question_id = $this->chQuestion;
                $option->commercial_question_option_id = $this->chOption;
                $option->value = $op->value;
                $option->save();

                $this->emit('alert', ['type' => 'success', 'message' => 'Opción seleccionada correctamente']);
            }

            $this->chQuestion = '';
            $this->chOption = '';
        }
    }
}
