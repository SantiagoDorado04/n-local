<?php

namespace App\Http\Livewire\Contacts;

use App\Contact;
use App\Models\Step;
use Livewire\Component;
use App\Models\ContactsStage;
use Illuminate\Support\Facades\Auth;

class StepsContactComponent extends Component
{
    public $contactId, $stageId, $contactProcessId, $processId;
    public $description;

    public function mount($id)
    {

        $user = Auth::user();
        $contact = Contact::where('user_id', '=', $user->id)->first();
        $this->contactId = $contact->id;

        $contactProcess = ContactsStage::with('stage.process')->where('stage_id','=',$id)->where('contact_id','=',$this->contactId)->first();

        $this->contactProcessId = $contactProcess->id;

        $this->stageId = $id;
        $this->processId = $contactProcess->stage->process->id;
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
        $this->description = Step::findOrFail($id)->description;
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->emit('close-modal');
    }

    private function getSteps()
    {
        return Step::where('stage_id', $this->stageId)->orderBy('order','asc')->get();
    }

    private function getStage()
    {
        return ContactsStage::find($this->contactProcessId)->stage;
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
