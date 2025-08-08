<?php

namespace App\Http\Livewire\Contacts\Challenges;

use App\Contact;
use App\Models\Step;
use Livewire\Component;
use App\Models\Challenge;
use Livewire\WithFileUploads;
use App\Models\ContactsChallenge;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChallengesContactsComponent extends Component
{
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $searchName;

    public $files = [];
    public $observations = [];
    public $fileStatuses = [];

    public $contactId, $stepId;

    public $stageActive = false;

    public function mount($id)
    {
        $contact = Contact::where('user_id', '=', Auth::user()->id)->first();
        $this->contactId = $contact->id;

        $this->stepId = $id;
        $step = Step::findOrFail($this->stepId);
        if ($step->stage->active == 1) {
            $this->stageActive = true;
        }
    }

    public function render()
    {
        $challenges = Challenge::where('step_id', '=', $this->stepId)->get();

        $step = Step::with('courses')->findOrFail($this->stepId);

        $challengesContact = ContactsChallenge::where('contact_id', '=', $this->contactId)->get();

        return view('livewire.contacts.challenges.challenges-contacts-component', [
            'challenges' => $challenges,
            'challengesContact' => $challengesContact,
            'step' => $step
        ]);
    }

    public function submitForm($challengeId)
    {
        if (!isset($this->fileStatuses[$challengeId])) {
            $this->validate([
                'files.' . $challengeId => 'required|file',
                'observations.' . $challengeId => 'nullable|string',
            ], [
                'files.' . $challengeId . '.required' => 'Por favor, cargue un archivo.',
            ]);


            $file = $this->files[$challengeId];
            $filePath = $file->store('uploads', 'public');

            $submission = new ContactsChallenge();
            $submission->challenge_id = $challengeId;
            $submission->file = $filePath;
            if (isset($this->observations[$challengeId])) {
                $submission->text = $this->observations[$challengeId];
            }
            $submission->contact_id = $this->contactId;
            $submission->save();

            $this->files[$challengeId] = '';
            $this->observations[$challengeId] = '';

            $this->emit('alert', ['type' => 'success', 'message' => 'Retos / Entregable cargado correctamente']);
        } else {
            $this->emit('alert', ['type' => 'error', 'message' => 'Ya se ha cargado un archivo para este desafío.']);
        }
    }

    public function deleteFile($challengeId)
    {
        $submission = ContactsChallenge::where('challenge_id', $challengeId)
            ->where('contact_id', $this->contactId)
            ->first();

        if ($submission) {
            Storage::disk('public')->delete($submission->file);

            $submission->delete();

            $this->emit('alert', ['type' => 'success', 'message' => 'Archivo eliminado correctamente.']);
        } else {
            $this->emit('alert', ['type' => 'error', 'message' => 'No se encontró el archivo para eliminar.']);
        }
    }
}
