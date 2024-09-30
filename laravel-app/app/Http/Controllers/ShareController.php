<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Share;
use Illuminate\Http\Request;

class ShareController extends Controller
{
    public function share(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'content' => 'nullable|string|max:500',
        ]);

        $share = new Share([
            'user_id' => auth()->id(),
            'post_id' => $post->id,
            'content' => $validatedData['content'] ?? null,
        ]);

        $share->save();

        return response()->json([
            'success' => true,
            'message' => 'Post shared successfully!',
        ]);
    }
}