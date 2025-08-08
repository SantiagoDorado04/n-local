<?php

namespace App\Models;

use App\Models\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineRegistrationExternalExecution extends Model
{
    use HasFactory;
    use HasUserTracking;

    protected $table = 'online_registrations_external_executions';

    protected $fillable = [
        'method',
        'url',
        'message',
        'status',
        'request',
        'type',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];

}
