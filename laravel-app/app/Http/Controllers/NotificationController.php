<?php

// In app/Http/Controllers/NotificationController.php
namespace App\Http\Controllers;

use App\Models\Notification;
use App\Events\NewNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()
            ->whereIn('type', ['new_post', 'new_like', 'new_comment', 'friend_request'])
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

        event(new NewNotification($notification));

        return $notification;
    }
}
