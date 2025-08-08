<?php

namespace App;

use App\CommercialLand;
use App\CommercialAction;
use Illuminate\Database\Eloquent\Model;


class CommercialStrategy extends Model
{
    public function commercialLand()
    {
        return $this->belongsTo(CommercialLand::class);
    }

    public function commercialActions()
    {
        return $this->hasMany(CommercialAction::class, 'commercial_strategy_id');
    }

}
