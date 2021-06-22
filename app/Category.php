<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Ad una categoria possono far riferimento + post
    public function posts() {
        return $this->hasMany('App\Post');
    }
}