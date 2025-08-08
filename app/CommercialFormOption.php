<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class CommercialFormOption extends Model
{
    public function question()
    {
        return $this->belongsTo(CommercialFormQuestion::class);
    }
}
