<ul class="space-y-2">
    @foreach($conversations as $conversation)
        @php
            $otherUser = $conversation->user_id === Auth::id() ? $conversation->otherUser : $conversation->user;
        @endphp
        @if($otherUser)
            <li>
                <a href="{{ route('messages.show', $conversation->id) }}" class="flex items-center p-3 hover:bg-gray-100 rounded-lg transition duration-300 {{ Request::route('conversationId') == $conversation->id ? 'bg-blue-100' : '' }}">
                    <img src="{{ $otherUser->profile_picture_url ? asset('storage/' . $otherUser->profile_picture_url) : asset('images/default-avatar.jpg') }}" 
                         alt="{{ $otherUser->name }}" 
                         class="w-12 h-12 rounded-full mr-4 object-cover">
                    <div class="flex-grow">
                        <h3 class="font-semibold text-gray-800">{{ $otherUser->name }}</h3>
                        <p class="text-sm text-gray-600 truncate">
                            @if($conversation->lastMessage)
                                @if($conversation->lastMessage->sender_id == Auth::id())
                                    <span class="font-semibold">You: </span>
                                @endif
                                {{ Str::limit($conversation->lastMessage->content, 30) }}
                            @else
                                No messages yet
                            @endif
                        </p>
                    </div>
                    @if($conversation->unreadCount)
                        <span class="bg-blue-500 text-white text-xs font-bold rounded-full px-2 py-1">{{ $conversation->unreadCount }}</span>
                    @endif
                </a>
            </li>
        @endif
    @endforeach
</ul>
