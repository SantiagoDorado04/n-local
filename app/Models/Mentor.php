<?php

namespace App\Models;

use App\MentorsList;
use App\Models\Step;
use App\Models\MentorAvailability;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mentor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'session_duration', 'points', 'required_points', 'cancellation_deadline', 'step_id', 'reminder_message',
    'reminder_message_date',
    'reminder_message_mean',
    'congratulation_message',
    'congratulation_message_date',
    'congratulation_message_mean'];

    public function availabilities()
    {
        return $this->hasMany(MentorAvailability::class);
    }

    public function step()
    {
        return $this->belongsTo(Step::class);
    }

    public function mentorList()
    {
        return $this->belongsTo(MentorsList::class, 'mentor_id');
    }
}
