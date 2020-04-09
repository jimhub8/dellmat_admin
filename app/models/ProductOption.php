<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductOption extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'option_id', 'product_id'
    ];

    public $with = ['option'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function option()
    {
        return $this->belongsTo(Option::class);
    }
    public function variant_values()
    {
        return $this->hasMany(VariantValue::class, 'product_option_id');
    }
}
