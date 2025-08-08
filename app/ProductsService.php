<?php

namespace App;

use App\ProductsServicesFile;
use Illuminate\Database\Eloquent\Model;


class ProductsService extends Model
{
    public function developmentLevel()
    {
        return $this->belongsTo(DevelopmentLevel::class);
    }

    public function files()
    {
        return $this->hasMany(ProductsServicesFile::class, 'product_service_id');
    }
}