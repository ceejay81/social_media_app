<?php

// In app/Http/Controllers/NotificationController.php
namespace App\Http\Controllers;

use App\Models\Notification;
use App\Events\NewNotification;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()
            ->whereIn('type', ['new_post', 'new_like', 'new_comment', 'friend_request', 'new_reaction'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->read_at = now();
        $notification->save();
        return response()->json(['success' => true]);
    }

    public function store($userId, $type, $data)
    {
        // Ensure user_id is included in the data
        $data['user_id'] = $userId;

        $notification = Notification::create([
            'type' => $type,
            'notifiable_type' => 'App\Models\User',
            'notifiable_id' => $userId,
            'data' => $data,
        ]);

        \Log::info('Notification stored', ['notification' => $notification]);

        broadcast(new NewNotification($notification))->toOthers();

        return $notification;
    }

    public function apiStore(Request $request)
    {
        $userId = $request->input('userId');
        $type = $request->input('type');
        $data = $request->input('data');

        return $this->store($userId, $type, $data);
    }

    public function createLikeNotification($postId, $likerId)
    {
        $post = Post::findOrFail($postId);
        $liker = User::findOrFail($likerId);

        if ($post->user_id !== $likerId) {
            $this->store(
                $post->user_id,
                'new_like',
                [
                    'user_id' => $likerId,
                    'user_name' => $liker->name,
                    'post_id' => $postId,
                    'action' => 'liked your post'
                ]
            );

            \Log::info('Like notification created', [
                'post_id' => $postId,
                'liker_id' => $likerId,
                'post_owner_id' => $post->user_id
            ]);
        }
    }
}
