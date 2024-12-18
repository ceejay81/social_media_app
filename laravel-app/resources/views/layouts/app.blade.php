<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FakeBook') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Additional Styles -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
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

    @auth
    <meta name="user-id" content="{{ Auth::id() }}">
    @endauth

    <script>
        window.userId = {{ auth()->id() }};
    </script>
</head>

<body class="bg-gray-100">
    <div class="flex flex-col min-h-screen">
        <!-- Header -->
        @include('layouts.navigation')

        <div class="flex flex-1 pt-16"> <!-- Added pt-16 here -->
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4 ml-64"> <!-- Added ml-64 here -->
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

    <!-- Pusher Script -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
        });

        var channel = pusher.subscribe('notifications.{{ auth()->id() }}');
        channel.bind('new.notification', function(data) {
            // Handle the new notification
            console.log('New notification:', data);
            // Add the new notification to the UI
            addNotificationToUI(data);
            
            // Show a toast notification
            showToastNotification(data.message);
        });

        function addNotificationToUI(data) {
            const container = document.getElementById('notifications-container');
            if (!container) return;

            const notificationElement = document.createElement('div');
            notificationElement.className = 'notification-item p-2 border-b';
            notificationElement.innerHTML = `
                <p><strong>${data.user_name}</strong> ${data.action} ${data.reaction}</p>
                <small>${new Date().toLocaleTimeString()}</small>
            `;

            container.prepend(notificationElement);
        }

        function showToastNotification(message) {
            // Create toast element
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-4 right-4 bg-blue-500 text-white p-2 rounded shadow-lg';
            toast.textContent = message;

            // Add to body
            document.body.appendChild(toast);

            // Remove after 3 seconds
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
    </script>

    @yield('scripts')
</body>
</html>
