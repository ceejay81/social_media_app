@extends('layouts.app')

@section('content')
<div class="flex-1 p-6">
    <div class="container mx-auto">
        <div class="flex items-center mb-6">
            <!-- Profile Picture -->
            <img src="{{ asset($user->profile_picture_url) }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full">
            <div class="ml-4">
                <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
                <p class="text-gray-600">{{ $user->email }}</p>
            </div>
        </div>

        @if (Auth::id() === $user->id)
            <a href="{{ route('profile.edit', $user) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">Edit Profile</a>
        @endif
    </div>
</div>
@endsection
