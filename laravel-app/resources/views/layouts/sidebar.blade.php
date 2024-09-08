<!-- resources/views/layouts/sidebar.blade.php -->
<aside class="w-64 bg-white border-r border-gray-200 overflow-y-auto">
    <nav class="p-4">
        <ul class="space-y-2">
            <!-- Profile Section -->
            <li>
                @php
                    $userId = Auth::id(); // Use the authenticated user's ID
                @endphp
                <a href="{{ route('profile.show', ['user' => $userId]) }}" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-md">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>Profile</span>
                </a>
            </li>

            <!-- Navigation Section -->
            <li>
                <a href="{{ route('home') }}" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-md">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2.293-2.293a1 1 0 011.414 0L12 11.586l5.293-5.293a1 1 0 011.414 0L21 12"></path>
                    </svg>
                    <span>Home Feed</span>
                </a>
            </li>
            <li>
                <a href="{{ route('messages') }}" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-md">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4.5 4.5 0 000 9h18a4.5 4.5 0 000-9H3zm0-6h18a4.5 4.5 0 010 9H3a4.5 4.5 0 010-9z"></path>
                    </svg>
                    <span>Messages</span>
                </a>
            </li>
            <li>
                <a href="{{ route('notifications') }}" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-md">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M7.5 12H8a1.5 1.5 0 00.5-1V5.5A1.5 1.5 0 007.5 4h-2a1.5 1.5 0 00-1.5 1.5V11a1.5 1.5 0 001.5 1.5z"></path>
                    </svg>
                    <span>Notifications</span>
                </a>
            </li>

            <!-- Content Management Section -->
            <li>
                <a href="{{ route('posts.create') }}" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-md">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5"></path>
                    </svg>
                    <span>Create Post</span>
                </a>
            </li>
            <li>
                <a href="{{ route('posts.saved') }}" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-md">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                    <span>Saved Posts</span>
                </a>
            </li>

            <!-- Explore Section -->
            <li>
                <a href="{{ route('explore') }}" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-md">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 6h8M8 10h8M8 14h8M8 18h8"></path>
                    </svg>
                    <span>Explore</span>
                </a>
            </li>
            <li>
                <a href="{{ route('trending') }}" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-md">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4.5a2.5 2.5 0 015 0v15a2.5 2.5 0 01-5 0V4.5zM21 4.5a2.5 2.5 0 00-5 0v15a2.5 2.5 0 005 0V4.5z"></path>
                    </svg>
                    <span>Trending</span>
                </a>
            </li>

            <!-- Help and Support Section -->
            <li>
                <a href="{{ route('help') }}" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-md">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7.5a4.5 4.5 0 019 0v9a4.5 4.5 0 01-9 0V7.5zM12 15l3 3 3-3"></path>
                    </svg>
                    <span>Help Center</span>
                </a>
            </li>
            <li>
                <a href="{{ route('feedback') }}" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-md">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15h0a1.5 1.5 0 00-1.5-1.5H7a1.5 1.5 0 00-1.5 1.5v4.5a1.5 1.5 0 001.5 1.5h3.5a1.5 1.5 0 001.5-1.5v-4.5zM3 12a1.5 1.5 0 011.5-1.5h15a1.5 1.5 0 011.5 1.5v6a1.5 1.5 0 01-1.5 1.5H4.5A1.5 1.5 0 013 18v-6z"></path>
                    </svg>
                    <span>Feedback</span>
                </a>
            </li>

            <!-- Logout (at the bottom) -->
            <li class="mt-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-md">
                        <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</aside>
