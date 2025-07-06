@extends('layout.app')

@section('title', 'Home')

@section('content')


    <div class="container mt-5">
        @auth


            <h2 class="mb-3">Welcome, <span class="text-success">{{ auth()->user()->name }}</span>!</h2>

            {{-- Show errors --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{session('success')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title">Create a New Post</h4>
                    <form action="/posts" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="text" name="title" class="form-control" placeholder="Post Title">
                        </div>
                        <div class="mb-3">
                            <textarea name="body" class="form-control" rows="3" placeholder="Body content..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Post</button>
                    </form>
                </div>
            </div>

            {{-- Posts --}}
            <h3 class="mb-3">Your Posts</h3>
            @foreach($posts as $post)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text">{{ $post->body }}</p>
                        <p class="text-muted">By {{ $post->user->name ?? 'Unknown' }}</p>

                        <form action="/posts/{{ $post->id }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>

                        <a href="/posts/{{ $post->id }}/edit" class="btn btn-sm btn-outline-primary">Edit</a>
                    </div>
                </div>
            @endforeach
        @endauth
    </div>


    {{-- flash messages, forms, posts, etc. --}}
@endsection