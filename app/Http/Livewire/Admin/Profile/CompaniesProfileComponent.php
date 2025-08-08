<?php

namespace App\Http\Livewire\Admin\Profile;

use App\Contact;
use App\CompanyType;
use App\CompanyCharge;
use App\EconomicSector;
use Livewire\Component;
use App\ContactsAttachment;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CompaniesProfileComponent extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;

    public $company=[],
        $nit,
        $name,
        $main_sector,
        $secondary_sector,
        $company_type_id,
        $address,
        $city_id,
        $phone,
        $whatsapp,
        $email,
        $website,
        $contact_person_name,
        $contact_person_email,
        $leader_name,
        $leader_position,
        $leader_email,
        $leader_phone,
        $leader_gender,
        $leader_age,
        $companyId;

    public $sectors=[],
        $companyTypes=[],
        $charges;

    public $attachment, $attachment_name, $attachmentId;

    public function mount(){
        $this->company= Contact::where('user_id','=',Auth::user()->id)->first();
        if($this->company!=[]){
            $this->companyId=$this->company->id;
            $this->nit = $this->company->nit;
            $this->name = $this->company->name;
            $this->main_sector = $this->company->main_sector;
            $this->secondary_sector = $this->company->secondary_sector;
            $this->company_type_id = $this->company->company_type_id;
            $this->address = $this->company->address;
            $this->city_id = $this->company->city_id;
            $this->phone = $this->company->phone;
            $this->whatsapp = $this->company->whatsapp;
            $this->email = $this->company->email;
            $this->website = $this->company->website;
            $this->contact_person_name = $this->company->contact_person_name;
            $this->contact_person_email = $this->company->contact_person_email;
            $this->leader_name = $this->company->leader_name;
            $this->leader_position = $this->company->leader_position;
            $this->leader_email = $this->company->leader_email;
            $this->leader_phone = $this->company->leader_phone;
            $this->leader_gender = $this->company->leader_gender;
            $this->leader_age = $this->company->leader_age;            
        }
        $this->sectors=EconomicSector::all();
        $this->companyTypes=CompanyType::all();
        $this->charges=CompanyCharge::all();
    }
    
    public function render()
    {
        return view('livewire.admin.profile.companies-profile-component');
    }

    public function update(){
        $this->validate([
            'nit'=>'required|numeric',
            'name'=>'required',
            'main_sector'=>'required',
            'company_type_id'=>'required',
            'address'=>'required',
            'phone'=>'required',
            'email'=>'required|email',
            'contact_person_name'=>'required',
            'contact_person_email'=>'required',
            'leader_name'=>'required',
            'leader_position'=>'required',
            'leader_email'=>'required',
            'leader_phone'=>'required',
            'leader_gender'=>'required',
            'leader_age'=>'required',
        ],[],[
            'nit'=>'NIT',
            'name'=>'razón social',
            'main_sector'=>'sector primario',
            'company_type_id'=>'tipo de empresa',
            'address'=>'dirección',
            'phone'=>'teléfono',
            'email'=>'correo electrónico',
            'contact_person_name'=>'nombre persona de contacto',
            'contact_person_email'=>'correo electrónico persona de contacto',
            'leader_name'=>'nombre líder del proyecto',
            'leader_position'=>'cargo líder del proyecto',
            'leader_email'=>'género líder del proyecto',
            'leader_phone'=>'teléfono líder del proyecto',
            'leader_gender'=>'correo electrónico líder del proyecto',
            'leader_age'=>'edad líder del proyecto',
        ]);

        $company=Contact::find($this->companyId);
        $company->nit = $this->nit;
        $company->name = $this->name;
        $company->main_sector = $this->main_sector;
        $company->secondary_sector = $this->secondary_sector;
        $company->company_type_id = $this->company_type_id;
        $company->address = $this->address;
        $company->city_id = $this->city_id;
        $company->phone = $this->phone;
        $company->whatsapp = $this->whatsapp;
        $company->email = $this->email;
        $company->website = $this->website;
        $company->contact_person_name = $this->contact_person_name;
        $company->contact_person_email = $this->contact_person_email;
        $company->leader_name = $this->leader_name;
        $company->leader_position = $this->leader_position;
        $company->leader_email = $this->leader_email;
        $company->leader_phone = $this->leader_phone;
        $company->leader_gender = $this->leader_gender;
        $company->leader_age = $this->leader_age;
        $company->update();

        Session::flash('mensaje', 'Información de la empresa actualizada correctamente');
        Session::flash('tipo_mensaje', 'success');

        return redirect()->route('company.profile');
    }

    public function upload(){
        $this->validate([
            'attachment'=>'required|file|mimes:pdf',
            'attachment_name'=>'required'   
        ],[],[
            'attachment'=>'archivo adjunto',
            'attachment_name'=>'nombre del adjunto'  
        ]);

        $extension = $this->attachment->getClientOriginalExtension();
        $name=str_replace(' ', '-', (strtolower($this->attachment_name).    '.'.$extension));

        $path = $this->attachment->storeAs('public/attachments', $name);
        $attachment= new ContactsAttachment();
        $attachment->url=$path;
        $attachment->name=$this->attachment_name;
        $attachment->contact_id=$this->companyId;
        $attachment->save();

        $this->attachment_name = '';
        $this->companyId = '';

        Session::flash('mensaje', 'Adjunto subido correctamente');
        Session::flash('tipo_mensaje', 'success');

        return redirect()->route('company.profile');
    }

    public function delete($id){
        $this->attachmentId=$id;
    }
    public function destroy(){
        $attachment=ContactsAttachment::find($this->attachmentId);
        $attachment->delete();

        Session::flash('mensaje', 'Adjunto eliminado correctamente');
        Session::flash('tipo_mensaje', 'success');

        return redirect()->route('company.profile');
    }
}


