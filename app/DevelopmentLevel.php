<?php

namespace App;

use App\ProductsService;
use Illuminate\Database\Eloquent\Model;


class DevelopmentLevel extends Model
{
    public function productServices()
    {
        return $this->hasMany(ProductsService::class);
    }
}
