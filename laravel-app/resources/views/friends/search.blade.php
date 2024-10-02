@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold mb-4">Search Results for "{{ $query }}"</h2>

    <div class="mb-4">
        <a href="{{ route('friends.index') }}" class="text-blue-500 hover:underline">
            <i class="fas fa-arrow-left mr-2"></i>Back to Friends
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        @if($searchResults->count() > 0)
            <div class="space-y-4">
                @foreach($searchResults as $friend)
                    <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <img src="{{ $friend->profile_picture_url ? asset('storage/' . $friend->profile_picture_url) : asset('images/default-avatar.jpg') }}" 
                                alt="{{ $friend->name }}" 
                                class="w-12 h-12 rounded-full mr-4 object-cover">
                            <div>
                                <h3 class="font-semibold">{{ $friend->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $friend->friends_count ?? 0 }} friends</p>
                                @if($friend->bio)
                                    <p class="text-sm text-gray-600">{{ Str::limit($friend->bio, 50) }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('profile.show', $friend->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                <i class="fas fa-user mr-2"></i>View Profile
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $searchResults->appends(['query' => $query])->links() }}
            </div>
        @else
            <p class="text-gray-500 italic">No friends found matching "{{ $query }}".</p>
        @endif
    </div>
</div>
@endsection