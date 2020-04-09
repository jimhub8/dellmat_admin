<?php

namespace App\models;

use App\Scopes\SellerproductScope;
use App\Seller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    public $with = ['product_variants', 'skus', 'categories', 'brands', 'subcategories'];
    public function sales()
    {
        return $this->belongsToMany(Sale::class);
        // return $this->belongsToMany('App\models\Sale')->using('App\models\ProductSale');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function subcategories()
    {
        return $this->belongsToMany(Subcategory::class);
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }


    // Product relationships
    public function product_variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    public function product_options()
    {
        return $this->hasMany(ProductOption::class);
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }
    // public function variant_values()
    // {
    //     return $this->hasMany(VariantValue::class);
    // }
    public function skus()
    {
        return $this->hasMany(Sku::class);
    }


    public function getDiscountAttribute($value)
    {
        $product = $this;
        // dd($this->categories);
        $discount = [];
        if ($product->categories) {
            foreach ($product->categories as  $category) {
                $discount[] = $category->discounts;
                // foreach ($category->discounts as  $discount) {
                //     dd($discount);
                //     if ($discount->discount_unit == 'percentage') {
                //         return $discount->discount_value . '/' . $discount->discount_unit;
                //     }
                // }
            }
        }
        // dd($discount);
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new SellerproductScope);
    }
}
