<?php

namespace App\Models;

use App\Models\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrCourseWaGroup extends Model
{
    use HasFactory;
    use HasUserTracking;

    protected $table = 'or_courses_wa_groups';

    protected $fillable = [
        'name',
        'description',
        'instance',
        'group_id',
        'or_course_id',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];

    public function onlineRegistrationCourse()
    {
        return $this->hasOne(OnlineRegistrationCourse::class, 'or_course_id');
    }
}
