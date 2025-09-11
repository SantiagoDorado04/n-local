<?php

namespace App\Models;

use App\Contact;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PComplianceVerificationAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'answer',
        'contact_id',
        'pc_verification_id',
        'question_id',
    ];

    public function verification()
    {
        return $this->belongsTo(ProcessComplianceVerification::class, 'pc_verification_id');
    }

    public function question()
    {
        return $this->belongsTo(PComplianceVerificationQuestion::class, 'question_id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }
}
