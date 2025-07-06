@extends('layout.app')

@section('title', 'Login')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow p-4">
                <h3 class="text-center mb-4">Login</h3>

                @if(session('login_error'))
                    <div class="alert alert-danger">
                        {{ session('login_error') }}
                    </div>
                @endif

                <form method="POST" action="/login">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Username</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                        @error('name')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                        @error('password')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Login</button>

                    <div class="text-center mt-3">
                        <a href="/register">Don't have an account? Register</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection