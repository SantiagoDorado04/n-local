<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceControlForm extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'token', 'course_registration_form_id'];

    public function step()
    {
        return $this->belongsTo(Step::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
    
    public function questions()
    {
        return $this->hasMany(InformationFormQuestion::class);
    }

}
