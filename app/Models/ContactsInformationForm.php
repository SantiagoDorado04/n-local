<?php

namespace App\Models;

use App\Contact;
use App\Models\InformationForm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactsInformationForm extends Model
{
    protected $fillable = ['information_form_id', 'contact_id', 'date_completed','approved','feedback'];

    public function informationForm()
    {
        return $this->belongsTo(InformationForm::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function informationFormAnswers()
    {
        return $this->hasMany(InformationFormAnswer::class, 'contact_id', 'contact_id')
                    ->where('information_form_id', $this->informationForm->id);
    }
}
