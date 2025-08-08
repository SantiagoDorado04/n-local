<?php

namespace App\Http\Livewire\Admin\Auth;

use App\Contact;
use App\Models\User;
use Livewire\Component;
use App\Rules\EmailVerification;
use Illuminate\Support\Facades\Hash;

class SignUpComponent extends Component
{
    public $nit,$name,$email,$phone,$whatsapp,$contact_person_name,$website;

    public function render()
    {
        return view('livewire.admin.auth.sign-up-component')
        ->layout('layouts.app-form');
    }

    public function register(){
        $this->validate([
            'nit'=>'required|numeric|unique:contacts,nit',
            'name'=>'required',
            'email' => ['required', 'email','unique:users,email', new EmailVerification],
            'phone'=>'required|numeric',
            'contact_person_name'=>'required|string',
        ],[],[
            'nit'=>'NIT',
            'name'=>'nombre',
            'email'=>'correo electrónico',
            'phone'=>'teléfono',
            'contact_person_name'=>'persona de contacto',
        ]);

        $contact = new Contact();
        $contact->nit = $this->nit;
        $contact->name = $this->name;
        $contact->phone = $this->phone;
        $contact->email = $this->email;
        $contact->whatsapp = $this->whatsapp;
        $contact->website = $this->website;
        $contact->contact_person_name = $this->contact_person_name;
        $contact->storage="primer-cloud";
        $contact->save();

        $user= new User();
        $user->name=$this->name;
        $user->email=$this->email;
        $user->role_id=4;
        $user->password=Hash::make($this->nit);
        $user->save();

        $contact->user_id=$user->id;
        $contact->update();


        session()->flash('message', '¡Registro completado exitosamente!');

        return redirect()->route('home.auth');
    }
}
