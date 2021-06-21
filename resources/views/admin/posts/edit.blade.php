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
                <textarea name="content" class="form-control" id="content" cols="30" rows="10"  value="{{ old('content', $post->content) }}"></textarea>
            </div>

            <input type="submit" class="btn btn-success" value="Save changes">
        </form>
    </div>
@endsection