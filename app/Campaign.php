<?php

namespace App;

use App\Models\User;
use App\CampaignContact;
use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx\Namespaces;

class Campaign extends Model
{
    protected $fillable = [
        'name',
        'description',
        'subject',
        'content',
        'send_date',
        'links',
        'send',
        'status',
        'created_by'
    ];

    public function contacts()
    {
        return $this->hasMany(CampaignContact::class, 'campaign_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}