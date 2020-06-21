<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sku extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'sku_no',
        'price',
        'quantity',
        'description',
        'reorder_point',
        'product_id',
        'short_description',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
