<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Ordershipping extends Model
{
    protected $fillable = [
        'sale_id', 'shippingaddress_id'
    ];
    public $with = ['shipping'];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function shipping()
    {
        return $this->belongsTo(Shippingaddress::class);
    }
}
