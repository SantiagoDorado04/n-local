<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationForms;

use App\Announcement;
use App\Contact;
use App\Jobs\NewSendEmailJob;
use App\Jobs\SendEmailUser;
use App\Jobs\WAsender;
use App\Models\OnlineRegistrationContactCourse;
use App\Models\OnlineRegistrationCourse;
use App\Models\OnlineRegistrationCourseSession;
use App\Models\OnlineRegistrationForm;
use App\Models\OnlineRegistrationFormAnswer;
use App\Models\OnlineRegistrationFormOption;
use App\Models\OnlineRegistrationFormQuestion;
use App\Models\OnlineRegistrationSessionAttendee;
use App\Models\OrAssignedCharacterization;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class OnlineRegistrationPublicFormComponent extends Component
{

    public $slug,
        $onlineRegistrationForm,
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

    public $answers = [];


    public $old_name, $old_email, $old_phone, $old_whatsapp, $old_contact_person_name, $old_website;

    public $input, $message = '';

    public $finish = false;

    public $anContact = [];

    protected $listeners = ['getQuestion', 'nextQuestion'];

    public $contactId, $online_registration_course_id, $actionId;

    public $certificate = 0;
    public $missingCourses;

    public $contactHasOnlineRegistrationCourse = false;

    public $bannerImage, $embebed_video;

    public $activeCourse = true;
    public $contactLimit, $canRegister = true;
    public $messageTrait;
    public $courseTrait;



    public function mount($slug)
    {

        $this->slug = $slug;
        $onlineRegistrationCourse = OnlineRegistrationCourse::where('slug', '=', $this->slug)->firstOrFail();
        $this->courseTrait = $onlineRegistrationCourse->name;

        $this->activeCourse = $onlineRegistrationCourse->active;
        $this->form = OnlineRegistrationForm::where('online_registration_course_id', '=', $onlineRegistrationCourse->id)->firstOrFail();
        $this->online_registration_course_id = $onlineRegistrationCourse->id;

        $this->bannerImage = $onlineRegistrationCourse->logo_file ?: null;

        $this->embebed_video = $onlineRegistrationCourse->embebed_video;
        $this->questions = OnlineRegistrationFormQuestion::where('or_form_id', '=', $this->form->id)
            ->get();
        $this->options = OnlineRegistrationFormOption::whereIn('question_id', $this->questions->pluck('id'))->get();
        $this->announcements = Announcement::all();
        $this->cant = count($this->questions) + 3;

        if (auth()->check() && auth()->user()->role_id == 7) {
            $this->count = 2;
            $contact = Contact::where('user_id', '=', Auth::user()->id)->first();
            $this->contactId = $contact->id;
        }
    }

    public function render()
    {
        return view('livewire.admin.online-registration-forms.online-registration-public-form-component')->layout('layouts.app-form');
    }

    public function nextQuestion()
    {
        // ✅ Validaciones para los primeros pasos
        if ($this->count == 1 && $this->contactId == '') {
            $this->validate([
                'nit' => 'required|numeric|unique:contacts,nit',
                'name' => 'required',
                'email' => ['required', 'email', 'unique:users,email'],
                'phone' => 'required',
                'contact_person_name' => 'required',
            ], [], [
                'nit' => 'NIT',
                'name' => 'nombre',
                'email' => 'correo electrónico',
                'phone' => 'teléfono',
                'contact_person_name' => 'persona de contacto'
            ]);
        }

        if ($this->count == 2) {
            $this->validate([
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'contact_person_name' => 'required'
            ], [], [
                'name' => 'nombre',
                'email' => 'correo electrónico',
                'phone' => 'teléfono',
                'contact_person_name' => 'persona de contacto'
            ]);
        }

        // ✅ Validación dinámica de respuestas a partir de la pregunta 3
        if ($this->count >= 3 && $this->count < $this->cant) {
            $questionIndex = $this->count - 3;

            if (isset($this->questions[$questionIndex])) {
                $question = $this->questions[$questionIndex];
                $answerKey = "answers.question_{$question->id}";
                $answerValue = $this->answers["question_{$question->id}"] ?? null;

                // 📌 Validación de acuerdo al tipo de pregunta
                if ($question->type == 'OM') {
                    // ✅ Checkboxes (Múltiples opciones) - Al menos una opción debe estar marcada
                    if (!is_array($answerValue) || count(array_filter($answerValue)) == 0) {
                        $this->addError($answerKey, 'Debes seleccionar al menos una opción.');
                        return;
                    } else {
                        $this->resetErrorBag($answerKey); // 🛑 Limpiar error si ya seleccionó una opción
                    }
                } elseif ($question->type == 'OS') {
                    // ✅ Radio (Opción única) - Debe haber una opción seleccionada
                    if ($answerValue === null || $answerValue === '') {
                        $this->addError($answerKey, 'Debes seleccionar una opción.');
                        return;
                    } else {
                        $this->resetErrorBag($answerKey); // 🛑 Limpiar error si ya seleccionó una opción
                    }
                } elseif ($question->type == 'AC' || $question->type == 'AL') {
                    // ✅ Input de texto o textarea - No puede estar vacío
                    if (empty($answerValue) || !is_string($answerValue) || trim($answerValue) === '') {
                        $this->addError($answerKey, 'Este campo no puede estar vacío.');
                        return;
                    } else {
                        $this->resetErrorBag($answerKey); // 🛑 Limpiar error si ya ingresó texto
                    }
                }
            }
        }

        // ✅ Avanzar solo si no hay errores
        if ($this->getErrorBag()->isNotEmpty()) {
            return;
        }


        if ($this->count < $this->cant) {
            $this->count++;
            $this->progress = round(($this->count / $this->cant) * 100);
            $this->message = '';
        }
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

    public function searchNit()
    {
        $this->validate([
            'nit' => 'required|string',
        ], [
            'nit.required' => 'El campo NIT/Cédula es obligatorio.',
        ]);

        /*   if (!$this->activeCourse) {
            return $this->addError('nit', 'Lo sentimos el curso ya no está activo');
        } */


        try {
            // Buscar la empresa/usuario por NIT
            $company = Contact::where('nit', $this->nit)->firstOrFail();

            // Guardar valores antiguos antes de asignar los nuevos
            $this->old_name = $company->name;
            $this->old_email = $company->email;
            $this->old_phone = $company->phone;
            $this->old_whatsapp = $company->whatsapp;
            $this->old_contact_person_name = $company->contact_person_name;
            $this->old_website = $company->website;

            // Asignar datos al formulario
            $this->nit = $company->nit;
            $this->name = $company->name;
            $this->email = $company->email;
            $this->phone = $company->phone;
            $this->whatsapp = $company->whatsapp;
            $this->contact_person_name = $company->contact_person_name;
            $this->website = $company->website;
            $this->contactId = $company->id;

            // Verificar si ya está inscrito en el curso actual
            $this->contactHasOnlineRegistrationCourse = OnlineRegistrationContactCourse::where('contact_id', $company->id)
                ->where('or_course_id', $this->online_registration_course_id)
                ->exists();

            $contactId = $company->id;

            $course = OnlineRegistrationCourse::find($this->online_registration_course_id);

            // Obtener la categoría del curso actual
            $categoryId = $course->onlineRegistrationCategory->id;

            // Obtener el último curso (de esa categoría) en el que el contacto se haya inscrito
            $lastCourse = OnlineRegistrationContactCourse::where('contact_id', $contactId)
                ->whereHas('onlineRegistrationCourse', function ($query) use ($categoryId) {
                    $query->where('or_category_id', $categoryId);
                })
                ->orderByDesc('created_at')
                ->first();

            $missedSessionsCount = 0;
            if ($lastCourse) {
                // Obtener las sesiones del último curso
                $lastCourseSessions = OnlineRegistrationCourseSession::where('or_course_id', $lastCourse->or_course_id)->get();

                // Comparar sesiones con asistencias del contacto
                $missedSessionsCount = $lastCourseSessions->filter(function ($session) use ($contactId) {
                    $attendee = OnlineRegistrationSessionAttendee::where('session_id', $session->id)
                        ->where('contact_id', $contactId)
                        ->first();
                    // Si no hay registro de asistencia o no asistió, consideramos que faltó
                    return !$attendee || !$attendee->attended;
                })->count();
            }

            // Si el usuario NO está registrado en el curso actual, permitir avanzar
            if ($lastCourse && !$this->contactHasOnlineRegistrationCourse) {
                $lastCourseDate = $lastCourse->onlineRegistrationCourse->created_at;
                $currentCourseDate = $course->created_at;

                // Contar cursos entre el último curso y el actual
                $newCoursesCount = OnlineRegistrationCourse::where('created_at', '>', $lastCourseDate)
                    ->where('created_at', '<=', $currentCourseDate)
                    ->where('or_category_id', $categoryId)
                    ->count();

                $limit = $lastCourse->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->course_limit;
                // 6. Comparar con el límite
                if ($missedSessionsCount >= 1) {
                    $limit += 1;
                }
                $this->canRegister = $newCoursesCount > $limit;
                $this->missingCourses = $limit - $newCoursesCount;

                if ($this->canRegister == true) {
                    $this->nextQuestion();
                }

                // Comparar con el límite incluyendo las sesiones no asistidas
                $this->canRegister = $newCoursesCount > $limit;

                if ($this->canRegister) {
                    $this->nextQuestion();
                }
            } elseif (!$this->contactHasOnlineRegistrationCourse) {
                // Si nunca ha estado inscrito en esta categoría, puede avanzar
                $this->canRegister = true;
                $this->count = 2;
                $this->progress = round(($this->count / $this->cant) * 100);
            } elseif ($this->contactHasOnlineRegistrationCourse) {
                // Ya está registrado en este curso exacto
                $this->addError('nit', 'Ya ha realizado el registro a este evento.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Limpiar campos si no se encuentra el usuario
            $this->updateProgress();
            $this->resetFormFields();
            $this->addError('nit', 'No existe registros con este NIT/Cédula.');
        }
    }



    private function resetFormFields()
    {
        $this->name = $this->email = $this->phone = $this->whatsapp = $this->contact_person_name = $this->website = '';
        $this->contactId = null;
        $this->contactHasOnlineRegistrationCourse = false;
    }

    /**
     * Actualiza el progreso de la inscripción si el usuario puede inscribirse
     */
    private function updateProgress()
    {
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
        $this->contactHasOnlineRegistrationCourse = false;
    }

    // private function saveAnswer($questionId, $answerValue)
    // {
    //     $answer = new OnlineRegistrationFormAnswer();
    //     $answer->contact_id = $this->contactId;
    //     $answer->or_form_id = $this->form->id;
    //     $answer->question_id = $questionId;
    //     $answer->answer = $answerValue;
    //     $answer->save();
    // }

    private function saveAnswer($questionId, $answerValue, $optionId = null)
    {
        // Guardar la respuesta en OnlineRegistrationFormAnswer
        $answer = new OnlineRegistrationFormAnswer();
        $answer->contact_id = $this->contactId;
        $answer->or_form_id = $this->form->id;
        $answer->question_id = $questionId;
        $answer->answer = is_array($answerValue) ? implode(',', $answerValue) : $answerValue;
        $answer->save();

        // Asegurar que optionIds sea un array, separando valores si es una cadena
        $optionIds = is_array($answerValue) ? $answerValue : explode(',', $answerValue);

        // Verificar si alguna opción tiene `conditional` y `characterization_id`
        foreach ($optionIds as $id) {
            $option = OnlineRegistrationFormOption::find(trim($id));

            if ($option && $option->conditional && $option->characterization_id) {
                $this->assignCharacterization($this->contactId, $option->characterization_id);
            }
        }
    }



    private function assignCharacterization($contactId, $characterizationId)
    {
        // Verificar si la asignación ya existe para evitar duplicados
        $exists = OrAssignedCharacterization::where('contact_id', $contactId)
            ->where('characterization_id', $characterizationId)
            ->exists();

        if (!$exists) {
            $assigned = new OrAssignedCharacterization();
            $assigned->contact_id = $contactId;
            $assigned->characterization_id = $characterizationId;
            $assigned->answered = false;
            $assigned->save();
        }
    }



    public function submit($formData)
    {

        if ($this->contactId) {
            $contact = Contact::find($this->contactId);

            // Buscar el usuario asociado al contacto
            $user = User::find($contact->user_id);

            // Comprobar si alguno de los datos ha cambiado
            if (
                $contact->name !== $this->name ||
                $contact->email !== $this->email ||
                $contact->phone !== $this->phone ||
                $contact->whatsapp !== $this->whatsapp ||
                $contact->contact_person_name !== $this->contact_person_name ||
                $contact->website !== $this->website
            ) {
                // Actualizar Contact
                $contact->update([
                    'name' => $this->name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'whatsapp' => $this->whatsapp,
                    'contact_person_name' => $this->contact_person_name,
                    'website' => $this->website
                ]);

                // Si el usuario existe y el nombre o email cambió, actualizarlo también
                if ($user) {
                    $user->update([
                        'name' => $this->name,
                        'email' => $this->email
                    ]);
                }
            }
        } elseif (!$this->contactId) {

            $contactExists = Contact::where('nit', $this->nit)->orWhere('email', $this->email)
                ->first();

            if ($contactExists) {
                $this->contactId = $contactExists->id;
                $contact = Contact::find($this->contactId);

                // Buscar el usuario asociado al contacto
                $user = User::find($contact->user_id);

                // Comprobar si alguno de los datos ha cambiado
                if (
                    $contact->name !== $this->name ||
                    $contact->email !== $this->email ||
                    $contact->phone !== $this->phone ||
                    $contact->whatsapp !== $this->whatsapp ||
                    $contact->contact_person_name !== $this->contact_person_name ||
                    $contact->website !== $this->website
                ) {
                    // Actualizar Contact
                    $contact->update([
                        'name' => $this->name,
                        'email' => $this->email,
                        'phone' => $this->phone,
                        'whatsapp' => $this->whatsapp,
                        'contact_person_name' => $this->contact_person_name,
                        'website' => $this->website
                    ]);

                    // Si el usuario existe y el nombre o email cambió, actualizarlo también
                    if ($user) {
                        $user->update([
                            'name' => $this->name,
                            'email' => $this->email
                        ]);
                    }
                }
            } elseif (!$contactExists) {
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
            }

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
        $formData['online_registration_form_id'] = $this->form->id;

        foreach ($this->questions as $question) {
            $questionKeyBase = 'question_' . $question->id;

            // Buscar claves en el formulario relacionadas con la pregunta
            $matchingKeys = array_filter(array_keys($formData), function ($key) use ($questionKeyBase) {
                return strpos($key, $questionKeyBase) === 0;
            });

            if (empty($matchingKeys)) {
                // Preguntas abiertas o de opción única
                if (isset($formData[$questionKeyBase])) {
                    $this->saveAnswer($question->id, $formData[$questionKeyBase], null);
                }
            } else {
                // Preguntas de opción múltiple (checkbox) -> Guardar todas en un solo registro
                $selectedOptions = [];
                foreach ($matchingKeys as $key) {
                    $selectedOptions[] = $formData[$key];
                }

                // Convertir en una sola cadena separada por comas (puedes usar otro separador si prefieres)
                $answerString = implode(',', $selectedOptions);

                // Guardar en un solo registro
                $this->saveAnswer($question->id, $answerString, null);
            }
        }

        $onlineRegistrationContactCourse = new OnlineRegistrationContactCourse();
        $onlineRegistrationContactCourse->contact_id = $this->contactId;
        $onlineRegistrationContactCourse->or_course_id = $this->online_registration_course_id;
        $onlineRegistrationContactCourse->certificate = $this->certificate;
        $onlineRegistrationContactCourse->save();

        $contactInfo = Contact::find($this->contactId);
        $online_registration_course_info = OnlineRegistrationCourse::find($this->online_registration_course_id);
        //dd($contactInfo);

        // WAsender::dispatch('+57' . $contactInfo->phone, 'Felicitaciones, has diligenciado correctamente el formulario: ' . $online_registration_course_info->name . ' del proceso ' . $online_registration_course_info->onlineRegistrationCategory->onlineRegistration->name . ', inicia tu aventura ahora mismo en el nido de saberes.');
        // NewSendEmailJob::dispatch($contactInfo->email, 'Registro formulario: ' . $online_registration_course_info->name . ' del proceso: ' . $online_registration_course_info->onlineRegistrationCategory->onlineRegistration->name, 'Felicitaciones, has diligenciado correctamente el formulario: ' . $online_registration_course_info->name . ' del proceso ' . $online_registration_course_info->onlineRegistrationCategory->onlineRegistration->name . ', inicia tu aventura ahora mismo en el nido de saberes.');

        $this->finish = true;

        $this->emit('showLoader');
    }
    public function validateCourseLimit()
    {
        $contact = Contact::find($this->contactId);
        dd($contact);
        $courseCount = OnlineRegistrationContactCourse::where('contact_id', $contact->id)
            ->where('or_course_id', $this->online_registration_course_id)
            ->count();
    }
}
