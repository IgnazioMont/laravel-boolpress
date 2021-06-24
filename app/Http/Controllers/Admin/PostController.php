<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Tag;
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
        /* "detach" elimina una relazione
            se ci sono duplicati si eliminano entrambi
        
        es. $post = Post::find(*numeroPostID);
            $post->tags()->detach(*numeroTagID);
        se sono + di uno da elimiare si puà usare l'array: ->detach([*n1, *n2, *n3]);

            con "attach" invece la si aggiunge
        es. $post->tags()->attach(*numeroTagID);
            
        con SYNC sovrascrive totalmente i tag (elimina e aggiunge quelli che scriviamo)
        es. $post->tags()->sync(*numeroTagID);
        con sync([]) array vuoto vuol dire che non gli diamo nessun valore

        QUESTE EVENTUALI MODIFICHE VENGONO EFFETTUATE IMMEDIATAMENTE
        */
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
        /* Prendiamo tutte le categorie + i tag*/
        $categories = Category::all();
        $tags = Tag::all();

        $data = [
            'categories' => $categories,
            'tags' => $tags
        ];

        /* invia i dati a STORE */
        return view('admin.posts.create', $data);
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
            'content' => 'required|max:60000',
            /* Gli diciamo che la categoria per essere valida, deve esistere 
                un corrispettivo nella tabella categories - id, evitiamo che qualcuno 
                possa inserire un id delle categorie che non esiste. 
                (in tal caso avrebbe accesso a diversi dati dell'intero database)
                gli mettiamo anche nullable in caso in cui lasciamo vuota la categoria */
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|exists:tags,id'
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

        /* Una volta che abbiamo popolato il nostro POST facciamo il SYNC per creare la relazione nella tabella ponte */
        /* Se esiste ed è un array lo salviamo, altrimenti */
        if(isset($new_post_data['tags']) && is_array($new_post_data['tags']) ) {
            $new_post->tags()->sync($new_post_data['tags']);
        }

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
            'post' => $post,
            'post_category' => $post->category,
            /* leggiamo anche i tag */
            'post_tags' => $post->tags
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
        $categories = Category::all();

        /* prepopoliamo il form con i contenuti già presenti */
        $data = [
            'post' => $post,
            'categories' => $categories
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
            'content' => 'required|max:60000',
            /* Aggiungiamo anche qui la validazione della categoria */
            'category_id' => 'nullable|exists:categories,id'
        ]);

        $modif_post_data = $request->all();    
        
        /* ci serve la riga da modificare nel DB */
        $post = Post::findOrFail($id);

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
