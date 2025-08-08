<?php

namespace App\Models;

use App\Models\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineRegistrationForm extends Model
{
    use HasFactory;
    

    protected $table = 'online_registrations_forms';

    protected $fillable = [
        'name',
        'description',
        'online_registration_course_id',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];

    public function onlineRegistrationCourse()
    {
        return $this->belongsTo(OnlineRegistrationCourse::class);
    }

    public function questions()
    {
        return $this->hasMany(OnlineRegistrationFormQuestion::class, 'or_form_id');
    }
}
