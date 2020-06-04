<?php

namespace App\models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Shippingaddress extends Model
{
    protected $fillable = [
        'user_id', 'name', 'street_address', 'town', 'county', 'postal_code', 'phone', 'email', 'country'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
