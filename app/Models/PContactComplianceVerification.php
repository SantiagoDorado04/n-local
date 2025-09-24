<?php

namespace App\Models;

use App\Contact;
use App\Models\PComplianceVerificationAnswer;
use App\Models\ProcessComplianceVerification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PContactComplianceVerification extends Model
{
    use HasFactory;
    protected $table = 'p_contact_compliance_verifications';
    protected $fillable = ['contact_id', 'pc_verification_id', 'date_completed'];

    public function processComplianceVerification()
    {
        return $this->belongsTo(ProcessComplianceVerification::class, 'pc_verification_id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function pComplianceVerificationAnswers()
    {
        return $this->hasMany(PComplianceVerificationAnswer::class, 'contact_id', 'contact_id')
            ->where('pc_verification_id', $this->processComplianceVerification->id);
    }
}
