@extends('layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen">
    <!-- Cover Photo Section -->
    <div class="relative">
        <div class="h-96 bg-cover bg-center" style="background-image: url('{{ $user->background_picture_url ? asset('storage/' . $user->background_picture_url) : asset('images/default-cover.jpg') }}');">
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-black/60 to-transparent"></div>
        <div class="container mx-auto px-4">
            <div class="relative">
                <img src="{{ $user->profile_picture_url ? asset('storage/' . $user->profile_picture_url) : asset('images/default-avatar.jpg') }}" 
                     alt="{{ $user->name }}" 
                     class="absolute -bottom-8 left-4 w-40 h-40 rounded-full border-4 border-white shadow-lg object-cover">
                @if (Auth::id() === $user->id)
                    <a href="{{ route('profile.edit', $user) }}" class="absolute bottom-4 right-4 bg-white text-blue-600 px-4 py-2 rounded-md hover:bg-blue-100 transition">Edit Profile</a>
                @endif
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 pt-16 pb-6">
        <div class="flex flex-col md:flex-row">
            <!-- Left Sidebar -->
            <div class="w-full md:w-1/3 md:pr-4">
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h1 class="text-3xl font-bold mb-2">{{ $user->name }}</h1>
                    <p class="text-gray-600 mb-4">{{ $user->bio ?? 'No bio available' }}</p>
                    @if (Auth::id() === $user->id)
                        <a href="{{ route('profile.edit', $user) }}" class="block w-full text-center bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">Edit Profile</a>
                    @else
                        <button class="block w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">Add Friend</button>
                    @endif
                </div>

                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Intro</h2>
                    <ul class="space-y-2">
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                            Lives in <span class="font-semibold">{{ $user->location ?? 'Not specified' }}</span>
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path><path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"></path></svg>
                            Works at <span class="font-semibold">{{ $user->workplace ?? 'Not specified' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="w-full md:w-2/3 mt-6 md:mt-0">
                @if (Auth::id() === $user->id)
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <h2 class="text-xl font-semibold mb-4">Create a Post</h2>
                        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <textarea name="content" rows="3" class="w-full p-2 border rounded-md" placeholder="What's on your mind?"></textarea>
                            <div class="mt-2 flex justify-between items-center">
                                <input type="file" name="image" accept="image/*">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Post</button>
                            </div>
                        </form>
                    </div>
                @endif

                <div class="space-y-6">
                    @forelse($user->posts as $post)
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center mb-4">
                                <img src="{{ $user->profile_picture_url ? asset('storage/' . $user->profile_picture_url) : asset('images/default-avatar.jpg') }}" 
                                     alt="{{ $user->name }}" 
                                     class="w-10 h-10 rounded-full mr-4 object-cover">
                                <div>
                                    <h3 class="font-semibold">{{ $user->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <p class="text-gray-800 mb-4">{{ $post->content }}</p>
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" class="w-full rounded-lg mb-4">
                            @endif
                            <!-- Add like and comment functionality here if needed -->
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
                        <div class="bg-white rounded-lg shadow p-6">
                            <p class="text-gray-500 italic">No posts available</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection