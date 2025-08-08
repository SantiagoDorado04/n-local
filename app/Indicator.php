<?php

namespace App;

use App\Metodology;
use Illuminate\Database\Eloquent\Model;


class Indicator extends Model
{
    public function methodology()
    {
        return $this->belongsTo(Metodology::class);
    }
}
