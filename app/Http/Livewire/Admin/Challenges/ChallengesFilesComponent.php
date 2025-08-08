<?php

namespace App\Http\Livewire\Admin\Challenges;

use App\Contact;
use App\Jobs\WaOfiJob;
use Livewire\Component;
use App\Jobs\SendSmsUser;
use App\Models\Challenge;
use Livewire\WithPagination;
use App\ContactsPointsDetail;
use App\Jobs\NewSendEmailJob;
use App\Models\ContactsStage;
use App\Models\ContactsChallenge;

class ChallengesFilesComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $challengeId, $contactChallengeId;

    public $feedback;

    public
        $searchName;

    public function mount($id)
    {
        $this->challengeId = $id;
    }


    public function render()
    {
        $challenge = Challenge::find($this->challengeId);
        $challengesContacts = ContactsChallenge::where('challenge_id', $this->challengeId)->get();
        // $contactsStage = ContactsStage::where('stage_id', $challenge->step->stage_id)->get();
        $query = ContactsStage::with('contact')->where('stage_id', $challenge->step->stage_id);

        if ($this->searchName) {
            $query->whereHas('contact', function ($q) {
                $q->where('name', 'like', '%' . $this->searchName . '%')
                    ->orWhere('email', 'like', '%' . $this->searchName . '%')
                    ->orWhere('nit', 'like', '%' . $this->searchName . '%');
            });
        }
        // $contactsStage = ContactsStage::where('stage_id', $challenge->step->stage_id)->paginate(25);
        $contactsStage = $query->paginate(25);

        return view('livewire.admin.challenges.challenges-files-component', [
            'challenge' => $challenge,
            'challengesContacts' => $challengesContacts,
            'contactsStage' => $contactsStage
        ]);
    }

    public function toggleApproval($contactId)
    {
        $contactChallenge = ContactsChallenge::findOrFail($contactId);
        $contactChallenge->update(['approved' => !$contactChallenge->approved]);

        $challenge = Challenge::find($contactChallenge->challenge_id);
        $contactDetail = Contact::find($contactChallenge->contact_id);

        if ($contactChallenge->approved) {
            $contactDetail->points = $contactDetail->points + $challenge->points;
            $contactDetail->update();


            $detail = new ContactsPointsDetail();
            $detail->detail = 'Se te han asignado +' . $challenge->points . ' puntos por la entrega del reto: "' . $challenge->name . '"';
            $detail->points = $challenge->points;
            $detail->date = date('Y-m-d H:i:s');
            $detail->contact_id = $contactDetail->id;
            $detail->save();


            $contact = Contact::find($contactDetail->id);
            $content = $challenge->congratulation_message;

            switch ($challenge->reminder_message_mean) {
                case 'email':
                    NewSendEmailJob::dispatch($contact->email, 'Envio reto o entregable', $content);
                    break;
                case 'whatsapp':
                    WaOfiJob::dispatch('+57' . $contact->phone, $content);
                    break;
                case 'sms':
                    SendSmsUser::dispatch('+57' . $contact->phone, $content);
                    break;
                default:
                    break;
            }

            $this->emit('alert', ['type' => 'success', 'message' => 'Reto o entregable revisado y aprobado']);
        } else {
            $contactDetail->points = max(0, $contactDetail->points - $challenge->points);
            $contactDetail->update();

            $this->emit('alert', ['type' => 'error', 'message' => 'Reto o entregable no aprobado y puntos restados']);
        }
    }


    public function feedback($id)
    {
        $contact = ContactsChallenge::findOrFail($id);
        $this->feedback = $contact->feedback;

        $this->contactChallengeId = $contact->id;
    }

    public function storeFeedback()
    {

        $this->validate([
            'feedback' => 'required',
        ]);

        $contact = ContactsChallenge::findOrFail($this->contactChallengeId);
        $contact->feedback =  $this->feedback;
        $contact->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Feedback agregado correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->feedback = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
