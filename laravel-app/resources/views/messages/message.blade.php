<div class="mb-4 {{ $message->is_sender ? 'text-right' : 'text-left' }}">
    @if(!$message->is_sender)
        <p class="text-xs text-gray-500 mb-1">{{ $message->sender->name }}</p>
    @endif
    <div class="inline-block max-w-xs lg:max-w-md {{ $message->is_sender ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800' }} rounded-lg px-4 py-2 break-words">
        @if($message->content)
            <p>{{ $message->content }}</p>
        @endif
        @if($message->image_url)
            <img src="{{ $message->image_url }}" alt="Uploaded image" class="mt-2 max-w-full rounded">
        @endif
    </div>
    <p class="text-xs text-gray-500 mt-1">{{ $message->created_at->diffForHumans() }}</p>
</div>
