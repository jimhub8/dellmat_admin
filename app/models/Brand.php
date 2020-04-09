<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public function products()
    {
        return $this->belongsToMany(Product::class)->using(BrandProduct::class);
    }
}
