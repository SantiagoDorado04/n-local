<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Notification extends Model
{
    public $fillable = [
        'message',
        'read'
    ];
}
