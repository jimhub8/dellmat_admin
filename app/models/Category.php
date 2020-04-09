<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $with = ['discounts', 'subcategories'];
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    public function discounts()
    {
        return $this->hasMany(Category_discount::class, 'product_category_id');
    }
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }
}
