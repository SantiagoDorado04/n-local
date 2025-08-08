<?php

namespace App\Models;

use App\Models\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineRegistrationVideoContent extends Model
{
    use HasUserTracking;
    use HasFactory;

    protected $table = 'online_registrations_videos_contents';

    protected $fillable = [
        'content_id',
        'instructions',
        'embed',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];

    public function onlineRegistrationSessionContent()
    {
        return $this->belongsTo(OnlineRegistrationSessionContent::class, 'content_id');
    }
}
