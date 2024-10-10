    @extends('layouts.app')

    @section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <div class="bg-gray-100 min-h-screen">
        <div class="container mx-auto px-4 py-8">
            <div class="flex justify-center">
                <!-- Main Content -->
                <div class="w-full lg:w-2/3 px-4">
                    <div class="bg-white rounded-lg shadow mb-6 p-6">
                        <h2 class="text-2xl font-semibold mb-4">Friends</h2>
                        
                        <!-- Friend Search -->
                        <div class="mb-6">
                            <form action="{{ route('friends.search') }}" method="GET" class="flex">
                                <input type="text" name="query" placeholder="Search friends..." class="flex-grow p-2 border rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-lg hover:bg-blue-600">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Friend List -->
                        <div class="space-y-4">
                            @forelse($friends as $friend)
                                <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-center">
                                        <img src="{{ $friend->profile_picture_url ? asset('storage/' . $friend->profile_picture_url) : asset('images/default-avatar.jpg') }}" 
                                            alt="{{ $friend->name }}" 
                                            class="w-12 h-12 rounded-full mr-4 object-cover">
                                        <div>
                                            <h3 class="font-semibold">{{ $friend->name }}</h3>
                                            <p class="text-sm text-gray-500">{{ $friend->mutual_friends_count ?? 0 }} mutual friends</p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('profile.show', $friend->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                            <i class="fas fa-user mr-2"></i>View Profile
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <p class="text-gray-500 italic">You don't have any friends yet.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        @if(method_exists($friends, 'links'))
                            <div class="mt-6">
                                {{ $friends->links() }}
                            </div>
                        @endif
                    </div>

                    <!-- Friend Suggestions -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-xl font-semibold mb-4">People You May Know</h3>
                        <div class="space-y-4">
                            @foreach($suggestions as $suggestion)
                                <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-center">
                                        <img src="{{ $suggestion->profile_picture_url ? asset('storage/' . $suggestion->profile_picture_url) : asset('images/default-avatar.jpg') }}" 
                                            alt="{{ $suggestion->name }}" 
                                            class="w-12 h-12 rounded-full mr-4 object-cover">
                                        <div>
                                            <h4 class="font-semibold">{{ $suggestion->name }}</h4>
                                            <p class="text-sm text-gray-500">{{ $suggestion->mutual_friends_count ?? 0 }} mutual friends</p>
                                        </div>
                                    </div>
                                    @if(in_array($suggestion->id, $pendingRequests))
                                        <button class="cancel-request-btn bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600" data-user-id="{{ $suggestion->id }}">
                                            <i class="fas fa-user-times mr-2"></i>Cancel Request
                                        </button>
                                    @else
                                        <button class="add-friend-btn bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600" data-user-id="{{ $suggestion->id }}">
                                            <i class="fas fa-user-plus mr-2"></i>Add Friend
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="w-1/3 pl-4 hidden lg:block">
                    <div class="bg-white rounded-lg shadow p-4 mb-4">
                        <h3 class="font-semibold mb-2">Friend Requests</h3>
                        <ul class="space-y-2">
                            @forelse($friendRequests as $friendRequest)
                                <li class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <img src="{{ $friendRequest->user->profile_picture_url ? asset('storage/' . $friendRequest->user->profile_picture_url) : asset('images/default-avatar.jpg') }}" 
                                            alt="{{ $friendRequest->user->name }}" 
                                            class="w-10 h-10 rounded-full mr-2 object-cover">
                                        <span class="text-sm">{{ $friendRequest->user->name }}</span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="accept-request-btn bg-green-500 text-white px-2 py-1 rounded text-xs" data-request-id="{{ $friendRequest->id }}">
                                            <i class="fas fa-check mr-1"></i>Accept
                                        </button>
                                        <button class="decline-request-btn bg-red-500 text-white px-2 py-1 rounded text-xs" data-request-id="{{ $friendRequest->id }}">
                                            <i class="fas fa-times mr-1"></i>Decline
                                        </button>
                                    </div>
                                </li>
                            @empty
                                <li class="text-gray-500 italic text-sm">No pending friend requests</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <h3 class="font-semibold mb-2">Birthdays</h3>
                        <ul class="space-y-2">
                            @forelse($birthdays as $birthday)
                                <li class="flex items-center">
                                    <i class="fas fa-gift text-blue-500 mr-2"></i>
                                    <span class="text-sm">{{ $birthday->name }}'s birthday is today!</span>
                                </li>
                            @empty
                                <li class="text-gray-500 italic text-sm">No birthdays today</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
    @section('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add friend request
        document.querySelectorAll('.add-friend-btn').forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.dataset.userId;
                axios.post('{{ route("friends.sendRequest") }}', { friend_id: userId })
                    .then(response => {
                        if (response.data.success) {
                            this.textContent = 'Request Sent';
                            this.classList.remove('bg-blue-500', 'hover:bg-blue-600');
                            this.classList.add('bg-gray-500', 'cursor-not-allowed');
                            this.disabled = true;
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });

        // Cancel friend request
        document.querySelectorAll('.cancel-request-btn').forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.dataset.userId;
                axios.post('{{ route("friends.cancelRequest") }}', { friend_id: userId })
                    .then(response => {
                        if (response.data.success) {
                            this.textContent = 'Add Friend';
                            this.classList.remove('bg-red-500', 'hover:bg-red-600');
                            this.classList.add('bg-blue-500', 'hover:bg-blue-600');
                            this.classList.remove('cancel-request-btn');
                            this.classList.add('add-friend-btn');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });

        // Accept friend request
        document.querySelectorAll('.accept-request-btn').forEach(button => {
            button.addEventListener('click', function() {
                const requestId = this.dataset.requestId;
                axios.post('{{ route("friends.acceptRequest") }}', { request_id: requestId })
                    .then(response => {
                        if (response.data.success) {
                            this.closest('li').remove();
                            updateFriendRequestsCount();
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });

        // Decline friend request
        document.querySelectorAll('.decline-request-btn').forEach(button => {
            button.addEventListener('click', function() {
                const requestId = this.dataset.requestId;
                axios.post('{{ route("friends.declineRequest") }}', { request_id: requestId })
                    .then(response => {
                        if (response.data.success) {
                            this.closest('li').remove();
                            updateFriendRequestsCount();
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });

        function updateFriendRequestsCount() {
            const friendRequestsList = document.querySelector('.friend-requests-list');
            if (friendRequestsList.children.length === 0) {
                friendRequestsList.innerHTML = '<li class="text-gray-500 italic text-sm">No pending friend requests</li>';
            }
        }
    });
    </script>
    @endsection