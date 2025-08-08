<?php

namespace App\Models;

use App\Models\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineRegistrationFormQuestion extends Model
{
    use HasFactory;
    use HasUserTracking;

    protected $table = 'online_registrations_forms_questions';

    protected $fillable = [
        'text',
        'type',
        'position',
        'or_form_id',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];

    public function onlineRegistrationForm()
    {
        return $this->belongsTo(OnlineRegistrationForm::class, 'or_form_id');
    }

    public function options()
    {
        return $this->hasMany(OnlineRegistrationFormOption::class, 'question_id');
    }

    public function answers()
    {
        return $this->hasMany(OnlineRegistrationFormAnswer::class, 'question_id');
    }
}
