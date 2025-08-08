<?php

namespace App\Models;

use App\Models\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineRegistrationTestContent extends Model
{
    use HasUserTracking;
    use HasFactory;

    protected $table = 'online_registrations_tests_contents';

    protected $fillable = [
        'instructions',
        'content_id',
        'percentage',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];

    public function  onlineRegistrationSessionContent()
    {
        return $this->belongsTo(OnlineRegistrationSessionContent::class, 'content_id');
    }
}
