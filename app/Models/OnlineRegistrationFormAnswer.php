<?php

namespace App\Models;

use App\Contact;
use App\Models\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineRegistrationFormAnswer extends Model
{
    use HasFactory;
    use HasUserTracking;

    protected $table = 'online_registrations_forms_answers';

    protected $fillable = [
        'contact_id',
        'or_form_id',
        'question_id',
        'answer',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function onlineRegistrationForm()
    {
        return $this->belongsTo(OnlineRegistrationForm::class);
    }

    public function question()
    {
        return $this->belongsTo(OnlineRegistrationFormQuestion::class, 'question_id');
    }

    public function option()
    {
        return $this->belongsTo(OnlineRegistrationFormOption::class, 'option_id');
    }

    public function onlineRegistrationContactCourse()
    {
        return $this->belongsTo(OnlineRegistrationContactCourse::class, 'contact_id', 'contact_id');
    }
}
