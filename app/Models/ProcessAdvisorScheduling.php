<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessAdvisorScheduling extends Model
{
    use HasFactory;

    protected $table = 'process_advisor_scheduling';

    protected $fillable = [
        'name',
        'embed',
        'required_steps',
        'step_id',
    ];

    public function step()
    {
        return $this->belongsTo(Step::class, 'step_id');
    }
}
