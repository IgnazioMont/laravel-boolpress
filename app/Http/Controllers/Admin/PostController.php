<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        $data = [
            'posts' => $posts
        ];

        return view('admin.posts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /* invia i dati a STORE */
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* Facciamo la validazione */
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required|max:60000'
        ]);

        $new_post_data = $request->all();

        /* Creiamo lo SLUG */
        $new_slug = Str::slug($new_post_data['title'], '-');
        $base_slug = $new_slug;
        /* Controlliamo che non esista già un post con lo stesso SLUG */
        $post_exist_slug = Post::where('slug', '=', $new_slug)->first();
        $count = 1;

        /* Se esiste proviamo con altri SLUG */
        while($post_exist_slug) {
            $new_slug = $base_slug . '-' . $count;
            $count++;
            /* Se esiste un post con lo stesso SLUG torna un'istanza di post altrimenti è NULL e fa una nuova iterazione*/
            $post_exist_slug = Post::where('slug', '=', $new_slug)->first();
        }

        /* Popoliamo il data da salvare quando troviamo il nuovo slug */
        $new_post_data['slug'] = $new_slug;

        $new_post = new Post();
        $new_post->fill($new_post_data);
        $new_post->save();

        return redirect()->route('admin.posts.show', ['post' => $new_post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        $data = [
            'post' => $post
        ];

        return view('admin.posts.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        /* prepopoliamo il form con i contenuti già presenti */
        $data = [
            'post' => $post
        ];

        return view('admin.posts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /* Facciamo la validazione (o creiamo una funzione privata che gli passiamo) */
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required|max:60000'
        ]);

        $modif_post_data = $request->all();    
        
        /* ci serve la riga da modificare nel DB */
        $post = Post::findOrFail('id');

        /* Di default rimane immutato, uguale a quello che c'è già nel post */
        $modif_post_data['slug'] = $post->slug;   

        /* Ricalcolo il nuovo SLUG solo se il titolo nuovo del post è diverso da quello precedente */
        if($modif_post_data['title'] != $post->title) {
            /* Dobbiamo prima gestire lo SLUG (anche tramite funzione volendo) */
            $new_slug = Str::slug($modif_post_data['title'], '-');
            $base_slug = $new_slug;
            /* Controlliamo che non esista già un post con lo stesso SLUG */
            $post_exist_slug = Post::where('slug', '=', $new_slug)->first();
            $count = 1;

            /* Se esiste proviamo con altri SLUG */
            while($post_exist_slug) {
                $new_slug = $base_slug . '-' . $count;
                $count++;
                /* Se esiste un post con lo stesso SLUG torna un'istanza di post altrimenti è NULL e fa una nuova iterazione*/
                $post_exist_slug = Post::where('slug', '=', $new_slug)->first();
            }

            /* Popoliamo il data da salvare quando troviamo il nuovo slug */
            $modif_post_data['slug'] = $new_slug;
        }

        
        /* Se non lo trova, err 404 */
        $post->update($modif_post_data);

        return redirect()->route('admin.posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('admin.posts.index');
    }
}
