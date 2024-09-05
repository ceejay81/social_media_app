<!DOCTYPE html>
<html lang="en">

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
</head>

<body class="bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100">
    <!-- Page Container -->
    <div id="app" class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-gray-100 dark:bg-gray-800 dark:text-gray-100">
            <!-- Sidebar content here -->
            @include('layouts.sidebar')
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow dark:bg-gray-800">
                <div class="container mx-auto px-6 py-4">
                    <!-- Header content here -->
                    @include('layouts.header')
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6">
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
