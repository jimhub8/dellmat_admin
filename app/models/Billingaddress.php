<?php

namespace App\models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Billingaddress extends Model
{
    protected $fillable = [
        'name', 'street_address', 'town', 'county', 'postal_code', 'phone', 'email', 'country'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
