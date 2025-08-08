<?php

namespace App;

use App\Solution;
use App\Indicator;
use Illuminate\Database\Eloquent\Model;


class Metodology extends Model
{
    public function solution()
    {
        return $this->belongsTo(Solution::class);
    }

    public function indicators()
    {
        return $this->hasMany(Indicator::class);
    }
}
