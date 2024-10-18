@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-4">
        <div class="w-full md:w-1/3 bg-white rounded-lg shadow">
            <div class="p-4">
                <h2 class="text-xl font-semibold mb-4">Conversations</h2>
                @include('messages.conversation_list', ['conversations' => $conversations])
            </div>
        </div>
        <div class="w-full md:w-2/3 bg-white rounded-lg shadow">
            <div class="flex flex-col h-[calc(100vh-12rem)]">
                <div class="p-4 border-b">
                    <h2 class="text-xl font-semibold">{{ $otherUser->name }}</h2>
                </div>
                <div id="messages-container" class="flex-grow overflow-y-auto p-4">
                    @foreach($messages as $message)
                        @include('messages.message', ['message' => $message])
                    @endforeach
                </div>
                <div id="typing-indicator" class="text-sm text-gray-500 px-4 py-2 hidden">
                    {{ $otherUser->name }} is typing...
                </div>
                <form id="message-form" class="p-4 border-t" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                    <div class="flex flex-col space-y-2">
                        <div id="image-preview" class="hidden mb-2">
                            <img src="" alt="Preview" class="max-w-xs max-h-32 rounded">
                            <button type="button" id="remove-image" class="text-red-500 text-sm mt-1">Remove image</button>
                        </div>
                        <div class="flex items-center space-x-2">
                            <input type="text" name="content" class="flex-grow border rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Type your message...">
                            <label for="image-upload" class="cursor-pointer text-blue-500 hover:text-blue-600 flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full transition duration-300 ease-in-out hover:bg-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </label>
                            <input id="image-upload" type="file" name="image" class="hidden" accept="image/*">
                            <button type="submit" class="bg-blue-500 text-white rounded-full p-2 hover:bg-blue-600 transition duration-300 ease-in-out">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                            </button>
                        </div>
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
        const response = await fetch('{{ route('messages.store') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
        });
        const message = await response.json();
        addMessageToUI(message);
        messageForm.reset();
        imagePreview.classList.add('hidden');
        imagePreview.querySelector('img').src = '';
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

    messageForm.querySelector('input[name="content"]').addEventListener('input', () => {
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
