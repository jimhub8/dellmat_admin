<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
