<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Categorytutorial extends Model
{
    public function tutorials() {
        return $this->hasMany(Tutorial::class, 'category_tutorials_id');
    }
}
