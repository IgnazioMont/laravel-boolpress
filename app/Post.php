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

    /* Diciamo quindi che quando lavoriamo sui post, quando leggiamo i tag abbiamo una relaz. con il model App\Tag */
    public function tags() {
        return $this->belongsToMany('App\Tag', 'post_tag');
        /* Come secondo parametro scriviamo in modo esplicito la tabella ponte 
        a cui fa riferimento per evitare problemi, tipo quando non sono in ordine alfabetico */
    }
}
