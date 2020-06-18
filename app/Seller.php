<?php

namespace App;

use App\models\Product;
use App\models\ProductSale;
use App\models\Storedetails;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\Seller\SellerResetPassword;
use App\Notifications\Seller\SellerVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Seller extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new SellerResetPassword($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new SellerVerifyEmail);
    }

    public function productsales()
    {
        return $this->hasMany(ProductSale::class);
    }


    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public function storedetail()
    {
        return $this->hasOne(Storedetails::class);
    }


}
