<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessTestCategory extends Model
{
    use HasFactory;

    protected $table = 'process_test_categories';

    protected $fillable = [
        'name',
        'description',
        'process_test_id',
    ];

    public function processTest()
    {
        return $this->belongsTo(ProcessTest::class, 'process_test_id');
    }

    public function subcategories()
    {
        return $this->hasMany(ProcessTestSubcategory::class, 'p_test_category_id');
    }

    public function appreciations()
    {
        return $this->hasMany(PTestCategoryAppreciation::class, 'p_test_category_id');
    }
}
