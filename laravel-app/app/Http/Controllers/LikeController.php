<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Events\NewLike;

class LikeController extends Controller
{
    public function toggleLike(Post $post)
    {
        $user = auth()->user();

        if ($post->likes()->where('user_id', $user->id)->exists()) {
            $post->likes()->where('user_id', $user->id)->delete();
            $action = 'unliked';
        } else {
            $post->likes()->create(['user_id' => $user->id]);
            $action = 'liked';
        }

        $likesCount = $post->likes()->count();

        broadcast(new NewLike($post->id, $likesCount))->toOthers();

        return response()->json([
            'success' => true,
            'action' => $action,
            'likesCount' => $likesCount
        ]);
    }

    public function toggleLikePost(Post $post)
    {
        try {
            $user = auth()->user();
            $liked = $user->likes()->toggle($post->id);
            
            if (in_array($post->id, $liked['attached'])) {
                $notificationController = new NotificationController();
                $notificationController->store(
                    $post->user_id,
                    'new_like',
                    [
                        'message' => $user->name . ' liked your post.',
                        'post_id' => $post->id,
                        'user_id' => $user->id,
                        'user_name' => $user->name,
                        'action' => 'liked your post'
                    ]
                );
            }
            
            return response()->json([
                'success' => true,
                'liked' => in_array($post->id, $liked['attached']),
                'likesCount' => $post->likes()->count(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request.',
            ], 500);
        }
    }
}
