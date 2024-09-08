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
}