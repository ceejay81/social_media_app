@extends('layouts.auth')

@section('title', 'Register for FakeBook')

@section('content')
    <div class="register-container">
        <div class="register-content">
            <div class="register-form-container">
                <h1 class="fakebook-logo">fakebook</h1>
                <h2 class="register-title">Create a new account</h2>
                <p class="register-subtitle">It's quick and easy.</p>
                <form method="POST" action="{{ route('register') }}" class="mt-4" id="registerForm">
                    @csrf
                    <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="{{ __('Name') }}">
                    <div class="mb-3">
                        <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="{{ __('Email') }}">
                        <small id="emailHelp" class="form-text text-danger"></small>
                    </div>
                    <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" placeholder="{{ __('Password') }}">
                    <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm Password') }}">
                    
                    <p class="terms">By clicking Sign Up, you agree to our Terms, Data Policy and Cookie Policy.</p>
                    
                    <button type="submit" class="btn btn-primary w-100 mb-3" id="registerButton">{{ __('Register') }}</button>
                </form>
                <div class="login-link">
                    <a href="{{ route('login') }}">{{ __('Already have an account?') }}</a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .register-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: linear-gradient(to bottom, #8e2de2, #4a00e0), url('/images/mountain-landscape.jpg');
            background-size: cover, cover;
            background-position: center, bottom;
            background-blend-mode: multiply;
        }
        .register-content {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1), 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 432px;
        }
        .fakebook-logo {
            font-size: 4rem;
            font-weight: bold;
            color: #1877f2;
            text-align: center;
            margin-bottom: 10px;
        }
        .register-title {
            font-size: 2rem;
            font-weight: bold;
            color: #1c1e21;
            margin-bottom: 10px;
        }
        .register-subtitle {
            font-size: 1rem;
            color: #606770;
            margin-bottom: 20px;
        }
        .register-form {
            display: flex;
            flex-direction: column;
        }
        .form-input {
            padding: 11px;
            font-size: 15px;
            border: 1px solid #dddfe2;
            border-radius: 6px;
            margin-bottom: 12px;
        }
        .terms {
            font-size: 11px;
            color: #777;
            margin-bottom: 20px;
        }
        .register-button {
            background-color: #00a400;
            color: white;
            padding: 14px 16px;
            font-size: 18px;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-bottom: 16px;
        }
        .register-button:hover {
            background-color: #009400;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
        }
        .login-link a {
            color: #1877f2;
            font-size: 14px;
            text-decoration: none;
        }
    </style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    const emailHelp = document.getElementById('emailHelp');
    const registerButton = document.getElementById('registerButton');
    const registerForm = document.getElementById('registerForm');

    function validateEmail(email) {
        const regex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
        return regex.test(email);
    }

    emailInput.addEventListener('input', function() {
        if (!validateEmail(this.value)) {
            emailHelp.textContent = 'Please enter a valid @gmail.com email address.';
            registerButton.disabled = true;
        } else {
            emailHelp.textContent = '';
            registerButton.disabled = false;
        }
    });

    registerForm.addEventListener('submit', function(e) {
        if (!validateEmail(emailInput.value)) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Invalid Email',
                text: 'Please enter a valid @gmail.com email address.',
                confirmButtonColor: '#4c1d95'
            });
        }
    });

    // Display Laravel validation errors using SweetAlert2
    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: '{!! implode("<br>", $errors->all()) !!}',
            confirmButtonColor: '#4c1d95'
        });
    @endif
});
</script>
@endpush
