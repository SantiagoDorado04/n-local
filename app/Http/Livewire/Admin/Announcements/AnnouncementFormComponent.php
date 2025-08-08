<?php

namespace App\Http\Livewire\Admin\Announcements;

use App\Announcement;
use App\AnnouncementsForm;
use App\CommercialForm;
use Livewire\Component;

class AnnouncementFormComponent extends Component
{

    public $announcement, $announcementFormId;

    public $forms;
    public $formId;

    public function mount($announcement)
    {
        $this->announcement = Announcement::find($announcement);
        $this->forms = CommercialForm::all();
    }

    public function render()
    {
        $announcementsForms = AnnouncementsForm::select(
            'announcements_forms.id as announcement_form_id',
            'commercial_forms.name as form_name',
            'commercial_forms.description as form_description',
        )
            ->join('commercial_forms', 'commercial_forms.id', '=', 'announcements_forms.commercial_form_id')
            ->where('announcement_id', '=', $this->announcement->id)->get();

        return view('livewire.admin.announcements.announcement-form-component', [
            'announcementsForms' => $announcementsForms
        ]);
    }

    public function store()
    {

        if ($this->formId) {
            $form = AnnouncementsForm::where('commercial_form_id', '=', $this->formId)
                ->where('announcement_id', '=', $this->announcement->id)
                ->first();

            if ($form == '') {
                $form = new AnnouncementsForm();
                $form->announcement_id = $this->announcement->id;
                $form->commercial_form_id = $this->formId;
                $form->save();
                $this->emit('alert', ['type' => 'success', 'message' => 'Formulario agragado correctamente']);

                $this->formId = '';
            } else {
                $this->emit('alert', ['type' => 'error', 'message' => 'El formulario  ya se encuentra agragado']);
            }
        }
    }

    public function delete($id)
    {
        $this->announcementFormId = $id;
    }

    public function destroy()
    {
        $form = AnnouncementsForm::find($this->announcementFormId);
        $form->delete();


        $this->emit('alert', ['type' => 'success', 'message' => 'Formulario eliminado correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->announcementFormId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }

    public function hydrate()
    {
        $this->emit('select2');
    }
}
