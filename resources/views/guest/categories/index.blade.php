@extends('layouts.app')


@section('content')
    <div class="contaienr">
        <h1>Here's the categories</h1>

        <div class="row">
            @foreach($categories as $category)
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $category->name }}</h5>
                            <a href="{{ route('category-page', ['slug' => $category->slug]) }}" class="btn btn-primary">Category's posts</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection