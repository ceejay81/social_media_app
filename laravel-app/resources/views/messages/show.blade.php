@extends('layouts.app')

@section('content')
<div class="h-screen bg-gray-100">
    <div class="flex h-[calc(100vh-4rem)]">
        <!-- Left Sidebar - Conversations List -->
        <div class="w-80 bg-white border-r flex flex-col">
            <!-- Search Bar -->
            <div class="p-4 border-b">
                <div class="relative">
                    <input type="text" 
                           placeholder="Search messages" 
                           class="w-full pl-10 pr-4 py-2 rounded-full bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search absolute left-4 top-3 text-gray-400"></i>
                </div>
            </div>
            
            <!-- Conversations List -->
            <div class="flex-1 overflow-y-auto">
                @include('messages.conversation_list', ['conversations' => $conversations])
            </div>
        </div>

        <!-- Main Chat Area -->
        <div class="flex-1 flex flex-col bg-white">
            <!-- Chat Header -->
            <div class="flex items-center justify-between px-6 py-3 border-b bg-white">
                <div class="flex items-center space-x-4">
                    <img src="{{ $otherUser->profile_picture_url ? asset('storage/' . $otherUser->profile_picture_url) : asset('images/default-avatar.jpg') }}" 
                         class="w-10 h-10 rounded-full object-cover">
                    <div>
                        <h2 class="font-semibold">{{ $otherUser->name }}</h2>
                        <p class="text-sm text-gray-500">
                            @if($otherUser->last_active_at)
                                {{ $otherUser->last_active_at->diffForHumans() }}
                            @endif
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="p-2 hover:bg-gray-100 rounded-full">
                        <i class="fas fa-phone"></i>
                    </button>
                    <button class="p-2 hover:bg-gray-100 rounded-full">
                        <i class="fas fa-video"></i>
                    </button>
                    <button class="p-2 hover:bg-gray-100 rounded-full">
                        <i class="fas fa-info-circle"></i>
                    </button>
                </div>
            </div>

            <!-- Messages Area -->
            <div id="messages-container" class="flex-1 overflow-y-auto p-4 bg-gray-50">
                <div class="max-w-3xl mx-auto space-y-4">
                    @foreach($messages as $message)
                        @include('messages.message', ['message' => $message])
                    @endforeach
                </div>
            </div>

            <!-- Typing Indicator -->
            <div id="typing-indicator" class="px-6 py-2 text-sm text-gray-500 hidden">
                {{ $otherUser->name }} is typing...
            </div>

            <!-- Message Input Area -->
            <div class="p-4 border-t bg-white">
                <form id="message-form" class="space-y-3">
                    @csrf
                    <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                    
                    <!-- Message Tools -->
                    <div class="flex items-center space-x-3 px-3">
                        <button type="button" class="text-gray-500 hover:text-gray-700 transition-colors">
                            <i class="fas fa-smile text-xl"></i>
                        </button>
                        <label class="text-gray-500 hover:text-gray-700 cursor-pointer transition-colors">
                            <i class="fas fa-image text-xl"></i>
                            <input type="file" name="image" id="image-upload" class="hidden" accept="image/*">
                        </label>
                        <button type="button" class="text-gray-500 hover:text-gray-700 transition-colors">
                            <i class="fas fa-paperclip text-xl"></i>
                        </button>
                    </div>

                    <!-- Input Container -->
                    <div class="flex items-end space-x-2">
                        <div class="flex-1 bg-gray-50 rounded-2xl">
                            <!-- Image Preview -->
                            <div id="image-preview" class="hidden p-3 border-b">
                                <div class="relative inline-block group">
                                    <img src="" alt="Preview" class="max-h-32 rounded-lg">
                                    <button type="button" id="remove-image" 
                                            class="absolute top-1 right-1 bg-gray-900/70 text-white p-1.5 rounded-full 
                                                   opacity-0 group-hover:opacity-100 transition-opacity">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Text Input -->
                            <div class="p-3">
                                <textarea name="content" 
                                        rows="1" 
                                        class="w-full bg-transparent border-0 focus:ring-0 resize-none max-h-32"
                                        placeholder="Type a message..."
                                        style="min-height: 24px"></textarea>
                            </div>
                        </div>
                        
                        <button type="submit" 
                                class="p-3 bg-blue-500 text-white rounded-full hover:bg-blue-600 
                                       disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const messagesContainer = document.getElementById('messages-container');
    const messageForm = document.getElementById('message-form');
    const typingIndicator = document.getElementById('typing-indicator');
    const imageUpload = document.getElementById('image-upload');
    const imagePreview = document.getElementById('image-preview');
    const removeImageBtn = document.getElementById('remove-image');
    let typingTimer;

    messageForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(messageForm);
        const submitButton = messageForm.querySelector('button[type="submit"]');
        const loadingIndicator = document.getElementById('image-upload-loading');

        submitButton.disabled = true;
        if (formData.get('image').size > 0) {
            loadingIndicator.classList.remove('hidden');
        }

        try {
            const response = await fetch('{{ route('messages.store') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const message = await response.json();
            addMessageToUI(message);
            messageForm.reset();
            imagePreview.classList.add('hidden');
            imagePreview.querySelector('img').src = '';
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while sending the message. Please try again.');
        } finally {
            submitButton.disabled = false;
            loadingIndicator.classList.add('hidden');
        }
    });

    function addMessageToUI(message) {
        const messageElement = document.createElement('div');
        messageElement.className = `mb-4 ${message.sender_id === {{ Auth::id() }} ? 'text-right' : 'text-left'}`;
        const isCurrentUser = message.sender_id === {{ Auth::id() }};
        const senderName = isCurrentUser ? '{{ Auth::user()->name }}' : message.sender.name;
        
        messageElement.innerHTML = `
            <div class="flex ${isCurrentUser ? 'justify-end' : 'justify-start'} items-start">
                <div>
                    <p class="text-xs text-gray-500 mb-1">${senderName}</p>
                    <div class="inline-block max-w-xs lg:max-w-md ${isCurrentUser ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800'} rounded-lg px-4 py-2 break-words">
                        ${message.content}
                        ${message.image_url ? `<img src="${message.image_url}" alt="Uploaded image" class="mt-2 max-w-full rounded">` : ''}
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Just now</p>
                </div>
            </div>
        `;
        messagesContainer.appendChild(messageElement);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    messageForm.querySelector('textarea[name="content"]').addEventListener('input', () => {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => {
            fetch('{{ route('messages.typing') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ conversation_id: {{ $conversation->id }} }),
            });
        }, 300);
    });

    imageUpload.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 5 * 1024 * 1024) { // 5MB
                alert('File size exceeds 5MB. Please choose a smaller image.');
                imageUpload.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreview.classList.remove('hidden');
                imagePreview.querySelector('img').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    removeImageBtn.addEventListener('click', () => {
        imageUpload.value = '';
        imagePreview.classList.add('hidden');
        imagePreview.querySelector('img').src = '';
    });

    Echo.private('conversation.{{ $conversation->id }}')
        .listen('NewMessageEvent', (e) => {
            addMessageToUI(e.message);
        })
        .listen('UserTypingEvent', (e) => {
            if (e.user.id !== {{ Auth::id() }}) {
                typingIndicator.classList.remove('hidden');
                setTimeout(() => {
                    typingIndicator.classList.add('hidden');
                }, 3000);
            }
        });
</script>
@endsection
