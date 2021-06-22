@extends('layouts.app')


@section('content')
    <div class="contaienr">
        <h1>Category's recipes: {{ $category->name }}</h1>

        <ul>
            @foreach($related_posts as $post)
                <li>
                    <a href="{{ route('blog-page', ['slug' => $post->slug]) }}">{{ $post->title }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection