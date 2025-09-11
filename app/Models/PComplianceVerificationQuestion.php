<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PComplianceVerificationQuestion extends Model
{
    use HasFactory;

    protected $table = 'p_compliance_verification_questions';

    protected $fillable = ['text', 'position', 'pc_verification_id'];

    public function verification()
    {
        return $this->belongsTo(ProcessComplianceVerification::class, 'pc_verification_id');
    }

    public function answers()
    {
        return $this->hasMany(PComplianceVerificationAnswer::class, 'question_id');
    }
}
