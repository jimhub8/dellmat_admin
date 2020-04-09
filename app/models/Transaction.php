<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $fillable = [
        'seller_id', 'amount'
    ];
    // public function reduce($amount, $seller_id)
    // {
    //     Transaction::where('seller_id', $seller_id)->decrement('amount', $amount);;
    // }

    // public function increment($amount, $seller_id)
    // {
    //     Transaction::where('seller_id', $seller_id)->increment('amount', $amount);
    // }
}
