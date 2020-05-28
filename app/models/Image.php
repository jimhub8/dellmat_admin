<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getImageAttribute($value)
    {
        return  Storage::disk('spaces')->url($value);

        // return $file = Storage::disk('spaces')->get($value);
        // dd($file);
        // $mimetype = \GuzzleHttp\Psr7\mimetype_from_filename($value);
        // $headers = [
        //     'Content-Type' => $mimetype,
        // ];
        // return response($file, 200, $headers);

        // if (env('GCE_STORAGE_PATH') == 'gcs') {
            // return $this->attributes['image'] = env('GCE_STORAGE_PATH', 'https://storage.cloud.google.com/ecomerce_bucket') . $value;
        // }
    }
}
