<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProcessComplianceVerification extends Model
{
    use HasFactory;

    protected $table = 'process_compliance_verifications';

    protected $fillable = [
        'embed',
        'required_steps',
        'step_id',
    ];

    public function questions()
    {
        return $this->hasMany(PComplianceVerificationQuestion::class, 'pc_verification_id');
    }

    public function answers()
    {
        return $this->hasMany(PComplianceVerificationAnswer::class, 'pc_verification_id');
    }
}
