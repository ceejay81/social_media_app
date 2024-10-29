<div class="flex {{ $message->is_sender ? 'justify-end' : 'justify-start' }} group">
    <div class="max-w-[70%]">
        <div class="flex items-end gap-2 {{ $message->is_sender ? 'flex-row-reverse' : 'flex-row' }}">
            @if(!$message->is_sender)
                <div class="flex-shrink-0 mb-1">
                    <img src="{{ $message->sender->profile_picture_url ? asset('storage/' . $message->sender->profile_picture_url) : asset('images/default-avatar.jpg') }}" 
                         alt="{{ $message->sender->name }}" 
                         class="w-8 h-8 rounded-full object-cover">
                </div>
            @endif
            
            <div class="flex flex-col {{ $message->is_sender ? 'items-end' : 'items-start' }}">
                <div class="{{ $message->is_sender ? 'bg-blue-500 text-white' : 'bg-white' }} 
                            rounded-2xl px-4 py-2 shadow-sm relative group">
                    @if($message->content)
                        <p class="whitespace-pre-wrap">{{ $message->content }}</p>
                    @endif
                    
                    @if($message->image_url)
                        <img src="{{ $message->image_url }}" 
                             alt="Uploaded image" 
                             class="mt-2 max-w-full rounded-lg cursor-zoom-in hover:opacity-90 transition-opacity"
                             onclick="openImageViewer(this.src)">
                    @endif

                    <!-- Message Status -->
                    <div class="absolute -bottom-5 {{ $message->is_sender ? 'right-0' : 'left-0' }} 
                                flex items-center space-x-1 text-xs text-gray-500">
                        <span>{{ $message->created_at->format('g:i A') }}</span>
                        @if($message->is_sender)
                            @if($message->read)
                                <span class="text-blue-500" title="Read {{ $message->read_at->diffForHumans() }}">
                                    <i class="fas fa-check-double"></i>
                                </span>
                            @elseif($message->delivered)
                                <span class="text-gray-400">
                                    <i class="fas fa-check-double"></i>
                                </span>
                            @else
                                <span class="text-gray-400">
                                    <i class="fas fa-check"></i>
                                </span>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
