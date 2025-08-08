<?php

namespace App\Models;

use App\Contact;
use App\Models\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrCharacterizationAnswer extends Model
{
    use HasFactory;
    use HasUserTracking;

    protected $table = 'or_characterization_answers';

    protected $fillable = [
        'contact_id',
        'characterization_id',
        'question_id',
        'answer',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
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
        return $this->belongsTo(OrCharacterizationOption::class, 'answer');
    }



    public function orAssignedCharacterizations()
    {
        return $this->belongsTo(OrAssignedCharacterization::class, 'contact_id', 'contact_id')
            ->where('characterization_id', $this->characterization_id);
    }
}
