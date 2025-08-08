<?php

namespace App\Models;

use App\Models\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class OnlineRegistrationCourseSession extends Model
{
    use HasFactory;
    use HasUserTracking;

    protected $table = 'online_registrations_courses_sessions';

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'non_attendance_message', //se ejecuta con un observer cada que el end_date es menor a la fecha actual, osea ya paso
        'or_course_id',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];



    public function onlineRegistrationCourse()
    {
        return $this->belongsTo(OnlineRegistrationCourse::class, 'or_course_id');
    }

    public function sesionAttendees()
    {
        return $this->hasMany(OnlineRegistrationSessionAttendee::class, 'session_id');
    }

    public function characterizations()
    {
        return $this->hasMany(OnlineRegistrationCharacterization::class, 'session_id');
    }
    public function contents()
    {
        return $this->hasMany(OnlineRegistrationSessionContent::class, 'session_id');
    }
    protected static function booted()
    {
        static::deleting(function ($session) {
            foreach ($session->contents as $content) {
                if ($content->type === 'L' && $content->lesson) {
                    foreach ($content->lesson->steps as $step) {
                        if ($step->image && Storage::disk('public')->exists($step->image)) {
                            Storage::disk('public')->delete($step->image);
                        }
                    }
                }
                // Eliminar banner_image del slide relacionado
                if ($content->slide) {
                    $slide = $content->slide;
                    if ($slide->banner_image && Storage::disk('public')->exists($slide->banner_image)) {
                        Storage::disk('public')->delete($slide->banner_image);
                    }
                }
            }
        });
    }
}
