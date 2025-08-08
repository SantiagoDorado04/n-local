<?php

namespace App\Models;

use App\Contact;
use App\Models\PresentialActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PresentialActivitiesGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'hour',
        'quota',
        'presential_activity_id',
    ];

    public function presentialActivity()
    {
        return $this->belongsTo(PresentialActivity::class);
    }

    public function registeredAttendees()
    {
        return $this->belongsToMany(Contact::class, 'contacts_presential_activities', 'group_id', 'contact_id');
    }
}
