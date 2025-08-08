<?php

namespace App\Models;
use App\Models\Step;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresentialActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'hour',
        'location',
        'facilitator',
        'duration',
        'registration_link',
        'event_type',
        'virtual_link',
        'step_id',
        'points',
        'required_points',
        'cancellation_deadline',
        'reminder_message',
        'reminder_message_date',
        'reminder_message_mean',
        'congratulation_message',
        'congratulation_message_date',
        'congratulation_message_mean'
    ];

    public function step(){

        return $this->belongsTo(Step::class, 'step_id');
    }

    public function groups(){

        return $this->hasMany(PresentialActivitiesGroup::class, 'presential_activity_id');
    }
}
