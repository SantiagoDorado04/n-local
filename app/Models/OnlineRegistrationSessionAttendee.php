<?php

namespace App\Models;

use App\Contact;
use App\Models\Traits\HasUserTracking;
use App\Models\Traits\OrActionsTraits\OrSessionAttendeeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineRegistrationSessionAttendee extends Model
{
    use HasUserTracking, OrSessionAttendeeTrait;
    use HasFactory;

    protected $table = 'online_registrations_sessions_attendees';

    protected $fillable = [
        'contact_id',
        'session_id',
        'attended',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];

    public function onlineRegistrationCourseSession()
    {
        return $this->belongsTo(OnlineRegistrationCourseSession::class, 'session_id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }


    public function onlineRegistrationContactCourse()
    {
        return $this->belongsTo(OnlineRegistrationContactCourse::class, 'contact_id', 'contact_id')
            ->where('or_course_id', $this->onlineRegistrationCourseSession->onlineRegistrationCourse->id);
    }

    // public function ()
    // {
    //     return $this->hasMany(::class, '');
    // }
}
