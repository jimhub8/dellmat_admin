<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    // public $with = ['option_values'];
    public function product_options()
    {
        return $this->hasMany(ProductOption::class);
    }
    public function variant_values()
    {
        return $this->hasMany(VariantValue::class);
    }
    public function option_values()
    {
        return $this->hasMany(OptionValue::class);
    }
}
