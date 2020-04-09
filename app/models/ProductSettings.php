<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ProductSettings extends Model
{
    public function setFeaturedAttribute($value)
    {
        $this->attributes['featured'] = serialize($value);
    }
    public function setNewproductAttribute($value)
    {
        $this->attributes['newproduct'] = serialize($value);
    }
    public function setBestsellersAttribute($value)
    {
        $this->attributes['bestsellers'] = serialize($value);
    }


    public function getFeaturedAttribute($value)
    {
        $this->attributes['featured'] = unserialize($value);
    }
    public function getNewproductAttribute($value)
    {
        $this->attributes['newproduct'] = unserialize($value);
    }
    public function getBestsellersAttribute($value)
    {
        $this->attributes['bestsellers'] = unserialize($value);
    }
}
