<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-semibold mb-6">Welcome, {{ Auth::user()->name }}!</h3>

                    <!-- Create Post Section -->
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <h4 class="text-xl font-semibold mb-4">Create a Post</h4>
                        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="flex items-center mb-4">
                                <img src="{{ Auth::user()->profile_picture_url ? asset('storage/' . Auth::user()->profile_picture_url) : asset('images/default-avatar.jpg') }}" 
                                     alt="{{ Auth::user()->name }}" 
                                     class="w-10 h-10 rounded-full mr-4 object-cover">
                                <textarea name="content" rows="3" class="w-full p-2 border rounded-md" placeholder="What's on your mind?"></textarea>
                            </div>
                            <div class="flex justify-between items-center">
                                <input type="file" name="image" class="text-sm" accept="image/*">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Post</button>
                            </div>
                        </form>
                    </div>

                    <!-- Recent Posts -->
                    <div class="mb-6">
                        <h4 class="text-xl font-semibold mb-4">Your Recent Posts</h4>
                        <div class="space-y-6">
                            @forelse(Auth::user()->posts()->latest()->take(3)->get() as $post)
                                <div class="bg-white rounded-lg shadow p-6">
                                    <div class="flex items-center mb-4">
                                        <img src="{{ Auth::user()->profile_picture_url ? asset('storage/' . Auth::user()->profile_picture_url) : asset('images/default-avatar.jpg') }}" 
                                             alt="{{ Auth::user()->name }}" 
                                             class="w-10 h-10 rounded-full mr-4 object-cover">
                                        <div>
                                            <h3 class="font-semibold">{{ Auth::user()->name }}</h3>
                                            <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <p class="text-gray-800 mb-4">{{ $post->content }}</p>
                                    @if($post->image)
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" class="w-full rounded-lg mb-4">
                                    @endif
                                    <div class="flex items-center space-x-4 text-gray-500">
                                        <button class="flex items-center space-x-2 hover:text-blue-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                                            <span>Like</span>
                                        </button>
                                        <button class="flex items-center space-x-2 hover:text-blue-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                            <span>Comment</span>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 italic">No recent posts</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="text-xl font-semibold mb-4">Quick Links</h4>
                        <div class="flex space-x-4">
                            <a href="{{ route('profile.show', Auth::user()) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">View Profile</a>
                            <a href="{{ route('posts.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Create Post</a>
                            <a href="{{ route('posts.saved') }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">Saved Posts</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
