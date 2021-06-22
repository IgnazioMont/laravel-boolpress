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

            {{-- inseriamo l'id della categoria da collegare, lo popola col numero dell'id --}}
            <div class="form-group">
                <label for="category_id">Category</label>
                <select class="form-control" name="category_id" id="category_id">
                    <option value="">Empty</option>

                    @foreach($categories as $category)
                        {{-- Gli mettiamo anche l'old per lasciare l'option selezionata, altrimenti è vuota --}}
                        {{-- Man mano che si scorre la categoria, se è old diventa selected --}}
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}> {{ $category->name }} </option>
                    @endforeach
                </select>
            </div>

            <input type="submit" class="btn btn-success" value="Save">
        </form>
    </div>
@endsection