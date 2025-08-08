<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class CommercialFormQuestion extends Model
{
    public function form()
    {
        return $this->belongsTo(CommercialForm::class);
    }

    public function options()
    {
        return $this->hasMany(CommercialFormOption::class);
    }

}
