<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    /* Esponiamo tutti i post in formato JSON */
    public function index() {
        $posts = Post::all();

        /* Costruiamo l'array prendendo i valori che desideriamo da far stampare */
        $posts_for_response = [];
        /* Inseriamo la categoria */

        foreach($posts as $post) {
            $posts_for_response[] = [
                'title' => $post->title,
                'content' => $post->content,
                /* Se c'è lo stampa altrimenti riga vuota */
                'category' => $post->category ? $post->category->name : '',
                'tags' => $post->tags->toArray()
            ];
        }

        $result = [
            'posts' => $posts_for_response,
            'success' => true
            /* Opzionale, per dire se la chiamata ha avuto successo */
        ];

        return response()->json($result);
    }
}