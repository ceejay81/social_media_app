<!-- Header -->
<div class="flex items-center justify-between py-4 px-6 bg-white dark:bg-gray-800 shadow-md">
    <!-- Logo -->
    <a href="{{ url('/') }}" class="text-2xl font-semibold text-gray-800 dark:text-gray-100 flex items-center space-x-2">
        <img src="{{ asset('images/logo.png') }}" alt=" Logo" class="w-8 h-8 rounded-full">
        <span>Fakebook</span>
    </a>

    <!-- Search Bar -->
    <div class="flex-1 mx-4">
        <input type="text" placeholder="Search..." class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100" />
    </div>

    <!-- Navigation Icons -->
    <div class="flex items-center space-x-4">
        <!-- Notifications -->
        <a href="#" class="relative text-gray-800 dark:text-gray-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-2.81A2 2 0 0016 14h-1V6a2 2 0 00-2-2H8a2 2 0 00-2 2v8H5a2 2 0 00-1.595.81L2 17h5m4 0a3 3 0 006 0h-6z"></path>
            </svg>
            <!-- Notification Badge -->
            <span class="absolute top-0 right-0 block w-2.5 h-2.5 bg-red-500 rounded-full"></span>
        </a>

        <!-- Messages -->
        <a href="#" class="text-gray-800 dark:text-gray-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v12H4V4zM4 20h16a2 2 0 002-2V6H2v12a2 2 0 002 2z"></path>
            </svg>
        </a>

        <!-- User Profile -->
        <div class="relative">
            <button id="user-menu-button" aria-expanded="false" aria-haspopup="true">
            <img src="{{ asset(auth()->user()->profile_picture_url) }}" alt="User" class="w-8 h-8 rounded-full">
            </button>
            <div id="user-menu" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg hidden">
                <ul class="py-1">
                    <li>
                        <a href="{{ route('profile.show', auth()->user()) }}" class="block px-4 py-2 text-gray-800 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a>
                    </li>
                    <li>
                        <a href="{{ route('settings') }}" class="block px-4 py-2 text-gray-800 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700">Settings</a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}" class="block px-4 py-2 text-gray-800 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Optional: JavaScript for Dropdown -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');

        userMenuButton.addEventListener('click', function () {
            const isVisible = userMenu.classList.contains('hidden');
            userMenu.classList.toggle('hidden', !isVisible);
        });

        document.addEventListener('click', function (event) {
            if (!userMenu.contains(event.target) && !userMenuButton.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });
    });
</script>
