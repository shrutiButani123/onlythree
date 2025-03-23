@extends('layouts.app')

@section('content')

<div class="container my-5">
        <div class="card shadow-lg rounded-lg">
            <div class="card-body">
            <h1 class="text-center mb-4">Login</h1>

                @if(session('error'))
                    <div class="text-danger text-sm">{{ session('error') }}</div>
                @endif

                @if(session('success'))
                    <div class="text-success text-sm">{{ session('success') }}</div>
                @endif

                <form action="{{ route('login.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- <div class="mb-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember" class="mr-2">
                            <label for="remember" class="text-sm">Remember me</label>
                        </div>
                    </div> -->

                    <div class="mb-4 text-center">
                        <button type="submit" class="btn btn-secondary btn-lg">Login</button>
                    </div>
                </form>
                <div class="mt-4 text-center">
                    <p class="text-sm">Don't have an account? <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Register here</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
