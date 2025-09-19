<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessTestAppreciation extends Model
{
    use HasFactory;

    protected $table = 'process_test_appreciations';

    protected $fillable = [
        'title',
        'appreciation',
        'start_points',
        'end_points',
        'process_test_id',
    ];

    public function processTest()
    {
        return $this->belongsTo(ProcessTest::class);
    }
}
