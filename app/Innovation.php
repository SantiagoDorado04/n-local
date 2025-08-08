<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Innovation extends Model
{

    public function technologies()
    {
        return $this->belongsTo(Technology::class, 'technology');
    }

}
