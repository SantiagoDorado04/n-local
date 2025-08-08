<?php

namespace App\Http\Livewire\Admin\Forms;

/* php artisan make:livewire Admin/Forms/ExternalFormComponent */

use App\Contact;
use App\Models\User;
use App\Announcement;
use App\CommercialForm;
use Livewire\Component;
use App\AnnouncementsForm;
use App\Jobs\SendEmailForm;
use App\Jobs\SendEmailUser;
use App\CommercialFormAction;
use App\CommercialFormOption;
use App\CommercialFormQuestion;
use App\AnnouncementsFormsOption;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ExternalFormComponent extends Component
{

    //vars mount function 
    public $token,
        $actionForm,
        $form,
        $questions,
        $options,
        $announcements,
        $cant = 0;

    //var step and progress bar
    public $count = 1;
    public $progress = 0;

    //vars contact info
    public $nit,
        $name,
        $email,
        $phone,
        $whatsapp,
        $contact_person_name,
        $website;

    //vars validation input dinamyc
    public $input, $message = '';

    //var if finish form
    public $finish = false;

    //List convocations result
    public $anContact = [];

    protected $listeners = ['getQuestion', 'nextQuestion'];

    public $contactId;

    public function mount($token)
    {
        $this->token = $token;
        $this->actionForm = CommercialFormAction::where('token', '=', $this->token)->first();

        /* If the token does not relate to any form returns not found, 404 */
        if ($this->actionForm == '') {
            abort(404);
        }

        /* Get form and questions */
        $this->form = CommercialForm::find($this->actionForm->commercial_form_id);
        $this->questions = CommercialFormQuestion::where('commercial_form_id', '=', $this->form->id)
            ->where('visibility', '=', '1')
            ->get();
        $this->options = CommercialFormOption::all();

        $this->announcements = Announcement::all();

        /* Amount of steps, first 2 windows plus the amount of dynamic questions */
        $this->cant = count($this->questions) + 2;

        if (auth()->check() && auth()->user()->role_id == 7) {
            $this->count=2;
            $contact = Contact::where('user_id', '=', Auth::user()->id)->first();
            $this->contactId=$contact->id;
   
        }
    }


    public function render()
    {
        return view('livewire.admin.forms.external-form-component')
            ->layout('layouts.app-form');
    }

    /**
     * The function validates the information of the company in the first window, and then it increases
     * the count and progress variables, and hides the validation message
     */
    public function nextQuestion()
    {
        /* If the company's information is validate in the first window */
        if ($this->count == 1) {
            $this->validate([
                'nit' => 'required|numeric|unique:contacts,nit',
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
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

        /* Next sum and progress, hides the validation message */
        $this->count++;
        $this->progress = round(($this->count / $this->cant) * 100);
        $this->message = '';
    }

    public function previousQuestion()
    {
        /* Return to the previous step and the progress remains */
        $this->count--;
        $this->progress = round(($this->count / $this->cant) * 100);
    }

    /**
     * > Get the ID of the question in which it is found and send it to the front to validate that it
     * is not empty
     */
    public function getQuestion()
    {
        /* Get the ID of the question in which it is found and send it to the front to validate that it is not empty */
        $question = $this->questions[$this->count - 3];
        $this->input = $question->id;
        $this->emit('sendQuestion', [$this->input, $question->type]);
    }

    public function submit($formData)
    {
        
        if($this->contactId==''){
        
            /* Save contact data */
            $contact = new Contact();
            $contact->nit = $this->nit;
            $contact->name = $this->name;
            $contact->phone = $this->phone;
            $contact->email = $this->email;
            $contact->whatsapp = $this->whatsapp;
            $contact->website = $this->website;
            $contact->contact_person_name = $this->contact_person_name;
            $contact->form_action_id = $this->actionForm->id;
            $contact->commercial_form_id=$this->actionForm->commercial_form_id;
            $contact->commercial_action_id=$this->actionForm->commercial_action_id;
            $contact->storage = "form";
            $contact->save();

            $this->contactId=$contact->id;

            $user =  new User();
            $user->name=  $this->name;
            $user->email = $this->email;
            $user->password = Hash::make($this->nit);
            $user->role_id = '7';
            $user->save();

            $contact->user_id = $user->id;
            $contact->update();

            $data2 = [
                'email'=>$contact->email,
                'subject'=>'Registro plataforma Nido de Saberes',
                'name'=>$contact->name
            ];
    
            dispatch(new SendEmailUser($data2));
        }

        /* Eliminate Array's contact data so that only questions are left */
        unset($formData['nit']);
        unset($formData['name']);
        unset($formData['phone']);
        unset($formData['email']);
        unset($formData['whatsapp']);
        unset($formData['website']);
        unset($formData['contact_person_name']);

        /* Add the form information to Array */
        $formData['contact_id'] = $this->contactId;
        $formData['commercial_action_id'] = $this->actionForm->commercial_action_id;
        $formData['created_at'] = date('Y-m-d h:i:s');
        $formData['updated_at'] = date('Y-m-d h:i:s');

        /* Save the responses of the form in the table */
        DB::table('answers_form_' . $this->form->id)->insert($formData);


        /* Validate according to the results to which calls applies */
        $anContact = [];
        $announcements = AnnouncementsForm::where('commercial_form_id', '=', $this->form->id)
            ->get();

        if (count($announcements) > 0) {
            foreach ($announcements as $announcement) {
                
                $options = AnnouncementsFormsOption::where('announcement_form_id', '=', $announcement->id)
                    ->get();

                    
                    
                if (count($options) > 0) {
                    $convoque = false;
                    foreach ($options as $option) {
                        if ($formData['question_' . $option->commercial_question_id] != $option->value) {
                            $convoque = true;
                        }
                    }

                    if ($convoque == true) {
                        array_push($this->anContact, $announcement->announcement_id);
                    }
                }
            }
        }

        $contact = Contact::find($this->contactId);
        $form = CommercialForm::find($this->form->id);

        $convocations = [];

        foreach ($this->anContact as $item){
            foreach ($this->announcements as $announcement){
                if($item == $announcement->id){
                    array_push($convocations, $announcement->name);
                }
            }
        }

        $data = [
            'email'=>$contact->email,
            'subject'=>'Diligenciamiento formulario - '.$form->name,
            'convocations'=>$convocations,
            'name'=>$contact->name,
            'form'=>$form->name
        ];

        dispatch(new SendEmailForm($data));

        $data2 = [
            'email'=>$contact->email,
            'subject'=>'Registro plataforma Nido de Saberes',
            'name'=>$contact->name
        ];

        dispatch(new SendEmailUser($data2));



        /* Marks as finished to show the Loader and the final view with the information of the calls */
        $this->finish = true;
        $this->emit('showLoader');
    }
}

