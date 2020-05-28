<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Slider extends Model
{
    public function getImageAttribute($value)
    {
        return  Storage::disk('spaces')->url($value);
    }
}
