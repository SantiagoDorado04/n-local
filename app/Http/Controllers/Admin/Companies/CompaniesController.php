<?php

namespace App\Http\Controllers\Admin\Companies;

use App\Contact;
use App\BusinessModel;
use App\CommercialForm;
use App\ProductsService;
use Illuminate\Http\Request;
use App\CommercialFormAction;
use App\ContactsAssignedForm;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Innovation;
use App\Models\Project;
use App\Models\Impact;
use App\Models\Scaling;
use App\Technology;
use PSpell\Config;

class CompaniesController extends Controller
{
    public function infoCompany($id)
    {
        $company = Contact::with("attachments")->find($id);


        return view("admin.companies.index", [
            'company' => $company

        ]);
    }

    public function productsServices($id)
    {
        $company = Contact::find($id);
        $productsServices = ProductsService::with(("files"))->where('contact_id', '=', $id)->get();

        return view("admin.companies.products-services", [
            'productsServices' => $productsServices,
            'company' => $company

        ]);
    }

    public function assignedForms($id)
    {
        $company = Contact::find($id);
        $assignedForms = ContactsAssignedForm::where("contact_id", '=', $id)->get();

        return view("admin.companies.assigned-forms", [
            'assignedForms' => $assignedForms,
            'company' => $company

        ]);
    }

    public function answersForm($id)
    {

        $assign = ContactsAssignedForm::find($id);
        $company = Contact::find($assign->contact_id);
        $commercialFormAction = $assign->commercialFormAction;
        $commercialForm = $commercialFormAction->commercialForm;

        $form = CommercialForm::find($commercialForm->id);
        $result = DB::table('answers_form_' . $commercialForm->id)->where('contact_id', '=', $assign->contact_id)->get();


        return view("admin.companies.answers-form", [
            'result' => $result,
            'form' => $form,
            'company' => $company

        ]);
    }

    public function businessModels($id)
    {
        $company = Contact::find($id);
        $businessModels = BusinessModel::where("contact_id", '=', $id)->get();

        return view("admin.companies.business-models", [
            'businessModels' => $businessModels,
            'company' => $company

        ]);
    }

    public function viability($id){
        $project = Project::find($id);

        return view("admin.companies.viability", [
            'project' => $project
        ]);

    }

    public function innovation($id){
        $project = Project::with('innovations')->find($id);
        $innovation = Innovation::with('technologies')->where("project_id", '=', $id)->first();


        return view("admin.companies.innovation", [
            'project' => $project,
            'innovation' => $innovation

        ]);

    }

    public function scale($id){
        $project = Project::find($id);
        $scale = Scaling::find($id);

        return view("admin.companies.scale", [
            'project' => $project,
            'scale' => $scale

        ]);

    }

    public function impact($id){
        $project = Project::find($id);
        $impact = Impact::with('attachments')->find($id);

        return view("admin.companies.impact", [
            'project' => $project,
            'impact' => $impact
        ]);

    }
}
