<?php

namespace App\Models;

use App\Contact;
use App\Models\Traits\HasUserTracking;
use App\Models\Traits\OrActionsTraits\OrFinishedContentTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineRegistrationContentProgress extends Model
{
    use HasUserTracking,OrFinishedContentTrait;
    use HasFactory;

    protected $table = 'online_registrations_content_progress';

    protected $fillable = [
        'contact_id',
        'finished',
        'or_course_id',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];
    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }
    public function course()
    {
        return $this->belongsTo(OnlineRegistrationCourse::class, 'or_course_id');
    }
}
