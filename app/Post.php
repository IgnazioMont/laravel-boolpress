<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'slug',
        'category_id' /* bisogna inserire la categoria per far si che riesca a salvarla nella view */
    ];

    /* diciamo a chi fa riferimento l'id della colonna */
    public function category() { /* singolare, è una "one to many" */
        return $this->belongsTo('App\Category');
    }
}
