<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Drawer extends Model
{
    use SoftDeletes;
    public $with = ['sales'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function sales()
    {
        return $this->hasMany('App\models\Sale');
    }
}
