<?php

namespace App;

use App\CommercialStrategy;
use Illuminate\Database\Eloquent\Model;


class CommercialLand extends Model
{
    public function commercialStrategies()
    {
        return $this->hasMany(CommercialStrategy::class, 'commercial_land_id');
    }
}
