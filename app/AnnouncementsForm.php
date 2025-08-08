<?php

namespace App;

use App\Announcement;
use App\CommercialForm;
use App\AnnouncementsFormsOption;
use Illuminate\Database\Eloquent\Model;


class AnnouncementsForm extends Model
{
    public function announcement()
    {
        return $this->belongsTo(Announcement::class);
    }
    
    public function commercialForm()
    {
        return $this->belongsTo(CommercialForm::class);
    }
    
    public function announcementFormOptions()
    {
        return $this->hasMany(AnnouncementsFormsOption::class);
    }
}
