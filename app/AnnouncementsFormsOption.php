<?php

namespace App;

use App\AnnouncementsForm;
use App\CommercialFormOption;
use App\CommercialFormQuestion;
use Illuminate\Database\Eloquent\Model;


class AnnouncementsFormsOption extends Model
{
    public function announcementForm()
    {
        return $this->belongsTo(AnnouncementsForm::class);
    }
    
    public function commercialFormQuestion()
    {
        return $this->belongsTo(CommercialFormQuestion::class);
    }
    
    public function commercialFormQuestionOption()
    {
        return $this->belongsTo(CommercialFormOption::class);
    }
}
