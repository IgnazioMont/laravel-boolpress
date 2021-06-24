@extends('layouts.app')


@section('content')
    <div class="container">
        <h1>Modify post: {{ $post->title }}</h1>

        {{-- Gestiamo gli errori --}}
        @if($errors->any())
            <div class="alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Creiamo il form --}}
        <form action="{{ route('admin.posts.update', ['post' => $post->id]) }}" method="post">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Title</label> {{-- mette con old quello che trova altrimenti di default mette il titolo del post --}}
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title) }}">
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" class="form-control" id="content" cols="30" rows="10">{{ old('content', $post->content) }}</textarea>
            </div>

            <div class="form-group">
                <label for="category_id">Category</label>
                <select class="form-control" name="category_id" id="category_id">
                    <option value="">Empty</option>
                    @foreach($categories as $category) 
                        {{-- Man mano che si scorre la categoria, se è old diventa selected,
                            inseriamo un secondo parametro in modo che lo paragona col default se l'utente non ha ancora inviato il form --}}
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}> {{ $category->name }} </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <h5>Tags</h5>
                
                @foreach($tags as $tag)
                    <div class="form-check">
                        {{-- C'è un problema: quando accediamo al form la prima volta, il valore dei tag selezionati sono nel contains che è una COLLECTION
                            quindi non si può usare in_array. 
                            Quando invece l'utente ha già inviato il form abbiamo a disposizione un array quindi la si risolve
                            controllando se ci sono errori di validazione in corso.    
                        --}}
                        
                        @if ($errors->any())
                            <input  class="form-check-input" 
                                    type="checkbox"
                                    value="{{ $tag->id }}"
                                    name="tags[]"
                                    id="tag-{{ $tag->id }}"
                                    {{-- Gli diciamo anche che se l'id corrente si trova all'interno di old tags, è checked altrimenti niente --}}
                                    {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
                            >
                        @else
                            <input  class="form-check-input" 
                                    type="checkbox"
                                    value="{{ $tag->id }}"
                                    name="tags[]"
                                    id="tag-{{ $tag->id }}"
                                    {{-- funzione che ci dice se il model con un dato ID ha una relazione col model attuale --}}
                                    {{ $post->tags->contains($tag->id) ? 'checked' : '' }}
                            >
                        @endif
                        {{-- Se ci sono errori di validazione ci basiamo su old altrimenti utilizzo il contains per popolare le checkbox --}}
                        
                        <label class="form-check-label" for="tag-{{ $tag->id }}">
                            {{ $tag->name }}
                        </label>
                    </div>
                @endforeach
            </div>

            <input type="submit" class="btn btn-success" value="Save changes">
        </form>
    </div>
@endsection