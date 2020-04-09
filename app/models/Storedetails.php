<?php

namespace App\models;

use App\Seller;
use Illuminate\Database\Eloquent\Model;

class Storedetails extends Model
{
    protected $fillable = [
        'seller_id', 'company_name', 'company_address', 'address_2', 'company_phone', 'company_email', 'company_website', 'postal_code', 'business_no', 'building', 'floor', 'location', 'longitude', 'latitude', 'payment_mode', 'bank_name', 'bank_code', 'account_no', 'branch', 'account_name', 'mpesa_reg_name', 'mpesa_phone',
    ];
    public function seller()
    {
        return $this->hasOne(Seller::class);
    }
}
