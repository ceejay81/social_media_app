<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $this->authorize('create', Comment::class);

        $validatedData = $request->validate([
            'content' => 'required|max:1000',
        ]);

        try {
            $comment = $post->comments()->create([
                'content' => $validatedData['content'],
                'user_id' => auth()->id(),
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'comment' => $comment->load('user'),
                ]);
            }

            return redirect()->back()->with('success', 'Comment added successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating comment',
                ], 500);
            }

            return redirect()->back()->with('error', 'Error creating comment');
        }
    }
}
