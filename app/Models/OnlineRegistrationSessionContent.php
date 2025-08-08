<?php

namespace App\Models;

use App\Models\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class OnlineRegistrationSessionContent extends Model
{
    use HasUserTracking;
    use HasFactory;

    protected $table = 'online_registrations_sessions_contents';

    protected $fillable = [
        'title',
        'description',
        'type',
        'step',
        'session_id',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];

    protected static function booted()
    {
        static::deleting(function ($sessionContent) {
            if ($sessionContent->type === 'L') {
                $lessonContent = $sessionContent->lessonContent;
                if ($lessonContent) {
                    foreach ($lessonContent->steps as $step) {
                        if ($step->image && Storage::disk('public')->exists($step->image)) {
                            Storage::disk('public')->delete($step->image);
                        }
                    }
                }
            }
            // Eliminar banner_image del slide relacionado
            if ($sessionContent->slide) {
                $slide = $sessionContent->slide;
                if ($slide->banner_image && Storage::disk('public')->exists($slide->banner_image)) {
                    Storage::disk('public')->delete($slide->banner_image);
                }
            }
        });
    }

    public function onlineRegistrationCourseSession()
    {
        return $this->belongsTo(OnlineRegistrationCourseSession::class, 'session_id');
    }

    public function slide()
    {
        return $this->hasOne(OnlineRegistrationSlideContent::class, 'content_id');
    }

    public function video()
    {
        return $this->hasOne(OnlineRegistrationVideoContent::class, 'content_id');
    }

    public function test()
    {
        return $this->hasOne(OnlineRegistrationTestContent::class, 'content_id');
    }

    public function lesson()
    {
        return $this->hasOne(OnlineRegistrationLessonContent::class, 'content_id');
    }

    // public function onlineRegistrationContactCourse()
    // {
    //     return $this->belongsTo(OnlineRegistrationContactCourse::class, 'contact_id', 'contact_id')
    //         ->where('or_course_id', $this->onlineRegistrationCourseSession->onlineRegistrationCourse->id);
    // }
}
