<!-- resources/views/layouts/sidebar.blade.php -->
<aside class="w-64 bg-[#1877F2] overflow-y-auto fixed top-0 left-0 h-screen z-40 pt-16">
    <nav class="p-4">
        <ul class="space-y-2">
            <!-- Profile Section -->
            <li>
                @php
                    $userId = Auth::id(); // Use the authenticated user's ID
                @endphp
                <a href="{{ route('profile.show', ['user' => $userId]) }}" class="flex items-center px-1 pt-1 text-sm font-medium leading-5 text-white hover:bg-blue-600 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-user mr-3"></i>
                    <span>Profile</span>
                </a>
            </li>

            <!-- Navigation Section -->
            <li>
                <a href="{{ route('home') }}" class="flex items-center px-1 pt-1 text-sm font-medium leading-5 text-white hover:bg-blue-600 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-home mr-3"></i>
                    <span>Home Feed</span>
                </a>
            </li>
            <li>
                <a href="{{ route('messages') }}" class="flex items-center px-1 pt-1 text-sm font-medium leading-5 text-white hover:bg-blue-600 rounded-lg transition duration-150 ease-in-out">
                    <i class="fab fa-facebook-messenger mr-3"></i>
                    <span>Messages</span>
                </a>
            </li>
            <li>
                <a href="{{ route('notifications.index') }}" class="flex items-center px-1 pt-1 text-sm font-medium leading-5 text-white hover:bg-blue-600 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-bell mr-3"></i>
                    <span>Notifications</span>
                </a>
            </li>

            <!-- Content Management Section -->
            <li>
                <a href="{{ route('posts.create') }}" class="flex items-center px-1 pt-1 text-sm font-medium leading-5 text-white hover:bg-blue-600 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-plus mr-3"></i>
                    <span>Create Post</span>
                </a>
            </li>
            <li>
                <a href="{{ route('posts.saved') }}" class="flex items-center px-1 pt-1 text-sm font-medium leading-5 text-white hover:bg-blue-600 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-bookmark mr-3"></i>
                    <span>Saved Posts</span>
                </a>
            </li>

            <!-- Explore Section -->
            <li>
                <a href="{{ route('explore') }}" class="flex items-center px-1 pt-1 text-sm font-medium leading-5 text-white hover:bg-blue-600 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-compass mr-3"></i>
                    <span>Explore</span>
                </a>
            </li>
            <li>
                <a href="{{ route('trending') }}" class="flex items-center px-1 pt-1 text-sm font-medium leading-5 text-white hover:bg-blue-600 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-chart-line mr-3"></i>
                    <span>Trending</span>
                </a>
            </li>

            <!-- Help and Support Section -->
            <li>
                <a href="{{ route('help') }}" class="flex items-center px-1 pt-1 text-sm font-medium leading-5 text-white hover:bg-blue-600 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-question-circle mr-3"></i>
                    <span>Help Center</span>
                </a>
            </li>
            <li>
                <a href="{{ route('feedback') }}" class="flex items-center px-1 pt-1 text-sm font-medium leading-5 text-white hover:bg-blue-600 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-comment-alt mr-3"></i>
                    <span>Feedback</span>
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
