<?php

namespace App\Models;

use App\Models\Traits\HasUserTracking;
use App\Models\Traits\DeletesWithFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class OnlineRegistrationCourse extends Model
{
    use HasFactory;
    use HasUserTracking;
    use DeletesWithFile;

    protected $table = 'online_registrations_courses';


    protected $fillable = [
        'name',
        'description',
        'slug',
        'embebed_video',
        'logo_file',
        'or_category_id',
        'active',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];

    public function onlineRegistrationCategory()
    {
        return $this->belongsTo(OnlineRegistrationCategory::class, 'or_category_id');
    }

    public function onlineRegistrationContactsCourses()
    {
        return $this->hasMany(OnlineRegistrationContactCourse::class, 'or_course_id');
    }

    public function onlineRegistrationCourseSessions()
    {
        return $this->hasMany(OnlineRegistrationCourseSession::class, 'or_course_id');
    }

    public function form()
    {
        return $this->hasOne(OnlineRegistrationForm::class, 'online_registration_course_id');
    }

    public function waGroup()
    {
        return $this->hasOne(OrCourseWaGroup::class, 'or_course_id');
    }

    public function onlineRegistrationComunications()
    {
        return $this->hasMany(OrCourseComunication::class, 'or_course_id');
    }

    public function documents()
    {
        return $this->hasMany(OnlineRegistrationDocument::class, 'or_course_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($course) {
            foreach ($course->documents as $document) {
                $document->delete();
            }
        });
    }

    protected static function booted()
    {
        static::deleting(function ($course) {
            // Eliminar logo del curso
            if ($course->logo_file && Storage::disk('public')->exists($course->logo_file)) {
                Storage::disk('public')->delete($course->logo_file);
            }
            // Eliminar imágenes de pasos de lección de todas las sesiones y contenidos
            foreach (($course->onlineRegistrationCourseSessions ?? []) as $session) {
                foreach (($session->contents ?? []) as $content) {
                    if ($content->type === 'L' && $content->lesson) {
                        foreach (($content->lesson->steps ?? []) as $step) {
                            if ($step->image && Storage::disk('public')->exists($step->image)) {
                                Storage::disk('public')->delete($step->image);
                            }
                        }
                    }
                }
            }
            // Eliminar banner_image de slides en todas las sesiones y contenidos
            foreach (($course->onlineRegistrationCourseSessions ?? []) as $session) {
                foreach ($session->contents as $content) {
                    if ($content->slide) {
                        $slide = $content->slide;
                        if ($slide->banner_image && Storage::disk('public')->exists($slide->banner_image)) {
                            Storage::disk('public')->delete($slide->banner_image);
                        }
                    }
                }
            }
        });
    }
}
