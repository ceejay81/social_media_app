@extends('layouts.app')

@section('content')
<div class="flex-1 p-6">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-6">Edit Profile</h1>

        <form method="POST" action="{{ route('profile.update', $user) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Name Field -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Field -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Profile Picture Upload -->
            <div class="mb-4">
                <label for="profile_picture" class="block text-gray-700">Profile Picture</label>
                <input type="file" id="profile_picture" name="profile_picture" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                @error('profile_picture')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update Profile</button>
        </form>
    </div>
</div>
@endsection
