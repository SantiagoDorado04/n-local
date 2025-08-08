<?php

namespace App\Models;

use App\Contact;
use App\Models\Step;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'instructions',
        'delivery_date',
        'step_id',
        'points',
        'reminder_message',
        'reminder_message_date',
        'reminder_message_mean',
        'congratulation_message',
        'congratulation_message_date',
        'congratulation_message_mean'
    ];

    protected $dates = ['delivery_date'];

    public function step()
    {
        return $this->belongsTo(Step::class);
    }

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'contacts_challenges');
    }
}
