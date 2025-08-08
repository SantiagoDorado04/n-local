<?php

namespace App\Http\Livewire\Admin\CommercialManagement\MailingIndividual;

use App\Contact;
use App\EmailTemplate;
use Livewire\Component;
use App\IndividualEmail;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class MailingIndividualComponent extends Component
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

    public $errorMsjTo,
        $errorMsjCc,
        $errorMsjCco;

    public $contacts = [];

    public function mount($id = NULL)
    {
        $this->contacts = Contact::all();

        if ($id != '') {
            $email = IndividualEmail::find($id);
            $this->emailId = $email->id;

            $this->to = $email->to;
            $this->contactId = $email->contact_id;
            if ($email->cc != '') {
                $this->cc = json_decode($email->cc);
            }
            if ($email->cco != '') {
                $this->cco = json_decode($email->cco);
            }
            $this->subject = $email->subject;
            $this->content = $email->content;
            $this->status = $email->status;
        }
    }

    public function render()
    {
        $contacts = Contact::all();
        $templates = EmailTemplate::all();
        return view('livewire.admin.commercial-management.mailing-individual.mailing-individual-component', [
            'contacts' => $contacts,
            'templates' => $templates

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
            $this->errorMsjCc = 'Dirección de correo invalida.';
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

        if (empty($this->emailId)) {

            $email = new IndividualEmail();
            $email->from = env('MAIL_USERNAME');
            $email->to = $this->to;
            if (!empty($this->cc)) {
                $email->cc = json_encode($this->cc);
            }
            if (!empty($this->cco)) {
                $email->cco = json_encode($this->cco);
            }
            $email->subject = $this->subject;
            $email->content = $this->content;
            $email->send_date = date('Y-m-d H:i:s');
            $email->status = 'sent';
            if ($this->contactId) {
                $email->contact_id = $this->contactId;
            }
            $email->created_by = Auth::user()->id;
            $email->save();
        } else {
            $email = IndividualEmail::find($this->emailId);
            $email->from = env('MAIL_USERNAME');
            $email->to = $this->to;
            if (!empty($this->cc)) {
                $email->cc = json_encode($this->cc);
            }
            if (!empty($this->cco)) {
                $email->cco = json_encode($this->cco);
            }
            $email->subject = $this->subject;
            $email->content = $this->content;
            $email->send_date = date('Y-m-d H:i:s');
            $email->status = 'sent';
            if ($this->contactId) {
                $email->contact_id = $this->contactId;
            }
            $email->created_by = Auth::user()->id;
            $email->update();
        }

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

            $content = $this->content;

            $cont = 0;
            foreach ($vars as $var) {
                $content = str_replace($var, $info[$cont], $content);
                $cont++;
            }
        }

        $data = [
            'email' => $this->to,
            'cc' => $this->cc,
            'cco' => $this->cco,
            'subject' => $this->subject,
            'content' => $content,
            'email_id' => $email->id
        ];

        dispatch(new SendEmailJob($data));

        Session::flash('mensaje', ' Correo electrónico enviado correctamente');
        Session::flash('tipo_mensaje', 'success');

        return redirect()->route('mailing.individual.outbox');
    }

    public function draft()
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

        $email = new IndividualEmail();
        $email->from = env('MAIL_USERNAME');
        $email->to = $this->to;
        if (!empty($this->cc)) {
            $email->cc = json_encode($this->cc);
        }
        if (!empty($this->cco)) {
            $email->cco = json_encode($this->cco);
        }
        $email->subject = $this->subject;
        $email->content = $this->content;
        $email->send_date = date('Y-m-d H:i:s');
        $email->status = 'sent';
        if ($this->contactId) {
            $email->contact_id = $this->contactId;
        }
        $email->created_by = Auth::user()->id;

        if (empty($this->emailId)) {
            $email->save();
        } else {
            $email->id = $this->emailId;
            $email->update();
        }

        Session::flash('mensaje', ' Borrador guardado correctamente');
        Session::flash('tipo_mensaje', 'success');

        return redirect()->route('mailing.individual.outbox');
    }

    public function updatedContactId($id)
    {
        if ($id != '') {
            $contact = Contact::find($id);

            $this->to = $contact->email;
        }
    }
}
