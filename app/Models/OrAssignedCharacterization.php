<?php

namespace App\Models;

use App\Contact;
use App\Models\Traits\HasUserTracking;
use App\Models\Traits\OrActionsTraits\OrAssignedCharacterizationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrAssignedCharacterization extends Model
{
    use HasFactory;
    use HasUserTracking,OrAssignedCharacterizationTrait;
    protected $table  = 'or_assigned_characterizations';

    protected $fillable = [
        'contact_id',
        'characterization_id',
        'answered',
        'feedback',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at'
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function characterization()
    {
        return $this->belongsTo(OnlineRegistrationCharacterization::class, 'characterization_id');
    }

    public function question()
    {
        return $this->belongsTo(OrCharacterizationQuestion::class, 'question_id');
    }

    public function option()
    {
        return $this->belongsTo(OrCharacterizationOption::class, 'option_id');
    }

    public function answers()
    {
        return $this->hasMany(OrCharacterizationAnswer::class, 'contact_id', 'contact_id')
            ->where('characterization_id', $this->characterization->id);
    }
}
