<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug'
    ];

    /* Allo stesso modo se lavoriamo con la classe Tag, quando vogliamo sapere i post legati, chiederà a User */
    public function posts() {
        return $this->belongsToMany('App\Post');
    }
}
