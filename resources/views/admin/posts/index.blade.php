@extends('layouts.app')


@section('content')
    <div class="contaienr">
        <h1>Gestisci i post</h1>

        <div class="row">
            @foreach($posts as $post)
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <a href="#" class="btn btn-primary">Go to post</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection