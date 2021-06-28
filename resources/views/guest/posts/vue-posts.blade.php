@extends('layouts.app')


@section('header-scripts')
    <!-- Axios library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    {{-- Vue --}}
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
@endsection


@section('footer-scripts')
    <script src="{{ asset('js/posts.js') }}"></script>
@endsection


@section('content')
    <div class="container">
        
        <div id="root">
            {{-- Per Vue inseriamo @ prima delle graffe --}}
            <h1>@{{ title }}</h1>

            <div class="row">
                <div v-for="post in posts" class="col-4">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">@{{ post.title }}</h5>
                            
                            {{-- Se ci sono, stampiamo anche i tag --}}
                            <div v-if="post.tags.length > 0">
                                Tags:
                                <ul>
                                    <li v-for="tag in post.tags">@{{ tag.name }}</li>
                                </ul>
                            </div>

                            <p class="card-text">@{{ post.content }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection