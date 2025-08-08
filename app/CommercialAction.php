<?php

namespace App;

use App\CommercialStrategy;
use App\CommercialFormAction;
use Illuminate\Database\Eloquent\Model;


class CommercialAction extends Model
{
    public function commercialStrategy()
    {
        return $this->belongsTo(CommercialStrategy::class ,'commercial_strategy_id');
    }

    public function commercialFormActions()
    {
        return $this->hasMany(CommercialFormAction::class);
    }
}
