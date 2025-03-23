@extends('layouts.app')

@section('content')

<div class="container my-5">
        <div class="card shadow-lg rounded-lg">
            <div class="card-body">
            <h1 class="text-center mb-4">{{auth()->user()->name}}</h1>

                @if(session('error'))
                    <div class="text-danger text-sm">{{ session('error') }}</div>
                @endif

                @if(session('success'))
                    <div class="text-success text-sm">{{ session('success') }}</div>
                @endif

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <div class="mb-4 text-center">
                        <button type="submit" class="btn btn-secondary btn-lg">Logout</button>
                    </div>
                </form>

                <div class="mb-4 text-center">
                    <a  href="{{ route('products') }}" class="btn btn-primary btn-lg">Product</a>
                </div>
            </div>
        </div>
    </div>
@endsection
