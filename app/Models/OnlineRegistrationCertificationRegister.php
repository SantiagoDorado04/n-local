<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUserTracking;
use App\Contact;


class OnlineRegistrationCertificationRegister extends Model
{
    use HasFactory, HasUserTracking;

    protected $table = 'or_certifications_register';

    protected $fillable = [
        'url',
        'last_download_date',
        'count_downloads',
        'contact_id',
        'or_document_id',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function document()
    {
        return $this->belongsTo(OnlineRegistrationDocument::class, 'or_document_id');
    }
}
