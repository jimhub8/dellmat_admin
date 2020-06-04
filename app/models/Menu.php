<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
