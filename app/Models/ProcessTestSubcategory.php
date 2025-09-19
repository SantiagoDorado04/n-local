<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessTestSubcategory extends Model
{
    use HasFactory;

    protected $table = 'process_test_subcategories';

    protected $fillable = [
        'name',
        'description',
        'p_test_category_id',
    ];

    public function category()
    {
        return $this->belongsTo(ProcessTestCategory::class, 'p_test_category_id');
    }

    public function questions()
    {
        return $this->hasMany(ProcessTestQuestion::class, 'p_test_subcategory_id');
    }

    public function answers()
    {
        return $this->hasMany(ProcessTestAnswer::class, 'p_test_subcategory_id');
    }

    public function appreciations()
    {
        return $this->hasMany(PTestSubcategoryAppreciation::class, 'p_test_subcategory_id');
    }
}
