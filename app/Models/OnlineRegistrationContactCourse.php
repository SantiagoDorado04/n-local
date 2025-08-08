<?php

namespace App\Models;

use App\Contact;
use App\Models\Traits\HasUserTracking;
use App\Models\Traits\OrActionsTraits\OrAssignedCharacterizationGeneralTrait;
use App\Models\Traits\OrActionsTraits\OrRegisterContactCourseTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineRegistrationContactCourse extends Model
{
    use HasFactory;
    use HasUserTracking, OrRegisterContactCourseTrait,OrAssignedCharacterizationGeneralTrait;


    protected $table = 'online_registrations_contacts_courses';

    protected $fillable = [
        'contact_id',
        'or_course_id',
        'feedback',
        'certificate',
        'certificate_date',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }


    public function onlineRegistrationCourse()
    {
        return $this->belongsTo(OnlineRegistrationCourse::class, 'or_course_id');
    }

    public function onlineRegistrationSessionAttendees()
    {
        return $this->hasMany(OnlineRegistrationSessionAttendee::class, 'contact_id', 'contact_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($registration) {
            // Obtener el ID del curso y del contacto
            $courseId = $registration->or_course_id;
            $contactId = $registration->contact_id;

            // Obtener las sesiones del curso
            $sessionIds = \App\Models\OnlineRegistrationCourseSession::where('or_course_id', $courseId)->pluck('id');

            // Eliminar asistencias del contacto en esas sesiones
            \App\Models\OnlineRegistrationSessionAttendee::where('contact_id', $contactId)
                ->whereIn('session_id', $sessionIds)
                ->delete();
        });
    }
}
