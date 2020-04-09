<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Category_discount extends Model
{
    protected $table = 'category_discount';

    public function category()
    {
        return $this->belongsTo(Category::class, 'product_category_id');
    }
}
