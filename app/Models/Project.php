<?php

namespace App\Models;

use App\Problem;
use App\AnnouncementsContact;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    public function announcementContact()
    {
        return $this->belongsTo(AnnouncementsContact::class, 'announcement_contact_id');
    }

    public function problems()
    {
        return $this->hasMany(Problem::class);
    }

    public function Innovations()
    {
        return $this->belongsTo(Innovation::class, 'project_id');
    }
}
