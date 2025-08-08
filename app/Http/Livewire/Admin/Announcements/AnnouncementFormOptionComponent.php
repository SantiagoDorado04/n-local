<?php

namespace App\Http\Livewire\Admin\Announcements;

use App\Announcement;
use App\CommercialForm;
use Livewire\Component;
use App\AnnouncementsForm;
use App\AnnouncementsFormsOption;
use App\CommercialFormOption;
use App\CommercialFormQuestion;

class AnnouncementFormOptionComponent extends Component
{
    public $announcement,
        $announcementForm;

    public $formx,
        $action,
        $strategy,
        $land;

    public $chQuestion,
        $chOption,
        $chValue;

    protected $listeners = ['updateOption' => 'updateOption'];

    public function mount($form)
    {

        $this->announcementForm = AnnouncementsForm::find($form);
        $this->announcement = Announcement::find($this->announcementForm->announcement_id);

        $this->formx = CommercialForm::find($this->announcementForm->commercial_form_id);
    }

    public function render()
    {
        $questions = CommercialFormQuestion::where('commercial_form_id', '=', $this->formx->id)
            ->where('visibility', '=', '1')
            ->get();
        $options = CommercialFormOption::all();

        $opQuestions = AnnouncementsFormsOption::where('announcement_form_id', '=', $this->announcementForm->id)
            ->get();

            /* dd($this->announcementForm->id); */

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

                if ($this->chValue=='on') {
                $option = new AnnouncementsFormsOption();
                $option->announcement_form_id = $this->announcementForm->id;
                $option->commercial_question_id = $this->chQuestion;
                $option->commercial_question_option_id = $this->chOption;
                $option->value = $op->value;
                $option->save();
            }else{
                $search = AnnouncementsFormsOption::where('announcement_form_id', '=', $this->announcementForm->id)
                ->where('commercial_question_id', '=', $this->chQuestion)
                ->where('commercial_question_option_id', '=', $this->chOption)
                ->first();

                $option = AnnouncementsFormsOption::find($search->id);
                $option->delete();
            }
            $this->chQuestion = '';
            $this->chOption = '';
            $this->chValue = '';
        }
    }
}
