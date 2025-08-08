<?php

namespace App\Models;

use App\CommercialAction;
use App\CommercialLand;
use App\CommercialStrategy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseRegistrationForm extends Model
{
    use HasFactory;

    protected $table = 'course_registration_forms';


    protected $fillable = [
        'name',
        'description',
        'token',
        'embed_video',
        'file',
        'reminder_message',
        'reminder_message_date',
        'active',
        'online_registration_id',
    ];

    public function onlineRegistration()
    {
        return $this->belongsTo(OnlineRegistration::class, 'online_registration_id');
    }

    public function land()
    {
        return $this->belongsTo(CommercialLand::class, 'land_id');
    }

    public function strategy()
    {
        return $this->belongsTo(CommercialStrategy::class, 'strategy_id');
    }

    public function action()
    {
        return $this->belongsTo(CommercialAction::class, 'action_id');
    }

    public function contactsCourseRegistration()
    {
        return $this->hasMany(ContactsCourseRegistrationForm::class, 'course_registration_form__id');
    }

    // public function form()
    // {
    //     return $this->hasOne(InformationForm::class, 'course_registration_form_id');
    // }
}
