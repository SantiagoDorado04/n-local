<?php

namespace App\Models;

use App\Models\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class OnlineRegistration extends Model
{
    use HasFactory;
    use HasUserTracking;


    protected $table = 'online_registrations';

    protected $fillable = [
        'name',
        'description',
        'course_limit',
        'active',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];

    public function courseRegistrationForms()
    {
        return $this->hasMany(CourseRegistrationForm::class, 'online_registration_id');
    }

    public function categories()
    {
        return $this->hasMany(OnlineRegistrationCategory::class, 'online_registration_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($registration) {
            // Eliminar archivos de los cursos y documentos de todas las categorías antes de borrar las categorías
            foreach (($registration->categories ?? []) as $category) {
                foreach (($category->courses ?? []) as $course) {
                    // Eliminar archivos de documentos
                    foreach (($course->documents ?? []) as $document) {
                        if ($document->url && \Storage::disk('public')->exists($document->url)) {
                            \Storage::disk('public')->delete($document->url);
                        }
                        $document->delete();
                    }

                    // Eliminar archivo de logo_file
                    if ($course->logo_file && \Storage::disk('public')->exists($course->logo_file)) {
                        \Storage::disk('public')->delete($course->logo_file);
                    }

                    $course->delete();
                }

                $category->delete();
            }
        });
    }

    protected static function booted()
    {
        static::deleting(function ($registration) {
            foreach (($registration->categories ?? []) as $category) {
                foreach (($category->courses ?? []) as $course) {
                    // Eliminar logo del curso
                    if ($course->logo_file && Storage::disk('public')->exists($course->logo_file)) {
                        Storage::disk('public')->delete($course->logo_file);
                    }
                    // Eliminar imágenes de pasos de lección de todas las sesiones y contenidos
                    foreach (($course->sessions ?? []) as $session) {
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
                }
            }

            // Eliminar banner_image de slides en todas las categorías, cursos, sesiones y contenidos
            foreach (($registration->categories ?? []) as $category) {
                foreach (($category->courses ?? []) as $course) {
                    foreach (($course->sessions ?? []) as $session) {
                        foreach (($session->contents ?? []) as $content) {
                            if ($content->slide) {
                                $slide = $content->slide;
                                if ($slide->banner_image && \Storage::disk('public')->exists($slide->banner_image)) {
                                    \Storage::disk('public')->delete($slide->banner_image);
                                }
                            }
                        }
                    }
                }
            }
        });
    }

}
