<!-- Header -->
<header class="bg-white shadow-md">
    <div class="container mx-auto px-4 py-2 flex items-center justify-between">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
            <i class="fab fa-facebook"></i>
        </a>

        <!-- Search Bar -->
        <div class="flex-grow mx-4">
            <form action="{{ route('search') }}" method="GET" class="relative">
                <input type="text" name="q" placeholder="Search..." class="w-full py-2 px-4 bg-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <!-- Navigation Icons -->
        <div class="flex items-center space-x-4">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600">
                <i class="fas fa-home text-2xl"></i>
            </a>
            <a href="{{ route('friends.index') }}" class="text-gray-600 hover:text-blue-600">
                <i class="fas fa-user-friends text-2xl"></i>
            </a>
            <a href="{{ route('messages.index') }}" class="text-gray-600 hover:text-blue-600">
                <i class="fab fa-facebook-messenger text-2xl"></i>
            </a>
            <a href="{{ route('notifications.index') }}" class="text-gray-600 hover:text-blue-600">
                <i class="fas fa-bell text-2xl"></i>
            </a>
            <div class="relative">
                <button id="user-menu-button" class="flex items-center focus:outline-none">
                    <img src="{{ Auth::user()->profile_picture_url ?? asset('images/default-avatar.jpg') }}" alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full">
                </button>
                <!-- Dropdown menu -->
                <div id="user-menu-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                    <a href="{{ route('profile.show', Auth::user()) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                    <a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Optional: JavaScript for Dropdown -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenuDropdown = document.getElementById('user-menu-dropdown');

        userMenuButton.addEventListener('click', function () {
            userMenuDropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', function (event) {
            if (!userMenuButton.contains(event.target) && !userMenuDropdown.contains(event.target)) {
                userMenuDropdown.classList.add('hidden');
            }
        });
    });
</script>
