<!-- resources/views/notifications/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Notifications</h1>
            <button id="mark-all-read" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Mark All as Read
            </button>
        </div>
        <div id="notifications-list" role="list">
            @forelse($notifications as $notification)
                <div class="notification bg-white p-4 mb-4 rounded shadow {{ $notification->read_at ? 'opacity-50' : '' }}" 
                     data-id="{{ $notification->id }}" role="listitem">
                    <div class="flex justify-between items-start">
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
                            @elseif($notification->type === 'friend_request')
                                @if(isset($notification->data['user_id']) && isset($notification->data['user_name']))
                                    <a href="{{ route('profile.show', $notification->data['user_id']) }}" class="font-semibold hover:underline">{{ $notification->data['user_name'] }}</a> sent you a friend request.
                                @else
                                    {{ $notification->data['message'] ?? 'You have a new friend request' }}
                                @endif
                            @elseif($notification->type === 'new_reaction')
                                @if(isset($notification->data['reactor_id']) && isset($notification->data['reactor_name']))
                                    <a href="{{ route('profile.show', $notification->data['reactor_id']) }}" class="font-semibold hover:underline">{{ $notification->data['reactor_name'] }}</a> 
                                    {{ $notification->data['action'] ?? 'reacted to your post' }}
                                    with {{ $notification->data['reaction'] ?? 'a reaction' }}
                                @else
                                    {{ $notification->data['message'] ?? 'Someone reacted to your post' }}
                                @endif
                            @else
                                {{ $notification->data['message'] ?? 'You have a new notification' }}
                            @endif
                        </p>
                        <button class="delete-notification text-red-500 hover:text-red-700">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <p class="text-sm text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <p role="status">No notifications</p>
            @endforelse
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const markAllReadBtn = document.getElementById('mark-all-read');
        const notificationsList = document.getElementById('notifications-list');

        markAllReadBtn.addEventListener('click', function() {
            fetch('{{ route('notifications.markAllAsRead') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelectorAll('.notification').forEach(notification => {
                        notification.classList.add('opacity-50');
                    });
                }
            });
        });

        notificationsList.addEventListener('click', function(e) {
            if (e.target.closest('.delete-notification')) {
                const notification = e.target.closest('.notification');
                const notificationId = notification.dataset.id;

                fetch(`/notifications/${notificationId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        notification.remove();
                    }
                });
            }
        });
    });
    </script>
@endsection
