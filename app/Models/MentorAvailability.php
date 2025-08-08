<?php

namespace App\Models;

use App\Models\Mentor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MentorAvailability extends Model
{
    use HasFactory;

    protected $fillable = ['mentor_id', 'date', 'start_time', 'end_time'];

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }
}
