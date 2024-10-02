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
                <div class="ml-4 relative">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                        <input type="text" id="search-input" placeholder="Search FakeBook" class="bg-white rounded-full py-2 pl-10 pr-4 text-sm focus:outline-none focus:ring-2 focus:ring-white" aria-label="Search FakeBook">
                    </div>
                    <div id="search-results" class="absolute z-10 bg-white rounded-md shadow-lg mt-2 w-96 hidden" role="listbox"></div>
                    <div id="search-loading" class="absolute z-10 bg-white rounded-md shadow-lg mt-2 w-96 hidden p-4 text-center">
                        <svg class="animate-spin h-5 w-5 text-blue-500 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
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

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const searchResults = document.getElementById('search-results');
    const searchLoading = document.getElementById('search-loading');
    let currentFocus = -1;

    if (searchInput) {
        searchInput.addEventListener('input', debounce(function() {
            const query = this.value.trim();
            if (query.length > 0) {
                searchLoading.classList.remove('hidden');
                searchResults.classList.add('hidden');
                axios.get(`/search?query=${encodeURIComponent(query)}`)
                    .then(response => {
                        displaySearchResults(response.data);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    })
                    .finally(() => {
                        searchLoading.classList.add('hidden');
                    });
            } else {
                searchResults.innerHTML = '';
                searchResults.classList.add('hidden');
            }
        }, 300));
    }

    function displaySearchResults(results) {
        searchResults.innerHTML = '';
        if (results.length > 0) {
            const ul = document.createElement('ul');
            ul.className = 'py-2';
            results.forEach((user, index) => {
                const li = document.createElement('li');
                li.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer';
                li.innerHTML = `
                    <a href="/profile/${user.id}" class="flex items-center">
                        <img src="${user.profile_picture_url ? '/storage/' + user.profile_picture_url : '/images/default-avatar.jpg'}" 
                            alt="${user.name}" 
                            class="w-10 h-10 rounded-full mr-3 object-cover">
                        <div>
                            <span class="font-semibold">${user.name}</span>
                            ${user.mutual_friends_count ? `<p class="text-xs text-gray-500">${user.mutual_friends_count} mutual friends</p>` : ''}
                        </div>
                    </a>
                `;
                li.addEventListener('click', () => {
                    window.location.href = `/profile/${user.id}`;
                });
                ul.appendChild(li);
            });
            searchResults.appendChild(ul);
            searchResults.classList.remove('hidden');
        } else {
            searchResults.innerHTML = '<p class="px-4 py-2 text-gray-500">No results found</p>';
            searchResults.classList.remove('hidden');
        }
    }

    searchInput.addEventListener('keydown', function(e) {
        const items = searchResults.getElementsByTagName('li');
        if (e.keyCode === 40) { // Arrow down
            currentFocus++;
            addActive(items);
        } else if (e.keyCode === 38) { // Arrow up
            currentFocus--;
            addActive(items);
        } else if (e.keyCode === 13) { // Enter
            e.preventDefault();
            if (currentFocus > -1) {
                if (items) items[currentFocus].click();
            }
        }
    });

    function addActive(items) {
        if (!items) return false;
        removeActive(items);
        if (currentFocus >= items.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (items.length - 1);
        items[currentFocus].classList.add('bg-gray-100');
    }

    function removeActive(items) {
        for (let i = 0; i < items.length; i++) {
            items[i].classList.remove('bg-gray-100');
        }
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Hide search results when clicking outside
    document.addEventListener('click', function(event) {
        if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
            searchResults.classList.add('hidden');
        }
    });

    // Keyboard shortcut for focusing search input
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'k') {
            e.preventDefault();
            searchInput.focus();
        }
    });
});
</script>