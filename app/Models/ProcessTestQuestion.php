<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessTestQuestion extends Model
{
    use HasFactory;

    protected $table = 'process_test_questions';

    protected $fillable = [
        'text',
        'position',
        'process_test_id',
        'p_test_subcategory_id',
    ];

    public function processTest()
    {
        return $this->belongsTo(ProcessTest::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(ProcessTestSubcategory::class, 'p_test_subcategory_id');
    }

    public function options()
    {
        return $this->hasMany(ProcessTestOption::class, 'p_test_question_id');
    }

    public function answers()
    {
        return $this->hasMany(ProcessTestAnswer::class, 'p_test_question_id');
    }
}
