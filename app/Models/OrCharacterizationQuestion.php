<?php

namespace App\Models;

use App\Models\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrCharacterizationQuestion extends Model
{
    use HasFactory;

    use HasUserTracking;

    protected $table = 'or_characterization_questions';

    protected $fillable = [
        'text',
        'type',
        'position',
        'characterization_id',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];

    public function characterization()
    {
        return $this->belongsTo(OnlineRegistrationCharacterization::class, 'characterization_id');
    }

    public function options()
    {
        return $this->hasMany(OrCharacterizationOption::class, 'question_id');
    }

    public function answers()
    {
        return $this->hasMany(OrCharacterizationAnswer::class, 'question_id');
    }
}
