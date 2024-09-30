@extends('layouts.auth')

@section('title', 'Login to FakeBook')

@section('content')
    <div class="login-container">
        <div class="login-content">
            <div class="login-form-container">
                <h1 class="fakebook-logo">fakebook</h1>
                <p class="login-subtitle">Connect with friends and the world around you on Fakebook.</p>
                <form method="POST" action="{{ route('login') }}" class="login-form">
                    @csrf
                    <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="{{ __('Email or Phone Number') }}">
                    <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">
                    <button type="submit" class="login-button">{{ __('Log In') }}</button>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">
                            {{ __('Forgotten password?') }}
                        </a>
                    @endif
                    <hr class="login-divider">
                    <a href="{{ route('register') }}" class="create-account-button">{{ __('Create New Account') }}</a>
                </form>
            </div>
        </div>
    </div>

    <style>
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: linear-gradient(to bottom, #8e2de2, #4a00e0), url('/images/mountain-landscape.jpg');
            background-size: cover, cover;
            background-position: center, bottom;
            background-blend-mode: multiply;
        }
        .login-content {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1), 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 396px;
        }
        .fakebook-logo {
            font-size: 4rem;
            font-weight: bold;
            color: #1877f2;
            text-align: center;
            margin-bottom: 10px;
        }
        .login-subtitle {
            font-size: 1.2rem;
            text-align: center;
            color: #606770;
            margin-bottom: 20px;
        }
        .login-form {
            display: flex;
            flex-direction: column;
        }
        .form-input {
            padding: 14px 16px;
            font-size: 17px;
            border: 1px solid #dddfe2;
            border-radius: 6px;
            margin-bottom: 12px;
        }
        .login-button {
            background-color: #1877f2;
            color: white;
            padding: 14px 16px;
            font-size: 20px;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-bottom: 16px;
        }
        .login-button:hover {
            background-color: #166fe5;
        }
        .forgot-password {
            text-align: center;
            color: #1877f2;
            font-size: 14px;
            text-decoration: none;
            margin-bottom: 20px;
            display: block;
        }
        .login-divider {
            border-top: 1px solid #dadde1;
            margin: 20px 0;
        }
        .create-account-button {
            background-color: #42b72a;
            color: white;
            padding: 14px 16px;
            font-size: 17px;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin: 0 auto;
        }
        .create-account-button:hover {
            background-color: #36a420;
        }
    </style>
@endsection
