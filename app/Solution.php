<?php

namespace App;

use App\Problem;
use App\Metodology;
use Illuminate\Database\Eloquent\Model;


class Solution extends Model
{
    
    public function problem()
    {
        return $this->belongsTo(Problem::class);
    }

    public function methodologies()
    {
        return $this->hasMany(Metodology::class);
    }
}
