<?php

namespace App;

use bootstrap;
use App\Contact;
use App\AnnouncementsForm;
use Illuminate\Database\Eloquent\Model;


class Announcement extends Model
{
    public function announcementForms()
    {
        return $this->hasMany(AnnouncementsForm::class);
    }
    
    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'announcements_contacts');
    }

}
