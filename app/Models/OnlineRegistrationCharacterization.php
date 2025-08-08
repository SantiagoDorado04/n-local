<?php

namespace App\Models;

use App\Models\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineRegistrationCharacterization extends Model
{
    use HasFactory;
    use HasUserTracking;

    protected $table = 'online_registrations_characterizations';

    protected $fillable = [
        'name',
        'description',
        'session_id',
        'type',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];

    public function questions()
    {
        return $this->hasMany(OrCharacterizationQuestion::class, 'characterization_id');
    }

    public function session()
    {
        return $this->belongsTo(OnlineRegistrationCourseSession::class, 'session_id');
    }
}
