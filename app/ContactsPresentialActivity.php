<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\PresentialActivitiesGroup;


class ContactsPresentialActivity extends Model
{
    public $fillable = [
        'contact_id',
        'presential_activity_id',
        'group_id',
        'approved',
        'feedback'
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function group()
    {
        return $this->belongsTo(PresentialActivitiesGroup::class, 'group_id');
    }
}
