<?php

namespace App\Http\Livewire\Admin\InformationForms;

use App\Announcement;
use App\Contact;
use App\Jobs\NewSendEmailJob;
use App\Jobs\SendEmailUser;
use App\Models\ContactsCourseRegistrationForm;
use App\Models\CourseRegistrationForm;
use App\Models\InformationForm;
use App\Models\InformationFormAnswer;
use App\Models\InformationFormQuestion;
use App\Models\OnlineRegistration;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ExternalRegistrationFormComponent extends Component
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

    public $contactId, $course_registration_form_id, $actionId, $online_registration_id, $course_registration_form;

    public $approved = 0;

    public $contactHasCourseRegistrationForm = false;

    public $bannerImage;


    public function mount($token)
    {
        $this->token = $token;
        $this->form = InformationForm::where('token', '=', $this->token)->first();
        $this->course_registration_form = CourseRegistrationForm::find($this->form->course_registration_form_id);
        $this->course_registration_form_id = $this->course_registration_form->id;
        $this->online_registration_id = $this->course_registration_form->online_registration_id;
        $this->actionId = $this->course_registration_form->action_id;

        $this->bannerImage = $this->course_registration_form->file ? asset('storage/files/' . basename($this->course_registration_form->file)) : null;

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
        return view('livewire..admin.information-forms.external-registration-form-component')->layout('layouts.app-form');
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

            $lastRegistration = ContactsCourseRegistrationForm::where('contact_id', $company->id)
                ->where('course_registration_form_id', $this->course_registration_form_id)
                ->orderBy('created_at', 'desc')
                ->first();

            if($lastRegistration){
                $lastCourse = $lastRegistration->courseRegistrationForm;
                $onlineRegistration = $lastCourse->onlineRegistration;
                if (!$onlineRegistration) {
                    $this->addError('course_registration_form', "No se pudo determinar la restricción del curso.");
                    return;
                }
                $courseLimit = $onlineRegistration->course_limit;

                $coursesSinceLast = CourseRegistrationForm::where('id', '>', $lastCourse->id)->count();
                
                $coursesSinceLast = CourseRegistrationForm::where('id', '>', $lastCourse->id)
                ->where('online_registration_id', $this->online_registration_id)
                ->count();


                if ($coursesSinceLast <= $courseLimit) {
                    $remainingCourses = $courseLimit - $coursesSinceLast;
                    if ($coursesSinceLast == $courseLimit) {
                        $this->addError('course_registration_form', "Debes esperar al siguiente curso para inscribirte nuevamente, busca mas convocatorias en nuestras redes sociales.");
                        return;
                    }
                    $this->addError('course_registration_form', "Debe esperar que pasen " . $remainingCourses . " cursos antes de inscribirse nuevamente a un curso de este proceso, busca mas convocatorias en nuestras redes sociales.");
                    return;
                }
            }

            //----

            $contactCourseRegistration = ContactsCourseRegistrationForm::where('contact_id', $company->id)->first();
            if ($contactCourseRegistration && $contactCourseRegistration->courseRegistrationForm->id == $this->course_registration_form_id) {
                $this->addError('course_registration_form', 'Ya ha realizado el registro a este evento.');
                $this->contactHasCourseRegistrationForm = true;
            } else {
                $this->contactHasCourseRegistrationForm = false;
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            $this->name = '';
            $this->email = '';
            $this->phone = '';
            $this->whatsapp = '';
            $this->contact_person_name = '';
            $this->website = '';
            $this->contactId = '';
            $this->contactHasCourseRegistrationForm = false;
            $this->addError('nit', 'No existe registros con este NIT/Cédula.');
        }
        if ($this->count == 1) {
            $this->count++;
            $this->progress = round(($this->count / $this->cant) * 100);
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
        $this->contactHasCourseRegistrationForm = false;
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

        $contactCourseRegistration = new ContactsCourseRegistrationForm();
        $contactCourseRegistration->contact_id = $this->contactId;
        $contactCourseRegistration->course_registration_form_id = $this->course_registration_form_id;
        $contactCourseRegistration->approved = $this->approved;
        $contactCourseRegistration->save();

        $contactInfo = Contact::find($this->contactId);
        $course_registration_form_info = CourseRegistrationForm::find($this->course_registration_form_id);

        NewSendEmailJob::dispatch($contactInfo->email, 'Registro formulario: ' . $course_registration_form_info->name . ' del proceso: ' . $course_registration_form_info->onlineRegistration->name, 'Felicitaciones, has diligenciado correctamente el formulario: ' . $course_registration_form_info->name . ' del proceso ' . $course_registration_form_info->onlineRegistration->name . ', inicia tu aventura ahora mismo en el nido de saberes.');

        $this->finish = true;
        $this->emit('showLoader');
    }
}
