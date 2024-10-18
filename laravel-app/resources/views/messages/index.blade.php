<!-- resources/views/messages/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Messages</h1>
    <div class="flex flex-col md:flex-row gap-8">
        <div class="w-full md:w-1/3 bg-white rounded-lg shadow">
            <div class="p-4">
                <h2 class="text-xl font-semibold mb-4">Conversations</h2>
                @include('messages.conversation_list', ['conversations' => $conversations])
            </div>
        </div>
        <div class="w-full md:w-2/3 bg-white rounded-lg shadow">
            <div class="p-6">
                <h2 class="text-2xl font-semibold mb-6">New Message</h2>
                <form action="{{ route('messages.create') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="recipient" class="block text-sm font-medium text-gray-700 mb-1">To:</label>
                        <select name="recipient" id="recipient" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            @foreach($friends as $friend)
                                <option value="{{ $friend->id }}">{{ $friend->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message from {{ Auth::user()->name }}:</label>
                        <textarea name="message" id="message" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
