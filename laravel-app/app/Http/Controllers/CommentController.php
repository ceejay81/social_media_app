<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        try {
            $request->validate([
                'content' => 'required|string|max:1000',
            ]);

            $comment = $post->comments()->create([
                'user_id' => auth()->id(),
                'content' => $request->content,
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
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors(),
            ], 422);
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
            'comment' => $comment
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
}
