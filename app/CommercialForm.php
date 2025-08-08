<?php

namespace App;

use App\AnnouncementsForm;
use App\CommercialFormAction;
use App\CommercialFormQuestion;
use Illuminate\Database\Eloquent\Model;


class CommercialForm extends Model
{
    public function questions()
    {
        return $this->hasMany(CommercialFormQuestion::class);
    }

    public function commercialFormActions()
    {
        return $this->hasMany(CommercialFormAction::class);
    }

    public function announcementForms()
    {
        return $this->hasMany(AnnouncementsForm::class);
    }
    
    public function commercialFormQuestions()
    {
        return $this->hasMany(CommercialFormQuestion::class);
    }
}