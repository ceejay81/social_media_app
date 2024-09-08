@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="{{ __('Email') }}">
        </div>

        <!-- Password -->
        <div class="mb-3">
            <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">
        </div>

        <!-- Remember Me -->
        <div class="mb-3">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-lg">{{ __('Log in') }}</button>
        </div>

        <div class="text-center mt-3">
            @if (Route::has('password.request'))
                <a class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <hr class="my-4">

        <div class="text-center">
            <a href="{{ route('register') }}" class="btn btn-success btn-lg">{{ __('Create New Account') }}</a>
        </div>
    </form>
@endsection
