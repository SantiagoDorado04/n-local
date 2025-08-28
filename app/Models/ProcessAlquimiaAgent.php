<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessAlquimiaAgent extends Model
{
    use HasFactory;

    protected $table = 'process_alquimia_agents';

    protected $fillable = [
        'name',
        'description',
        'url_file',
        'points',
        'required_points',
        'alquimia_connection_id',
        'step_id',
    ];

    public function step()
    {
        return $this->belongsTo(Step::class, 'step_id');
    }

    public function alquimiaAgentConnection()
    {
        return $this->belongsTo(AlquimiaAgentConnection::class, 'alquimia_connection_id');
    }

    public function questions()
    {
        return $this->hasMany(ProcessAlquimiaAgentQuestion::class, 'process_alquimia_agent_id');
    }
}
