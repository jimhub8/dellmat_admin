<?php

namespace App\models;

use App\Scopes\SellerSaleScope;
use App\Seller;
use Illuminate\Database\Eloquent\Model;

class ProductSale extends Model
{
    protected $table = 'product_sale';

    public function seller()
    {
        return $this->hasOne(Seller::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new SellerSaleScope);
    }

}
