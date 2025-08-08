<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ContactsCourse extends Model
{
    protected $fillable = [
        'contact_id',
        'course_id',
        'approved',
        'feedback',
        'lessons_number',
        'total_lessons',
        'complet'
    ];
}
