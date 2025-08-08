<?php

namespace App\Models;

use App\Contact;
use App\Models\InformationForm;
use App\Models\InformationFormQuestion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationFormAnswer extends Model
{
    use HasFactory;

    protected $table  ='information_forms_answers';


    protected $fillable = [
        'contact_id', 'information_form_id', 'question_id', 'answer',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function informationForm()
    {
        return $this->belongsTo(InformationForm::class);
    }

    public function question()
    {
        return $this->belongsTo(InformationFormQuestion::class);
    }

    public function contactStage()
    {
        return $this->belongsTo(ContactsStage::class, 'contact_id', 'contact_id');
    }
}
