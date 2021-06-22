@extends('layouts.app')


@section('content')
    <div class="container">
        {{-- Aggiungiamo anche la categoria, facciamo una if in caso non è stata assegnata la categoria --}}
        @if($post_category) {{-- se esiste post_category la stampiamo --}}
            <div class="mt-2 mb-2">
                Categoria: {{ $post_category->name }}
            </div>
        @endif

        <h1>{{ $post->title }}</h1>

        <p>{{ $post->content }}</p>
    </div>
@endsection