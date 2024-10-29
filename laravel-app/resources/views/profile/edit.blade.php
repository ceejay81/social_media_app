@extends('layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen py-8">
    <div class="container mx-auto max-w-3xl">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <h1 class="text-3xl font-bold mb-6 text-gray-800">Edit Profile</h1>

                <form method="POST" action="{{ route('profile.update', $user) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Name Field -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Profile Picture Upload -->
                    <div class="mb-6">
                        <label for="profile_picture" class="block text-sm font-medium text-gray-700 mb-2">Profile Picture</label>
                        <div class="flex items-center space-x-4">
                            <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-200">
                                <img id="profile_picture_preview" src="{{ $user->profile_picture_url ? asset('storage/' . $user->profile_picture_url) : asset('images/default-avatar.jpg') }}" alt="Profile Picture" class="w-full h-full object-cover">
                            </div>
                            <input type="file" id="profile_picture" name="profile_picture" class="hidden" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp,image/svg+xml" onchange="previewImage(this, 'profile_picture_preview')">
                            <label for="profile_picture" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300 ease-in-out cursor-pointer">Choose File</label>
                        </div>
                        @error('profile_picture')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Background Picture Upload -->
                    <div class="mb-6">
                        <label for="background_picture" class="block text-sm font-medium text-gray-700 mb-2">Background Picture</label>
                        <div class="flex items-center space-x-4">
                            <div class="w-full h-32 rounded-lg overflow-hidden bg-gray-200">
                                <img id="background_picture_preview" src="{{ $user->background_picture_url ? asset('storage/' . $user->background_picture_url) : asset('images/default-cover.jpg') }}" alt="Background Picture" class="w-full h-full object-cover">
                            </div>
                            <input type="file" id="background_picture" name="background_picture" class="hidden" accept="image/*" onchange="previewImage(this, 'background_picture_preview')">
                            <label for="background_picture" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300 ease-in-out cursor-pointer">Choose File</label>
                        </div>
                        @error('background_picture')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bio Field -->
                    <div class="mb-6">
                        <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                        <textarea id="bio" name="bio" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300 ease-in-out">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const file = input.files[0];
        const reader = new FileReader();

        reader.onloadend = function () {
            preview.src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = previewId === 'profile_picture_preview' 
                ? "{{ asset('images/default-avatar.jpg') }}"
                : "{{ asset('images/default-cover.jpg') }}";
        }
    }
</script>
@endpush

@endsection
