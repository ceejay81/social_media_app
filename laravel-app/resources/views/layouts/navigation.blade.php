<nav x-data="{ open: false }" class="bg-[#1877F2] border-b border-gray-100 fixed top-0 left-0 right-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/logo (2).jpg') }}" alt="Logo" class="block h-9 w-auto">
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="ml-4">
                    <input type="text" placeholder="Search FakeBook" class="bg-white rounded-full py-2 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-white">
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-white hover:bg-blue-600 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-home mr-1"></i> Home
                </a>
                <a href="{{ route('friends.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-white hover:bg-blue-600 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-user-friends mr-1"></i> Friends
                </a>
                <a href="#" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-white hover:bg-blue-600 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-tv mr-1"></i> Watch
                </a>
                <a href="#" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-white hover:bg-blue-600 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-store mr-1"></i> Marketplace
                </a>
                <a href="#" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-white hover:bg-blue-600 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-users mr-1"></i> Groups
                </a>
            </div>

            <!-- Right Side Icons -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <button class="bg-gray-200 p-2 rounded-full text-gray-600 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-white mr-2">
                    <i class="fas fa-plus"></i>
                </button>
                <button class="bg-gray-200 p-2 rounded-full text-gray-600 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-white mr-2">
                    <i class="fab fa-facebook-messenger"></i>
                </button>
                <button class="bg-gray-200 p-2 rounded-full text-gray-600 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-white mr-2">
                    <i class="fas fa-bell"></i>
                </button>

                <!-- Settings Dropdown -->
                <div class="ml-3 relative" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
                    <div @click="open = ! open">
                        <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                            <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_picture_url ? asset('storage/' . Auth::user()->profile_picture_url) : asset('images/default-avatar.jpg') }}" alt="{{ Auth::user()->name }}" />
                        </button>
                    </div>

                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5"
                         style="display: none;"
                         @click="open = false">
                        <a href="{{ route('profile.edit', ['user' => Auth::id()]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); this.closest('form').submit();"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Log Out
                            </a>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-blue-600 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-white hover:bg-blue-600 transition duration-150 ease-in-out">Dashboard</a>
            <a href="{{ route('friends.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-white hover:bg-blue-600 transition duration-150 ease-in-out">Friends</a>
            <a href="#" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-white hover:bg-blue-600 transition duration-150 ease-in-out">Watch</a>
            <a href="#" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-white hover:bg-blue-600 transition duration-150 ease-in-out">Marketplace</a>
            <a href="#" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-white hover:bg-blue-600 transition duration-150 ease-in-out">Groups</a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-blue-400">
            <div class="flex items-center px-4">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full" src="{{ Auth::user()->profile_picture_url ? asset('storage/' . Auth::user()->profile_picture_url) : asset('images/default-avatar.jpg') }}" alt="{{ Auth::user()->name }}" />
                </div>
                <div class="ml-3">
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-blue-200">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit', ['user' => Auth::id()]) }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-white hover:bg-blue-600 transition duration-150 ease-in-out">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-white hover:bg-blue-600 transition duration-150 ease-in-out">
                        Log Out
                    </a>
                </form>
            </div>
        </div>
    </div>
</nav>
