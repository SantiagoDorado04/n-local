<?php

namespace App\Models;

use App\Models\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineRegistrationLessonStep extends Model
{
    use HasUserTracking;
    use HasFactory;

    protected $table = 'online_registrations_lessons_steps';

    protected $fillable = [
        'order',
        'body',
        'image',
        'align_text',
        'or_lesson_id',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];

    public function lesson()
    {
        return $this->belongsTo(OnlineRegistrationLessonContent::class, 'or_lesson_id');
    }

    

}
