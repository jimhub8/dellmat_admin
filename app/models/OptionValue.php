<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
    public $with = ['option'];
    public function option()
    {
        return $this->belongsTo(Option::class);
    }
    public function variant_values()
    {
        return $this->hasMany(VariantValue::class);
    }
}
