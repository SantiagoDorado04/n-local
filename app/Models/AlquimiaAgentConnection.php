<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class AlquimiaAgentConnection extends Model
{
    use HasFactory;

    protected $table = 'alquimia_agent_connections';

    protected $fillable = [
        'name',
        'description',
        'type',
        'status',
        'url',
        'apikey',
        'response_transformer',
        'request_body',
    ];

    public function processAlquimiaAgents()
    {
        return $this->hasMany(ProcessAlquimiaAgent::class, 'alquimia_connection_id');
    }

    public function setApikeyAttribute($value)
    {
        $this->attributes['apikey'] = Crypt::encryptString($value);
    }

    public function getApikeyAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return $value;
        }
    }

    public function getEncryptedApikey()
    {
        return $this->attributes['apikey'];
    }
}
