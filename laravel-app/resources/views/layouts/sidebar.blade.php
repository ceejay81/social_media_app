<!-- resources/views/layouts/sidebar.blade.php -->
<aside class="w-64 bg-[#1877F2] overflow-y-auto fixed top-0 left-0 h-screen z-40 pt-16">
    <nav class="p-4">
        <ul class="space-y-2">
            <!-- Profile Section -->
            <li>
                <a href="{{ route('profile.show', Auth::user()) }}" class="flex items-center px-4 py-2 text-sm font-medium leading-5 text-white hover:bg-blue-600 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-user text-xl mr-3"></i>
                    <span>Profile</span>
                </a>
            </li>

            <!-- Navigation Section -->
            <li>
                <a href="{{ route('home') }}" class="flex items-center px-4 py-2 text-sm font-medium leading-5 text-white hover:bg-blue-600 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-home text-xl mr-3"></i>
                    <span>Home</span>
                </a>
            </li>
            <li>
                <a href="{{ route('friends.index') }}" class="flex items-center px-4 py-2 text-sm font-medium leading-5 text-white hover:bg-blue-600 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-user-friends text-xl mr-3"></i>
                    <span>Friends</span>
                </a>
            </li>
            <li>
                <a href="{{ route('messages.index') }}" class="flex items-center px-4 py-2 text-sm font-medium leading-5 text-white hover:bg-blue-600 rounded-lg transition duration-150 ease-in-out">
                    <i class="fab fa-facebook-messenger text-xl mr-3"></i>
                    <span>Messages</span>
                </a>
            </li>
            <li>
                <a href="{{ route('notifications.index') }}" class="flex items-center px-4 py-2 text-sm font-medium leading-5 text-white hover:bg-blue-600 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-bell text-xl mr-3"></i>
                    <span>Notifications</span>
                </a>
            </li>

            <!-- Logout (at the bottom) -->
            <li class="mt-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left flex items-center px-1 pt-1 text-sm font-medium leading-5 text-white hover:bg-blue-600 rounded-lg transition duration-150 ease-in-out">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</aside>
