<!-- resources/views/notifications/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Notifications</h1>
        <div id="notifications-list" role="list">
            @forelse($notifications as $notification)
                <div class="notification bg-white p-4 mb-4 rounded shadow {{ $notification->read_at ? 'opacity-50' : '' }}" 
                     data-id="{{ $notification->id }}" role="listitem">
                    <p class="mb-2">
                        @if($notification->type === 'new_post')
                            @if(isset($notification->data['user_id']))
                                <a href="{{ route('profile.show', $notification->data['user_id']) }}" class="font-semibold hover:underline">{{ $notification->data['user_name'] ?? 'You' }}</a> have created a new post!
                            @else
                                You have created a new post!
                            @endif
                        @elseif($notification->type === 'new_like' || $notification->type === 'new_comment')
                            @if(isset($notification->data['user_id']) && isset($notification->data['user_name']))
                                <a href="{{ route('profile.show', $notification->data['user_id']) }}" class="font-semibold hover:underline">{{ $notification->data['user_name'] }}</a> 
                                {{ $notification->data['action'] ?? 'interacted with your post' }}
                            @else
                                {{ $notification->data['message'] ?? 'New activity on your post' }}
                            @endif
                        @else
                            {{ $notification->data['message'] ?? 'You have a new notification' }}
                        @endif
                    </p>
                    <p class="text-sm text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <p role="status">No notifications</p>
            @endforelse
        </div>
    </div>
@endsection
