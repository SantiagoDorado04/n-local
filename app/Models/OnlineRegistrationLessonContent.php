<?php

namespace App\Models;

use App\Models\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class OnlineRegistrationLessonContent extends Model
{
    use HasUserTracking;
    use HasFactory;

    protected $table = 'online_registrations_lessons_contents';

    protected $fillable = [
        'content_id',
        'instructions',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];

    protected static function booted()
    {
        static::deleting(function ($lessonContent) {
            foreach ($lessonContent->steps as $step) {
                if ($step->image && Storage::disk('public')->exists($step->image)) {
                    Storage::disk('public')->delete($step->image);
                }
            }
        });
    }

    public function onlineRegistrationSessionContent()
    {
        return $this->belongsTo(OnlineRegistrationSessionContent::class, 'content_id');
    }

    public function steps()
    {
        return $this->hasMany(OnlineRegistrationLessonStep::class, 'or_lesson_id');
    }

}
