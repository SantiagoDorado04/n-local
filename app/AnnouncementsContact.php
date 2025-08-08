<?php

namespace App;

use App\Contact;
use App\Announcement;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;


class AnnouncementsContact extends Model
{
    public function projects()
    {
        return $this->hasMany(Project::class, 'announcement_contact_id');
    }

    public function announcement()
    {
        return $this->belongsTo(Announcement::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }
}
