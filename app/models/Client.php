<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * Get the comments for the blog post.
     */
    public function sales()
    {
        return $this->hasMany('App\models\Sale');
    }
}
