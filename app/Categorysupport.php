<?php

namespace App;

use App\Support;
use Illuminate\Database\Eloquent\Model;


class Categorysupport extends Model
{
    public function supports() {
        return $this->hasMany(Support::class, 'category_supports_id');
    }
}
