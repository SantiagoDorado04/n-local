<?php

namespace App\Models;

use App\Models\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineRegistrationChannel extends Model
{
    use HasFactory;
    use HasUserTracking;

    protected $table = 'online_registrations_channels';

    protected $fillable = [
        'name',
        'url',
        'structure',
        'online_registration_id',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];
    public function onlineRegistration()
    {
        return $this->belongsTo(OnlineRegistration::class, 'online_registration_id');
    }
}
