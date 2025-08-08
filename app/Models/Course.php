<?php

namespace App\Models;

use App\Models\Step;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'first', 'previous_course', 'next_course', 'duration', 'start_date', 'end_date', 'points', 'reminder_message',
        'reminder_message_date',
        'reminder_message_mean',
        'congratulation_message',
        'congratulation_message_date',
        'congratulation_message_mean'];

    public function previousCourse()
    {
        return $this->belongsTo(Course::class, 'previous_course');
    }

    public function nextCourse()
    {
        return $this->belongsTo(Course::class, 'next_course');
    }

    public function step()
    {
        return $this->belongsTo(Step::class, 'step_id');
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Topic::class);
    }
}
