<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        try {
            $request->validate([
                'content' => 'required|string|max:1000',
                'parent_id' => 'nullable|exists:comments,id',
            ]);

            $comment = $post->comments()->create([
                'user_id' => auth()->id(),
                'content' => $request->content,
                'parent_id' => $request->parent_id,
            ]);

            $user = auth()->user();

            return response()->json([
                'success' => true,
                'comment' => $comment->load('user'),
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'profile_picture_url' => $user->profile_picture_url
                        ? asset('storage/' . $user->profile_picture_url)
                        : asset('images/default-avatar.jpg'),
                ],
                'commentsCount' => $post->comments()->count(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding comment: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $validatedData = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Comment updated successfully',
            'comment' => $comment->load('user')
        ]);
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully'
        ]);
    }

    public function loadMore(Post $post, Request $request)
    {
        $skip = $request->query('skip', 0);
        $comments = $post->comments()
            ->with('user')
            ->skip($skip)
            ->take(10)
            ->get()
            ->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'created_at' => $comment->created_at->diffForHumans(),
                    'user' => [
                        'id' => $comment->user->id,
                        'name' => $comment->user->name,
                        'profile_picture_url' => $comment->user->profile_picture_url,
                    ],
                    'user_id' => $comment->user_id,
                ];
            });

        return response()->json(['comments' => $comments]);
    }
}
