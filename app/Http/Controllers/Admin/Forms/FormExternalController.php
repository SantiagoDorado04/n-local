<?php

namespace App\Http\Controllers\Admin\Forms;

use App\Announcement;
use App\AnnouncementsForm;
use App\AnnouncementsFormsOption;
use App\Contact;
use App\CommercialForm;
use Illuminate\Http\Request;
use App\CommercialFormAction;
use App\CommercialFormOption;
use App\CommercialFormQuestion;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class FormExternalController extends Controller
{
    public function index($token, $announcementsContact=NULL)
    {
        $actionForm=CommercialFormAction::where('token','=',$token)->first();
        $form = CommercialForm::find($actionForm->commercial_form_id);
        $questions = CommercialFormQuestion::where('commercial_form_id', '=', $form->id)
            ->where('visibility', '=', '1')
            ->get();
        $options = CommercialFormOption::all();
        $announcements=Announcement::all();
        $anContact=unserialize(urldecode($announcementsContact));

        
        return view('form.index',[
            'token'=>$token,
            'form'=>$form,
            'questions'=>$questions,
            'options'=>$options,
            'announcements'=>$announcements,
            'anContact'=>$anContact
        ]);
    }

    public function store($token, Request $request){

        $actionForm=CommercialFormAction::where('token','=',$token)->first();
        $form = CommercialForm::find($actionForm->commercial_form_id);

        $this->validate($request,[
            'nit'=>'required|numeric',
            'name'=>'required',
            'phone'=>'required|numeric',
            'email'=>'required|email',
            'whatsapp'=>'required|numeric',
            'website'=>'required|url',
            'contact_person_name'=>'required',
            'question_.*'=>'required'
        ],[],[
            'nit'=>'NIT',
            'name'=>'nombre de la empresa',
            'phone'=>'teléfono',
            'email'=>'correo electrónico',
            'whatsapp'=>'Whatsapp',
            'website'=>'página web',
            'contact_person_name'=>'nombre de persona de contacto',
            'question_.*'=>'pregunta'
        ]);

        $contact = new Contact();
        $contact->nit = $request->nit;
        $contact->name = $request->name;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->whatsapp = $request->whatsapp;
        $contact->website = $request->website;
        $contact->contact_person_name = $request->contact_person_name;
        $contact->form_action_id=$actionForm->id;
        $contact->storage="form";
        $contact->save();

        $request->request->remove('_token');
        $request->request->remove('nit');
        $request->request->remove('name');
        $request->request->remove('phone');
        $request->request->remove('email');
        $request->request->remove('whatsapp');
        $request->request->remove('website');
        $request->request->remove('contact_person_name');

        $array=$request->all();
        $array['contact_id'] = $contact->id;
        $array['commercial_action_id'] = $actionForm->commercial_action_id;
        $array['created_at'] = date('Y-m-d h:i:s');
        $array['updated_at'] = date('Y-m-d h:i:s');

        DB::table('answers_form_' . $form->id)->insert($array);


        //Convocations

        $anContact=[];
        $announcements=AnnouncementsForm::where('commercial_form_id','=',$form->id)
        ->get();

        if(count($announcements)>0){
            foreach ($announcements as $announcement) {

                $options=AnnouncementsFormsOption::where('announcement_form_id','=',$announcement->id)
                ->get();

                if(count($options)>0){
                    $convoque=true;
                    foreach ($options as $option) {
                        if($array['question_'.$option->commercial_question_id]!=$option->value){
                            $convoque=false;
                        }
                    }

                    if($convoque==true){
                        array_push($anContact,$announcement->announcement_id);
                    }
                }
            
            }
        }
        
        return redirect()->route('commercial.form-external',['token'=>$token,'announcementsContact'=>urlencode(serialize($anContact))])->with('success', 'Formulario enviado correctamente!');
    }
}
