@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Left Sidebar - Conversations List -->
        <div class="w-full md:w-1/3">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-4 border-b">
                    <h2 class="text-xl font-semibold text-gray-800">Messages</h2>
                    <div class="mt-2 relative">
                        <input type="text" 
                               placeholder="Search conversations" 
                               class="w-full pl-10 pr-4 py-2 rounded-full bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <i class="fas fa-search absolute left-4 top-3 text-gray-400"></i>
                    </div>
                </div>
                <div class="overflow-y-auto max-h-[calc(100vh-20rem)]">
                    @include('messages.conversation_list', ['conversations' => $conversations])
                </div>
            </div>
        </div>

        <!-- Right Side - New Message Form -->
        <div class="w-full md:w-2/3">
            <div class="bg-white rounded-lg shadow-lg">
                <div class="p-6 border-b">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">New Message</h2>
                    <form action="{{ route('messages.create') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="recipient" class="block text-sm font-medium text-gray-700 mb-2">To:</label>
                            <select name="recipient" id="recipient" 
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">Select a friend</option>
                                @foreach($friends as $friend)
                                    <option value="{{ $friend->id }}">{{ $friend->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message:</label>
                            <div class="relative">
                                <textarea name="message" id="message" rows="6" 
                                          class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                          placeholder="Type your message here..."></textarea>
                                <div class="absolute bottom-3 right-3 flex space-x-2 text-gray-400">
                                    <button type="button" class="hover:text-gray-600 transition-colors">
                                        <i class="fas fa-smile text-xl"></i>
                                    </button>
                                    <button type="button" class="hover:text-gray-600 transition-colors">
                                        <i class="fas fa-image text-xl"></i>
                                    </button>
                                    <button type="button" class="hover:text-gray-600 transition-colors">
                                        <i class="fas fa-paperclip text-xl"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
