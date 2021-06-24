@extends('layouts.app')


@section('content')
    <div class="container">
        <h1>{{ $post->title }}</h1>

        {{-- Per debug nel pannello di amministrazione possiamo anche stamparci lo SLUG --}}
        <div><b>SLUG: </b> <i>{{ $post->slug }}</i></div>

        {{-- Se esiste, stampiamo --}}
        @if($post_category)
            <div><b>Category: </b> <i>{{ $post_category->name }}</i></div>
        @endif

        <div>
            <strong class="mt-2 mb-2">Tags: </strong>
            @foreach ($post_tags as $tag)
                {{-- per ogni tag stampiamo seguito da virgola, la togliamo all'ultima iterazione --}}
                {{ $tag->name }}{{ $loop->last ? '' : ', '}}
            @endforeach
        </div>

        <p>{{ $post->content }}</p>

        <a href="{{ route('admin.posts.edit', ['post' => $post->id]) }}" class="btn btn-warning">Edit post</a>
    </div>
@endsection