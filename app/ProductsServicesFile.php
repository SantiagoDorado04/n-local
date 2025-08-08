<?php

namespace App;

use App\ProductsService;
use Illuminate\Database\Eloquent\Model;


class ProductsServicesFile extends Model
{
    public function productService()
    {
        return $this->belongsTo(ProductsService::class, 'product_service_id');
    }
}
