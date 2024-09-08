@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="{{ __('Name') }}">
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="{{ __('Email') }}">
        </div>

        <!-- Password -->
        <div class="mb-3">
            <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" placeholder="{{ __('Password') }}">
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm Password') }}">
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-success btn-lg">{{ __('Register') }}</button>
        </div>

        <div class="text-center mt-3">
            <a class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
        </div>
    </form>
@endsection
