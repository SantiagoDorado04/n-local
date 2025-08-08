<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationFormQuestion extends Model
{
    use HasFactory;

    public function informationForm()
    {
        return $this->belongsTo(InformationForm::class, 'information_form_id');
    }

    public function options()
    {
        return $this->hasMany(InformationFormOption::class, 'information_form_question_id');
    }

    public function answers()
    {
        return $this->hasMany(InformationFormAnswer::class, 'question_id');
    }
}
