<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getImageAttribute($value)
    {
        // if (env('GCE_STORAGE_PATH') == 'gcs') {
            return $this->attributes['image'] = env('GCE_STORAGE_PATH', 'https://storage.cloud.google.com/ecomerce_bucket') . $value  . '?authuser=1';
        // }
    }
}
