<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses\OnlineRegistrationCertificateEmails;

use App\Contact;
use App\Models\OnlineRegistrationCourse;
use App\EmailTemplate;
use App\Jobs\OrSendCertificateEmailJob;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;

class OnlineRegistrationCertificateEmailsComponent extends Component
{

    public $emailId;

    public
        $contactId,
        $to,
        $cc = array(),
        $cco = array(),
        $subject,
        $content,
        $template,
        $status;

    public $contactEmail, $courseId, $courseInfo;

    public $errorMsjTo,
        $errorMsjCc,
        $errorMsjCco;

    public $contacts = [];


    public function mount($courseId, $id)
    {

        $this->courseId = $courseId;

        $this->courseInfo = OnlineRegistrationCourse::find($courseId);

        $this->contacts = Contact::all();

        $this->contactEmail = Contact::find($id);


        $this->to =  $this->contactEmail->email;
        $this->contactId = $this->contactEmail->id;
    }


    public function render()
    {
        $templates = EmailTemplate::all();
        return view('livewire.admin.online-registration-courses.online-registration-certificate-emails.online-registration-certificate-emails-component', [
            'templates' => $templates,
        ]);
    }

    public function addCc($value)
    {
        $validator = Validator::make(['email' => $value], [
            'email' => 'required|email'
        ]);

        if ($validator->passes()) {

            $validate = checkEmail($value);
            if ($validate == 1) {
                if (($key = array_search($value, $this->cc)) !== false) {
                    $this->errorMsjCc = 'Dirección de correo ya agregada.';
                } else {
                    $this->errorMsjCc = '';
                    array_push($this->cc, $value);
                }
            } else {
                $this->errorMsjCc = $validate;
            }
        } else {
            $this->errorMsjCc = 'Dirección de correo invalida.';
        }
    }

    public function removeCc($value)
    {
        $value = substr($value, 0, -1);
        if (($key = array_search($value, $this->cc)) !== false) {
            unset($this->cc[$key]);
        }

        $this->cc = array_values($this->cc);
    }

    public function addCco($value)
    {
        $validator = Validator::make(['email' => $value], [
            'email' => 'required|email'
        ]);

        if ($validator->passes()) {

            $validate = checkEmail($value);
            if ($validate == 1) {
                if (($key = array_search($value, $this->cco)) !== false) {
                    $this->errorMsjCco = 'Dirección de correo ya agregada.';
                } else {
                    $this->errorMsjCco = '';
                    array_push($this->cco, $value);
                }
            } else {
                $this->errorMsjCco = $validate;
            }
        } else {
            $this->errorMsjCco = 'Dirección de correo invalida.';
        }
    }

    public function removeCco($value)
    {
        $value = substr($value, 0, -1);
        if (($key = array_search($value, $this->cco)) !== false) {
            unset($this->cco[$key]);
        }

        $this->cco = array_values($this->cco);
    }

    public function updatedTemplate($id)
    {
        if ($id != '') {
            $template = EmailTemplate::find($id);
            $this->content = $template->content;
            $this->emit('cke');
        }
    }

    public function send()
    {
        $this->validate([
            'to' => 'required|email',
            'subject' => 'required',
            'content' => 'required'
        ], [
            'content.required' => 'El contenido del correo no debe estar vacío'
        ], [
            'to' => 'destinatario',
            'subject' => 'asunto'
        ]);

        $content = $this->content;

        if ($this->contactId) {
            $contact = Contact::find($this->contactId);

            $vars = [
                '{{nit}}',
                '{{name}}',
                '{{address}}',
                '{{phone}}',
                '{{email}}',
                '{{whatsap}}',
                '{{website}}',
                '{{contact_person_name}}',
                '{{contact_person_email}}',
                '{{leader_name}}',
                '{{leader_email}}',
                '{{leader_phone}}'
            ];

            $info = [
                $contact->nit,
                $contact->name,
                $contact->address,
                $contact->phone,
                $contact->email,
                $contact->whatsap,
                $contact->website,
                $contact->contact_person_name,
                $contact->contact_person_email,
                $contact->leader_name,
                $contact->leader_email,
                $contact->leader_phone,
            ];

            foreach ($vars as $i => $var) {
                $content = str_replace($var, $info[$i], $content);
            }
        }

        OrSendCertificateEmailJob::dispatch($this->to, $this->subject, $content, $this->cc, $this->cco);
        return redirect()->route('online-registration-contacts-certificate', ['id' => $this->courseId])
            ->with('success', 'Correo enviado exitosamente.');
        //session()->flash('success', 'Correo enviado exitosamente.');
    }

   /*   public function send()
    {
        $this->validate([
            'to' => 'required|email',
            'subject' => 'required',
            'content' => 'required'
        ], [
            'content.required' => 'El contenido del correo no debe estar vacío'
        ], [
            'to' => 'destinatario',
            'subject' => 'asunto'
        ]);

        $content = $this->content;

        if ($this->contactId) {
            $contact = Contact::find($this->contactId);

            $vars = [
                '{{nit}}',
                '{{name}}',
                '{{address}}',
                '{{phone}}',
                '{{email}}',
                '{{whatsap}}',
                '{{website}}',
                '{{contact_person_name}}',
                '{{contact_person_email}}',
                '{{leader_name}}',
                '{{leader_email}}',
                '{{leader_phone}}'
            ];

            $info = [
                $contact->nit,
                $contact->name,
                $contact->address,
                $contact->phone,
                $contact->email,
                $contact->whatsap,
                $contact->website,
                $contact->contact_person_name,
                $contact->contact_person_email,
                $contact->leader_name,
                $contact->leader_email,
                $contact->leader_phone,
            ];

            foreach ($vars as $i => $var) {
                $content = str_replace($var, $info[$i], $content);
            }
        }

        // Aquí enviamos el correo directamente, sin usar colas
        $data = [
            'subject' => $this->subject,
            'email' => $this->to,
            'content' => $content,
        ];

        try {
            Mail::send('mails.or-send-email-template', $data, function ($message) {
                $message->to($this->to)
                    ->subject($this->subject)
                    ->from(env('MAIL_USERNAME'), setting('admin.title'));

                if (!empty($this->cc)) {
                    $message->cc($this->cc);
                }

                if (!empty($this->cco)) {
                    $message->bcc($this->cco);
                }
            });

            session()->flash('success', 'Correo enviado exitosamente.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al enviar el correo: ' . $e->getMessage());
        }
    } */
}
