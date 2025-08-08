<?php

namespace App\Http\Livewire\Admin\InformationForms;

use App\Contact;
use App\Models\User;
use App\Announcement;
use App\Models\Stage;
use Livewire\Component;
use App\Jobs\SendEmailUser;
use App\Jobs\NewSendEmailJob;
use App\Models\ContactsStage;
use App\Models\InformationForm;
use App\Rules\EmailVerification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\InformationFormAnswer;
use App\Models\InformationFormQuestion;

class ExternalFormComponent extends Component
{

    public $token,
        $informationForm,
        $form,
        $questions,
        $options,
        $announcements,
        $cant = 0;

    public $count = 1;
    public $progress = 0;

    public $nit,
        $name,
        $email,
        $phone,
        $whatsapp,
        $contact_person_name,
        $website;

    public $input, $message = '';

    public $finish = false;

    public $anContact = [];

    protected $listeners = ['getQuestion', 'nextQuestion'];

    public $contactId, $stageId, $actionId;

    public $approved = 1;

    public $contactHasStage = false;

    public function mount($token)
    {
        $this->token = $token;
        $this->form = InformationForm::where('token', '=', $this->token)->first();
        $stage = Stage::find($this->form->stage_id);
        $this->stageId = $stage->id;
        $this->actionId = $stage->action_id;


        if ($this->form == '') {
            abort(404);
        }

        $this->questions = InformationFormQuestion::where('information_form_id', '=', $this->form->id)
            ->get();
        $this->options = InformationForm::all();
        $this->announcements = Announcement::all();
        $this->cant = count($this->questions) + 2;

        if (auth()->check() && auth()->user()->role_id == 7) {
            $this->count = 2;
            $contact = Contact::where('user_id', '=', Auth::user()->id)->first();
            $this->contactId = $contact->id;
        }
    }
    public function render()
    {

        return view('livewire.admin.information-forms.external-form-component')
            ->layout('layouts.app-form');
    }

    public function nextQuestion()
    {
        if ($this->count == 1 && $this->contactId == '') {
            $this->validate([
                'nit' => 'required|numeric|unique:contacts,nit',
                'name' => 'required',
                'email' => ['required', 'email', 'unique:users,email'/* , new EmailVerification */],
                'phone' => 'required',
                'contact_person_name' => 'required'
            ], [], [
                'nit' => 'NIT',
                'name' => 'nombre',
                'email' => 'correo electrónico',
                'phone' => 'teléfono',
                'contact_person_name' => 'persona de contacto'
            ]);
        }

        $this->count++;
        $this->progress = round(($this->count / $this->cant) * 100);
        $this->message = '';
    }

    public function previousQuestion()
    {
        $this->count--;
        $this->progress = round(($this->count / $this->cant) * 100);
    }

    public function getQuestion()
    {
        $question = $this->questions[$this->count - 3];
        $this->input = $question->id;
        $this->emit('sendQuestion', [$this->input, $question->type]);
    }

    public function submit($formData)
    {

        if (!$this->contactId) {

            $contact = new Contact();
            $contact->nit = $this->nit;
            $contact->name = $this->name;
            $contact->phone = $this->phone;
            $contact->email = $this->email;
            $contact->whatsapp = $this->whatsapp;
            $contact->website = $this->website;
            $contact->contact_person_name = $this->contact_person_name;
            $contact->storage = "form";
            $contact->commercial_action_id = $this->actionId;
            $contact->save();

            $this->contactId = $contact->id;

            $user =  new User();
            $user->name =  $this->name;
            $user->email = $this->email;
            $user->password = Hash::make($this->nit);
            $user->role_id = '7';
            $user->save();

            $contact->user_id = $user->id;
            $contact->update();

            $data2 = [
                'email' => $contact->email,
                'subject' => 'Registro plataforma Nido de Saberes',
                'name' => $contact->name
            ];

            dispatch(new SendEmailUser($data2));
        }

        unset($formData['nit']);
        unset($formData['name']);
        unset($formData['phone']);
        unset($formData['email']);
        unset($formData['whatsapp']);
        unset($formData['website']);
        unset($formData['contact_person_name']);

        $formData['contact_id'] = $this->contactId;
        $formData['information_form_id'] = $this->form->id;

        foreach ($this->questions as $question) {
            $questionKeyBase = 'question_' . $question->id;

            $matchingKeys = array_filter(array_keys($formData), function ($key) use ($questionKeyBase) {
                return strpos($key, $questionKeyBase) === 0;
            });

            if (empty($matchingKeys)) {
                $questionKey = $questionKeyBase;
                if (isset($formData[$questionKey])) {
                    $this->saveAnswer($question->id, $formData[$questionKey]);
                }
            } else {
                sort($matchingKeys);

                $answers = [];
                foreach ($matchingKeys as $key) {
                    $answers[] = $formData[$key];
                }

                if (!empty($answers)) {
                    $answer = implode(',', $answers);
                    $this->saveAnswer($question->id, $answer);
                }
            }
        }


        foreach ($this->questions as $question) {
            $questionKey = 'question_' . $question->id;

            $combinedAnswers = [];

            foreach ($formData as $key => $value) {
                if (strpos($key, $questionKey . '.') === 0) {
                    $index = substr($key, strlen($questionKey . '.'));

                    $combinedAnswers[$index] = $value;
                }
            }

            ksort($combinedAnswers);

            $combinedAnswer = implode(',', $combinedAnswers);

            if (!empty($combinedAnswer)) {
                $this->saveAnswer($question->id, $combinedAnswer);
            }
        }


        $contactStage = new ContactsStage();
        $contactStage->contact_id = $this->contactId;
        $contactStage->stage_id = $this->stageId;
        $contactStage->approved = $this->approved;
        $contactStage->save();

        $contactInfo = Contact::find($this->contactId);
        $stageInfo = Stage::find($this->stageId);

        NewSendEmailJob::dispatch($contactInfo->email, 'Inscripcion etapa ' . $stageInfo->name . ' del proceso ' . $stageInfo->process->name, 'Felicitaciones, estas inscrito a la etapa: ' . $stageInfo->name . ' del proceso ' . $stageInfo->process->name . ', inicia tu aventura ahora mismo en el nido de saberes.');

        $this->finish = true;
        $this->emit('showLoader');
    }

    private function saveAnswer($questionId, $answerValue)
    {
        $answer = new InformationFormAnswer();
        $answer->contact_id = $this->contactId;
        $answer->information_form_id = $this->form->id;
        $answer->question_id = $questionId;
        $answer->answer = $answerValue;
        $answer->save();
    }

    public function searchNit()
    {
        $this->validate([
            'nit' => 'required|string',
        ], [
            'nit.required' => 'El campo NIT/Cédula es obligatorio.',
        ]);

        try {
            $company = Contact::where('nit', $this->nit)->firstOrFail();

            $this->nit = $company->nit;
            $this->name = $company->name;
            $this->email = $company->email;
            $this->phone = $company->phone;
            $this->whatsapp = $company->whatsapp;
            $this->contact_person_name = $company->contact_person_name;
            $this->website = $company->website;
            $this->contactId = $company->id;

            $contactStage = ContactsStage::where('contact_id', $company->id)->first();
            if ($contactStage && $contactStage->stage_id == $this->stageId) {
                $this->addError('stage', 'Ya se encuentra postulado a esta estr ategia.');
                $this->contactHasStage = true;
            } else {
                $this->contactHasStage = false;
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            $this->name = '';
            $this->email = '';
            $this->phone = '';
            $this->whatsapp = '';
            $this->contact_person_name = '';
            $this->website = '';
            $this->contactId = '';
            $this->contactHasStage = false;
            $this->addError('nit', 'No existe registros con este NIT/Cédula.');
        }
    }

    private function clearContactProperties()
    {
        $this->nit = '';
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->whatsapp = '';
        $this->contact_person_name = '';
        $this->website = '';
        $this->contactId = '';
        $this->contactHasStage = false;
    }
}
