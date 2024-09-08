<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'FakeBook') }} - @yield('title')</title>

    <!-- Importing CSS from Materio Template using Vite -->
    @vite('resources/assets/vendor/scss/core.scss')
    @vite('resources/assets/vendor/scss/theme-default.scss')
    @vite('resources/css/app.css')

    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Figtree', sans-serif;
        }
        .auth-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .auth-card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1), 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            max-width: 400px;
        }
        .facebook-logo {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 40px;
            font-weight: bold;
            color: #1877f2;
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #1877f2;
            border-color: #1877f2;
        }
        .btn-primary:hover {
            background-color: #166fe5;
            border-color: #166fe5;
        }
        .btn-success {
            background-color: #42b72a;
            border-color: #42b72a;
        }
        .btn-success:hover {
            background-color: #36a420;
            border-color: #36a420;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="facebook-logo">f</div>
            @yield('content')
        </div>
    </div>

    <!-- Importing JavaScript files -->
    @vite('resources/js/app.js')
</body>
</html>
