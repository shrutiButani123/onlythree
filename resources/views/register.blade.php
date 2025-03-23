@extends('layouts.app')

@section('content')

<div class="container my-5">
        <div class="card shadow-lg rounded-lg">
            <div class="card-body">
                <h1 class="text-center mb-4">Registration Form</h1>
                <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-row mb-4">
                        <div class="form-group col-md-6">
                            <label for="name">First Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                            @error('name')  <span class="text-danger text-sm">{{ $message }}</span> @enderror
                        </div>                    
                    </div>

                    <div class="form-group mb-4">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email')  <span class="text-danger text-sm">{{ $message }}</span> @enderror
                    </div>
            
                    <div class="form-group mb-4">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')  <span class="text-danger text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
                        @error('password_confirmation')  <span class="text-danger text-sm">{{ $message }}</span> @enderror
                    </div>                   

                    <div class="form-group mb-4">
                        <label>Hobbies</label><br>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="hobbies[]" value="reading" class="form-check-input" {{in_array('reading', old('hobbies', [])) ? 'checked' : '' }} id="reading">
                            <label class="form-check-label" for="reading">Reading</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="hobbies[]" value="sports" class="form-check-input" {{in_array('sports', old('hobbies', [])) ? 'checked' : '' }} id="sports">
                            <label class="form-check-label" for="sports">Sports</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="hobbies[]" value="traveling" class="form-check-input" {{in_array('traveling', old('hobbies', [])) ? 'checked' : '' }} id="traveling">
                            <label class="form-check-label" for="traveling">Traveling</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="hobbies[]" value="music" class="form-check-input" {{in_array('music', old('hobbies', [])) ? 'checked' : '' }} id="music">
                            <label class="form-check-label" for="music">Music</label>
                        </div>
                        @error('hobbies.*')  <span class="text-danger text-sm">{{ $message }}</span> @enderror
                        @error('hobbies')  <span class="text-danger text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- <div class="form-group mb-4">
                        <label for="role">Role</label>
                        <select name="role[]" id="role" class="form-control @error('first_name) is-invalid @enderror" multiple>
                            <option value="1">Admin</option>
                            <option value="2">User</option>
                            <option value="3">Moderator</option>
                        </select>
                    </div> -->

                    <div class="form-group mb-4">
                        <label for="state">State</label>
                        <select id="state" name="state" class="form-control @error('state') is-invalid @enderror">
                            <option value="">Select a State</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach                            
                        </select>
                        @if ($errors->has('state'))
                            <span class="text-danger text-sm">{{ $errors->first('state') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-4">
                        <label for="city">City</label>
                        <select id="city" name="city" class="form-control @error('city') is-invalid @enderror">
                            <option value="">Select a City</option>                            
                        </select>
                        @error('city')  <span class="text-danger text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group text-center mb-4">
                        <button type="submit" class="btn btn-secondary btn-lg">Register</button>
                    </div>
                </form>

                <div class="text-center">
                    <p>Have an account? <a href="http://127.0.0.1:8000/login" class="text-primary">Login here</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection