<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    /* 2 funzioni, una per tutti i post, una per il singolo post */
    public function index() {
        $posts = Post::all();

        $data = [
            'posts' => $posts
        ];

        return view('guest.posts.index', $data);
    }

    /* facciamo vedere il contenuto del post tramite slug anzichè tramite ID */
    public function show($slug) {
        $post = Post::where('slug', '=', $slug)->first();

        /* diciamo anche che se non ha trovato il post -> abort */
        if(!$post) {
            abort('404');
        }

        $data = [
            'post' => $post,
            'post_category' => $post->category
        ];

        return view('guest.posts.show', $data);
    }

    /* Creiamo la pagina che stampi la lista dei post, torna html con Vue,
    leggiamo con axios le API e stampiamo i post */
    public function vuePosts() {
        /* i dati quindi non li prendiamo con il solito data ma con axios */
        return view('guest.posts.vue-posts');
    }
}
