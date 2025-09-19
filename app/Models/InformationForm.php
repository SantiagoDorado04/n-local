<?php

namespace App\Models;

use App\Models\Step;
use App\Models\Stage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InformationForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'embebed',
        'step_id',
        'points',
        'reminder_message',
        'reminder_message_date',
        'reminder_message_mean',
        'congratulation_message',
        'congratulation_message_date',
        'congratulation_message_mean'
    ];

    public function step()
    {
        return $this->belongsTo(Step::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function questions()
    {
        return $this->hasMany(InformationFormQuestion::class)->orderBt('position', 'asc');
    }
}
