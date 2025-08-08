<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUserTracking;
use App\Contact;

class OnlineRegistrationContactDocument extends Model
{
    use HasFactory, HasUserTracking;

    protected $table = 'or_contacts_documents';

    protected $fillable = [
        'url',
        'or_course_id',
        'contact_id',
        'or_document_id',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];

   public function onlineRegistrationCourse()
    {
        return $this->belongsTo(onlineRegistrationCourse::class, 'or_course_id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function document()
    {
        return $this->belongsTo(OnlineRegistrationDocument::class, 'or_document_id');
    }
    
}
