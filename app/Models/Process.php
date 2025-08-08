<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Process extends Model
{

    protected $table = 'processes';


    protected $fillable = [
        'name', 'description',
    ];

    public function stages()
    {
        return $this->hasMany(Stage::class, 'process_id');
    }
}
