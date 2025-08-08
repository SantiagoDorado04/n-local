<?php

namespace App\Models;

use App\Models\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrCourseComunication extends Model
{
    use HasFactory;
    use HasUserTracking;

    protected $table = 'or_courses_comunications';

    protected $fillable = [
        'name',
        'action',
        'message',
        'or_course_id',
        'or_channel_id',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];
    public function onlineRegistrationChannel()
    {
        return $this->belongsTo(OnlineRegistrationChannel::class, 'or_channel_id');
    }
    public function onlineRegistrationCourse()
    {
        return $this->belongsTo(OnlineRegistrationCourse::class, 'or_course_id');
    }
}
