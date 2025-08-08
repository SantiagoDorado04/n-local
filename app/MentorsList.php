<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class MentorsList extends Model
{

    use HasFactory;

    protected $table = 'mentors_list';
    protected $fillable = ['identification', 'name', 'email', 'phone'];

}
