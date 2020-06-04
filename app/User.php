<?php

namespace App;

use App\models\Billingaddress;
use App\models\Shippingaddress;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;

// use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, SoftDeletes, HasApiTokens;
    public $with = ['billing', 'shipping'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
        'drawer_open' => 'boolean',
    ];


    /**
     * Get all user permissions.
     *
     * @return bool
     */
    // public function getAllPermissionsAttribute()
    // {
    //     return $this->getAllPermissions();
    // }

    // public function getCreatedAtAttribute($date)
    // {
    //     return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('M-d-Y');
    // }
    public function sales()
    {
        return $this->hasMany('App\models\Sale');
    }
    public function drawers()
    {
        return $this->hasMany('App\models\Drawer');
    }

    public function billing()
    {
        return $this->hasOne(Billingaddress::class);
    }
    public function shipping()
    {
        return $this->hasOne(Shippingaddress::class);
    }

    public function wishes()
    {
        return $this->hasMany(wish::class);
    }
    public function logged_user()
    {
        if (Auth::check()) {
            return Auth::user();
        } elseif (Auth::guard('seller')->check()) {
            return Auth::guard('seller')->user();
        }elseif (Auth::guard('admin')->check()) {
            return Auth::guard('admin')->user();
        }
    }
}
