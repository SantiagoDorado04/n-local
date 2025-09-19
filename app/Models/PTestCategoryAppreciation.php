<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PTestCategoryAppreciation extends Model
{
    use HasFactory;

    protected $table = 'p_test_category_appreciations';

    protected $fillable = [
        'title',
        'appreciation',
        'start_points',
        'end_points',
        'p_test_category_id',
    ];

    public function category()
    {
        return $this->belongsTo(ProcessTestCategory::class, 'p_test_category_id');
    }
}
