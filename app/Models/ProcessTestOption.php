<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessTestOption extends Model
{
    use HasFactory;

    protected $table = 'process_test_options';

    protected $fillable = [
        'text',
        'value',
        'position',
        'points',
        'process_test_id',
        'p_test_question_id',
    ];

    public function processTest()
    {
        return $this->belongsTo(ProcessTest::class);
    }

    public function question()
    {
        return $this->belongsTo(ProcessTestQuestion::class, 'p_test_question_id');
    }
}
