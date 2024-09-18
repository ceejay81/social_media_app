<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Share;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Added for logging

class PostController extends Controller
{
    // Display form for creating a new post
    public function create()
    {
        return view('posts.create');
    }

    // Store a newly created post in the database
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:102400', // 100MB max
        ]);

        $post = new Post();
        $post->content = $request->content;
        $post->user_id = auth()->id();

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $fileExtension = $file->getClientOriginalExtension();
            
            if (in_array($fileExtension, ['jpeg', 'png', 'jpg', 'gif'])) {
                $path = $file->store('post-images', 'public');
                $post->image = $path;
            } elseif (in_array($fileExtension, ['mp4', 'mov', 'avi'])) {
                $path = $file->store('post-videos', 'public');
                $post->video = $path;
                Log::info("Video uploaded successfully: " . $path);
            }
        }

        $post->save();

        return redirect()->route('home')->with('success', 'Post created successfully!');
    }

    // Display the saved posts
    public function saved()
    {
        $user = Auth::user();
        $savedPosts = $user->savedPosts; // Assuming you have a relationship for saved posts in User model

        return view('posts.saved', ['posts' => $savedPosts]);
    }

    // (Optional) Display a specific post, if needed
    public function show($id)
    {
        $post = Post::findOrFail($id);

        return view('posts.show', ['post' => $post]);
    }

    // (Optional) Method to handle saving a post, if applicable
    public function savePost($id)
    {
        $user = Auth::user();
        $post = Post::findOrFail($id);

        // Assuming you have a pivot table to manage saved posts
        $user->savedPosts()->attach($post);

        return redirect()->route('posts.saved')->with('success', 'Post saved successfully!');
    }

    // (Optional) Update a specific post
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        // Authorization check
        if ($post->user_id !== Auth::id()) {
            return redirect()->route('home')->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'content' => 'required|string|max:1000',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:102400', // 100MB max
        ]);

        $post->content = $request->input('content');

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $fileExtension = $file->getClientOriginalExtension();
            
            // Delete old media if exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
                $post->image = null;
            }
            if ($post->video) {
                Storage::disk('public')->delete($post->video);
                $post->video = null;
            }
            
            if (in_array($fileExtension, ['jpeg', 'png', 'jpg', 'gif'])) {
                $path = $file->store('post-images', 'public');
                $post->image = $path;
            } elseif (in_array($fileExtension, ['mp4', 'mov', 'avi'])) {
                $path = $file->store('post-videos', 'public');
                $post->video = $path;
                Log::info("Video uploaded successfully: " . $path);
            }
        }

        $post->save();

        return redirect()->route('posts.show', $post->id)->with('success', 'Post updated successfully!');
    }

    public function addComment(Request $request, Post $post)
    {
        try {
            $request->validate([
                'content' => 'required|string|max:500',
                'parent_id' => 'nullable|exists:comments,id',
            ]);

            $comment = $post->comments()->create([
                'content' => $request->content,
                'user_id' => Auth::id(),
                'parent_id' => $request->parent_id,
            ]);

            return response()->json([
                'success' => true,
                'comment' => $comment,
                'user' => [
                    'name' => Auth::user()->name,
                    'profile_picture_url' => Auth::user()->profile_picture_url
                        ? asset('storage/' . Auth::user()->profile_picture_url)
                        : asset('images/default-avatar.jpg'),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding comment: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function updateComment(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment->update(['content' => $request->content]);

        return response()->json([
            'success' => true,
            'comment' => $comment,
        ]);
    }

    public function deleteComment(Comment $comment)
    {
        try {
            $this->authorize('delete', $comment);
            $comment->delete();
            return response()->json([
                'success' => true,
                'message' => 'Comment deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting comment: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function react(Request $request, Post $post)
    {
        $reaction = $request->input('reaction');
        $user = Auth::user();

        $existingReaction = $post->reactions()->where('user_id', $user->id)->first();

        if ($existingReaction) {
            if ($existingReaction->type === $reaction) {
                $existingReaction->delete();
                $action = 'removed';
            } else {
                $existingReaction->update(['type' => $reaction]);
                $action = 'updated';
            }
        } else {
            $post->reactions()->create([
                'user_id' => $user->id,
                'type' => $reaction
            ]);
            $action = 'added';
        }

        $reactionsCount = $post->reactions()->count();
        $topReactions = $post->reactions()
            ->select('type', \DB::raw('count(*) as count'))
            ->groupBy('type')
            ->orderBy('count', 'desc')
            ->take(3)
            ->pluck('type')
            ->toArray();

        return response()->json([
            'success' => true,
            'action' => $action,
            'reactionsCount' => $reactionsCount,
            'topReactions' => $topReactions,
        ]);
    }

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

    public function like(Post $post)
    {
        try {
            $user = auth()->user();
            $liked = $user->likes()->toggle($post->id);
            
            return response()->json([
                'success' => true,
                'liked' => in_array($post->id, $liked['attached']),
                'likesCount' => $post->likes()->count(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error toggling like: ' . $e->getMessage(),
            ], 500);
        }
    }
}
