<?php

namespace App\Http\Controllers\API;

use App\Announcement;
use App\Contact;
use App\CommercialForm;
use App\AnnouncementsForm;
use Illuminate\Http\Request;
use App\CommercialFormAction;
use App\CommercialFormOption;
use App\CommercialFormQuestion;
use App\AnnouncementsFormsOption;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiFormController extends Controller
{
    public function getForm($token)
    {
        $action = CommercialFormAction::where('token', '=', $token)->first();
        $form = CommercialForm::find($action->commercial_form_id);
        $questions = CommercialFormQuestion::where('commercial_form_id', '=', $form->id)->get();
        $options = CommercialFormOption::all();

        $data = [
            "form" => [
                "title" => $form->name,
                "description" => $form->description
            ],
            "questions" => []
        ];

        foreach ($questions as $question) {
            if ($question->type == 'po') {
                array_push($data["questions"], [
                    "id" => $question->id,
                    "key" => "question_" . $question->id,
                    "question" => $question->question,
                    "type" => $question->type,
                    "options" => []
                ]);
            } else {
                array_push($data["questions"], [
                    "id" => $question->id,
                    "key" => "question_" . $question->id,
                    "question" => $question->question,
                    "type" => $question->type,
                ]);
            }
        }

        foreach ($data["questions"] as $key => $value) {
            if ($question["type"] == 'po') {
                foreach ($options as $option) {
                    if ($value["id"] == $option->commercial_form_question_id) {
                        array_push($data["questions"][$key]["options"], [
                            "option" => $option->option,
                            "value" => $option->value
                        ]);
                    }
                }
            }
        }

        return response()->json(['form-widget' => $data], 200);
    }


    public function store($token, Request $request)
    {

        $actionForm = CommercialFormAction::where('token', '=', $token)->first();
        $form = CommercialForm::find($actionForm->commercial_form_id);


        $validator = Validator::make($request->all(), [
            'nit' => 'required|numeric',
            'name' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'whatsapp' => 'required|numeric',
            'website' => 'required|url',
            'contact_person_name' => 'required',
            'question_.*' => 'required'
        ], [], [
            'nit' => 'NIT',
            'name' => 'nombre de la empresa',
            'phone' => 'teléfono',
            'email' => 'correo electrónico',
            'whatsapp' => 'Whatsapp',
            'website' => 'página web',
            'contact_person_name' => 'nombre de persona de contacto',
            'question_.*' => 'pregunta'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'response' => $validator->errors()
            ], 401);
        } else {
            $contact = new Contact();
            $contact->nit = $request->nit;
            $contact->name = $request->name;
            $contact->phone = $request->phone;
            $contact->email = $request->email;
            $contact->whatsapp = $request->whatsapp;
            $contact->website = $request->website;
            $contact->contact_person_name = $request->contact_person_name;
            $contact->form_action_id = $actionForm->id;
            $contact->commercial_form_id=$actionForm->commercial_form_id;
            $contact->commercial_action_id=$actionForm->commercial_action_id;
            $contact->storage = "api";
            $contact->save();

            $request->request->remove('_token');
            $request->request->remove('nit');
            $request->request->remove('name');
            $request->request->remove('phone');
            $request->request->remove('email');
            $request->request->remove('whatsapp');
            $request->request->remove('website');
            $request->request->remove('contact_person_name');

            $array = $request->all();
            $array['contact_id'] = $contact->id;
            $array['commercial_action_id'] = $actionForm->commercial_action_id;
            $array['created_at'] = date('Y-m-d h:i:s');
            $array['updated_at'] = date('Y-m-d h:i:s');

            DB::table('answers_form_' . $form->id)->insert($array);

            //Convocations

            $anContact = [];
            $announcements = AnnouncementsForm::where('commercial_form_id', '=', $form->id)
                ->get();

            if (count($announcements) > 0) {
                foreach ($announcements as $announcement) {

                    $options = AnnouncementsFormsOption::where('announcement_form_id', '=', $announcement->id)
                        ->get();

                    if (count($options) > 0) {
                        $convoque = true;
                        foreach ($options as $option) {
                            if ($array['question_' . $option->commercial_question_id] != $option->value) {
                                $convoque = false;
                            }
                        }

                        if ($convoque == true) {
                            array_push($anContact, $announcement->announcement_id);
                        }
                    }
                }
            }

            $convocations=[];

            if($anContact!=[]){
                $convocations=Announcement::select('name','description')->where('id',$anContact)->get();
            }

            return response()->json([
                'error' => false,
                'message' => "Create succesfully",
                'response' => $contact,
                'convocations' => $convocations
            ], 200);
        }
    }
}
