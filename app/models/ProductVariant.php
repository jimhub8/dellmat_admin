<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use SoftDeletes;
    protected $fillable = ['product_id'];

    public $with = ['variant_values'];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function variant_values()
    {
        return $this->hasMany(VariantValue::class, 'product_variant_variant_id');
    }
}
