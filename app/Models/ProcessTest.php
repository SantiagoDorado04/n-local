<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessTest extends Model
{
    use HasFactory;

    protected $table = 'process_tests';

    protected $fillable = [
        'name',
        'description',
        'step_id',
    ];

    public function step()
    {
        return $this->belongsTo(Step::class);
    }

    public function categories()
    {
        return $this->hasMany(ProcessTestCategory::class);
    }

    public function questions()
    {
        return $this->hasMany(ProcessTestQuestion::class);
    }

    public function options()
    {
        return $this->hasMany(ProcessTestOption::class);
    }

    public function answers()
    {
        return $this->hasMany(ProcessTestAnswer::class);
    }

    public function appreciations()
    {
        return $this->hasMany(ProcessTestAppreciation::class);
    }

    public function contactsTests()
    {
        return $this->hasMany(ProcessContactTest::class);
    }
}
