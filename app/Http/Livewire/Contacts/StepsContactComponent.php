<?php

namespace App\Http\Livewire\Contacts;

use App\Contact;
use App\Models\Step;
use Livewire\Component;
use App\Models\ContactsStage;
use Illuminate\Support\Facades\Auth;

class StepsContactComponent extends Component
{
    public $contactId;
    public $stageId;
    public $contactStageId;
    public $processId;
    public $description;

    public function mount($id)
    {
        $user = Auth::user();

        // Buscamos el contacto asociado al usuario
        $contact = Contact::where('user_id', $user->id)->firstOrFail();
        $this->contactId = $contact->id;

        // Verificamos que ese contacto realmente esté inscrito en la etapa
        $contactStage = ContactsStage::with('stage.process')
            ->where('stage_id', $id)
            ->where('contact_id', $this->contactId)
            ->firstOrFail();

        // Guardamos referencias para el render
        $this->contactStageId = $contactStage->id;
        $this->stageId = $contactStage->stage->id;
        $this->processId = $contactStage->stage->process->id;
    }

    public function render()
    {
        $steps = $this->getSteps();
        $stage = $this->getStage();
        $process = $this->getProcess();

        return view('livewire.contacts.steps-contact-component', compact('steps', 'stage', 'process'));
    }

    public function show($id)
    {
        $step = Step::where('id', $id)
            ->where('stage_id', $this->stageId) // Seguridad extra: paso debe pertenecer a la etapa
            ->firstOrFail();

        $this->description = $step->description;
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->emit('close-modal');
    }

    private function getSteps()
    {
        // Solo pasos de la etapa a la que el usuario está inscrito
        return Step::where('stage_id', $this->stageId)
            ->orderBy('order', 'asc')
            ->get();
    }

    private function getStage()
    {
        return ContactsStage::with('stage')->findOrFail($this->contactStageId)->stage;
    }

    private function getProcess()
    {
        return $this->getStage()->process;
    }

    private function resetInputFields()
    {
        $this->description = '';
    }
}
