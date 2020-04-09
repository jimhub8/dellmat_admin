<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VariantValue extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'product_variant_product_id', 'product_variant_variant_id', 'product_option_product_id', 'option_value_option_id', 'product_option_id', 'option_value_id',
    ];


    public $with = ['product_option', 'option_value'];
    // public $with = ['product'];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function option()
    {
        return $this->belongsTo(Option::class, 'product_option_id');
    }
    public function product_option()
    {
        return $this->belongsTo(ProductOption::class);
    }
    public function product_variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
    public function option_value()
    {
        return $this->belongsTo(OptionValue::class, 'option_value_id');
    }
}
