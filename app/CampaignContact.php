<?php

namespace App;

use App\Contact;
use App\Campaign;
use Illuminate\Database\Eloquent\Model;


class CampaignContact extends Model
{
    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
