<?php

namespace App\Models;

use App\Contact;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactsStage extends Model
{
    protected $fillable = ['contact_id', 'stage_id', 'approved'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function informationFormAnswers()
    {
        return $this->hasMany(InformationFormAnswer::class, 'contact_id', 'contact_id')
                    ->where('information_form_id', $this->stage->form->id);
    }

    public function contactChallenge()
    {
        return $this->hasOne(ContactsChallenge::class, 'contact_id');
    }
}


