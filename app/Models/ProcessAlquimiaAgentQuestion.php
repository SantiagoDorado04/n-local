<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessAlquimiaAgentQuestion extends Model
{
    use HasFactory;

    protected $table = 'process_alquimia_agent_questions';

    protected $fillable = [
        'text',
        'prompt',
        'guide',
        'contexts',
        'position',
        'process_alquimia_agent_id',
    ];

    public function processAlquimiaAgent()
    {
        return $this->belongsTo(ProcessAlquimiaAgent::class, 'process_alquimia_agent_id');
    }

    public function answers()
    {
        return $this->hasMany(ProcessAlquimiaAgentAnswer::class, 'paa_question_id');
    }
}
