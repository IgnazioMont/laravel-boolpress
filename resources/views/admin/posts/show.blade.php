@extends('layouts.app')


@section('content')
    <div class="container">
        <h1>{{ $post->title }}</h1>

        {{-- Per debug nel pannello di amministrazione possiamo anche stamparci lo SLUG --}}
        <div><b>SLUG: </b> <i>{{ $post->slug }}</i></div>
        <br>
        <p>{{ $post->content }}</p>

        <a href="{{ route('admin.posts.edit', ['post' => $post->id]) }}" class="btn btn-warning">Edit post</a>
    </div>
@endsection