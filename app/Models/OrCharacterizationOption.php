<?php

namespace App\Models;

use App\Models\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrCharacterizationOption extends Model
{
    use HasFactory;
    use HasUserTracking;

    protected $table = 'or_characterization_options';

    protected $fillable = [
        'text',
        'value',
        'position',
        'question_id',
        'conditional',
        'characterization_id',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];

    public function orCharacterizationQuestion()
    {
        return $this->belongsTo(OrCharacterizationQuestion::class, 'question_id');
    }

    public function characterization()
    {
        return $this->hasOne(OnlineRegistrationCharacterization::class, 'characterization_id');
    }
}
