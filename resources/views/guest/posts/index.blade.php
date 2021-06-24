{{-- GUEST / POSTS / index --}}

@extends('layouts.app')


@section('content')
    <div class="contaienr">
        <h1>Latest recipes</h1>

        <h4>&#10024 Reccomended for you &#10024</h4>

        <div class="row">
            @foreach($posts as $post)
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            {{-- Gli passiamo lo SLUG --}}
                            <a href="{{ route('blog-page', ['slug' => $post->slug] ) }}" class="btn btn-primary">Read</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection