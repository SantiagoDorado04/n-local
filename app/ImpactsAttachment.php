<?php

namespace App;

use App\Models\Impact;
use Illuminate\Database\Eloquent\Model;


class ImpactsAttachment extends Model
{
    public function contact()
    {
        return $this->belongsTo(Impact::class, 'impact_id');
    }
}
