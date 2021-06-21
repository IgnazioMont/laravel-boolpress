@extends('layouts.app')


@section('content')
    <div class="container">
        <h1>Create a new post</h1>

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
        <form action="{{ route('admin.posts.store') }}" method="post">
            @csrf
            @method('POST')

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" class="form-control" id="content" cols="30" rows="10" value="{{ old('content') }}"></textarea>
            </div>

            <input type="submit" class="btn btn-success" value="Save">
        </form>
    </div>
@endsection