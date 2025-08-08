<?php

namespace App\Models;

use App\Models\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class OnlineRegistrationCategory extends Model
{
    use HasFactory;

    use HasUserTracking;

    protected $table = 'online_registrations_categories';

    protected $fillable = [
        'name',
        'description',
        'active',
        'online_registration_id',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];

    public function onlineRegistration()
    {
        return $this->belongsTo(OnlineRegistration::class, 'online_registration_id');
    }

    public function onlineRegistrationCourses()
    {
        return $this->hasMany(OnlineRegistrationCourse::class, 'or_category_id');
    }

    public function courses()
    {
        return $this->hasMany(OnlineRegistrationCourse::class, 'or_category_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            foreach ($category->courses as $course) {
                // Eliminar archivos de documentos
                foreach (($course->documents ?? []) as $document) {
                    if ($document->url && Storage::disk('public')->exists($document->url)) {
                        Storage::disk('public')->delete($document->url);
                    }
                    $document->delete();
                }

                // Eliminar archivo de logo_file
                if ($course->logo_file && Storage::disk('public')->exists($course->logo_file)) {
                    Storage::disk('public')->delete($course->logo_file);
                }

                // Eliminar imágenes de pasos de lección en sesiones y contenidos
                foreach (($course->sessions ?? []) as $session) {
                    foreach (($session->contents ?? []) as $content) {
                        if ($content->type === 'L' && $content->lesson) {
                            foreach (($content->lesson->steps ?? []) as $step) {
                                if ($step->image && Storage::disk('public')->exists($step->image)) {
                                    Storage::disk('public')->delete($step->image);
                                }
                            }
                        }

                        // Eliminar imágenes de slides
                        if ($content->slide) {
                            $slide = $content->slide;
                            if ($slide->banner_image && Storage::disk('public')->exists($slide->banner_image)) {
                                Storage::disk('public')->delete($slide->banner_image);
                            }
                        }
                    }
                }

                $course->delete();
            }
        });
    }
}
