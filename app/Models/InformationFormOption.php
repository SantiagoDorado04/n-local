<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationFormOption extends Model
{
    use HasFactory;

    public function informationFormQuestion()
    {
        return $this->belongsTo(InformationFormQuestion::class, 'information_form_question_id');
    }
}
