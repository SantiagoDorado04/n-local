<?php

namespace App\Models;

use App\Contact;
use App\Models\Traits\DeletesWithFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUserTracking;
use Illuminate\Support\Facades\Storage;

class OnlineRegistrationDocument extends Model
{
    use HasFactory, HasUserTracking,DeletesWithFile;

    protected $table = 'online_registrations_documents';

    protected $fillable = [
        'name',
        'type',
        'required',
        'or_course_id',
        'url',
        'video_embebed',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];

    public function onlineRegistrationContactsDocuments()
    {
        return $this->hasMany(OnlineRegistrationContactDocument::class, 'or_document_id');
    }

    public function onlineRegistrationCourse()
    {
        return $this->belongsTo(OnlineRegistrationCourse::class, 'or_course_id');
    }

    public function registers()
    {
        return $this->hasMany(OnlineRegistrationCertificationRegister::class, 'or_document_id');
    }

    public function userCreated()
    {
        return $this->belongsTo(User::class, 'user_created_at');
    }

    public function userUpdated()
    {
        return $this->belongsTo(User::class, 'user_updated_at');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($document) {
            // Verificar si el archivo existe y eliminarlo
            if ($document->url && Storage::exists($document->url)) {
                Storage::delete($document->url);
            }
        });
    }
}
