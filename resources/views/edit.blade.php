@extends('layout.app')

@section('title', 'Edit page')

@section('content')

<div class="container mt-5">
    @auth
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow p-4">
                    <h3 class="mb-4 text-center">Edit Post</h3>

                    {{-- Show Validation Errors --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="/posts/{{ $post->id }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ $post->title }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="body" class="form-label">Content</label>
                            <textarea name="body" id="body" class="form-control" rows="4" required>{{ $post->body }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endauth
</div>

@endsection

