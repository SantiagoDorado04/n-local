<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PTestSubcategoryAppreciation extends Model
{
    use HasFactory;

    protected $table = 'p_test_subcategory_appreciations';

    protected $fillable = [
        'title',
        'appreciation',
        'start_points',
        'end_points',
        'p_test_subcategory_id',
    ];

    public function subcategory()
    {
        return $this->belongsTo(ProcessTestSubcategory::class, 'p_test_subcategory_id');
    }
}
