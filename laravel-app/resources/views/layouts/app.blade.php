<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Vite Styles and Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional Styles -->
    <style>
        body {
            font-family: 'Figtree', sans-serif; /* Example of using a custom font */
        }
        
        @keyframes pop-out {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        .pop-out {
            animation: pop-out 0.3s ease-in-out;
        }

        .reaction-btn {
            transition: transform 0.2s;
        }

        .reaction-btn:hover {
            transform: scale(1.2);
        }

        .reaction-options {
            transition: opacity 0.2s, transform 0.2s;
            transform: translateY(10px);
            opacity: 0;
        }

        .reaction-button:hover + .reaction-options,
        .reaction-options:hover {
            opacity: 1;
            transform: translateY(0);
        }

        .comments-section {
            max-height: 300px;
            overflow-y: auto;
        }

        .comment {
            transition: background-color 0.2s;
        }

        .comment:hover {
            background-color: #f3f4f6;
        }

        .edit-comment-form input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 9999px 0 0 9999px;
        }

        .edit-comment-form button {
            padding: 0.5rem 1rem;
            background-color: #3b82f6;
            color: white;
            border-radius: 0 9999px 9999px 0;
        }
    </style>

    <!-- Link to the new sidebar CSS file -->
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    
    <!-- Initialize any JS components if needed -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialization code here
        });
    </script>
    
    @stack('scripts')
</body>
</html>
