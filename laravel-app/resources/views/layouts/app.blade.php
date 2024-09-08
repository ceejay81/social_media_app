<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Social Media Fakebook') }}</title>

    <!-- Vite Styles -->
    @vite([
        'resources/css/app.css',
        'resources/assets/css/demo.css',
    ])

    <!-- Fonts and Icons -->
    <link rel="stylesheet" href="{{ asset('resources/assets/vendor/fonts/remixicon/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/assets/vendor/fonts/remixicon/remixicon.scss') }}">

    <!-- Additional Styles -->
    <style>
        body {
            font-family: 'Figtree', sans-serif; /* Example of using a custom font */
        }
    </style>

    <!-- Link to the new sidebar CSS file -->
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    
    <!-- Compiled Remix Icon CSS -->
    <link href="{{ asset('css/remixicon.css') }}" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="flex flex-col min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-md">
            <div class="container mx-auto px-4 py-2 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-blue-600">FakeBook</h1>
                <!-- Add header content (e.g., search bar, notifications, user menu) -->
            </div>
        </header>

        <div class="flex flex-1">
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Vite Scripts -->
    @vite([
        'resources/js/app.js',
    ])

    <!-- Additional Scripts -->
    <script src="{{ asset('resources/assets/vendor/js/bootstrap.js') }}"></script>

    <!-- Initialize any JS components if needed -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialization code here
        });
    </script>
</body>
</html>
