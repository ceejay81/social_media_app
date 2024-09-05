<!-- resources/views/posts/create.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold">Create Post</h1>
        <!-- Form for creating a post -->
        <form method="POST" action="{{ route('posts.store') }}">
            @csrf
            <!-- Post form fields -->
            <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">Submit</button>
        </form>
    </div>
@endsection
