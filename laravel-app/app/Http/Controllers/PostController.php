<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use App\Models\Share;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Added for logging
use App\Services\FileHandlingService;
use App\Http\Controllers\NotificationController;

class PostController extends Controller
{
    protected $fileHandlingService;

    public function __construct(FileHandlingService $fileHandlingService)
    {
        $this->fileHandlingService = $fileHandlingService;
    }

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
            'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg,mp4,mov,avi|max:20480', // 20MB max
        ]);

        $post = new Post();
        $post->content = $request->content;
        $post->user_id = auth()->id();

        if ($request->hasFile('media')) {
            $mediaInfo = $this->fileHandlingService->handleMediaUpload($request->file('media'));
            if ($mediaInfo) {
                $post->{$mediaInfo['type']} = $mediaInfo['path'];
            }
        }

        $post->save();

        $notificationController = new NotificationController();
        $notificationController->store(
            $post->user_id,
            'new_post',
            ['message' => 'You have created a new post!']
        );

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
        $post = Post::with('user')->findOrFail($id);
        $user = $post->user;
        return view('posts.show', compact('post', 'user'));
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
            'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg,mp4,mov,avi|max:20480', // 20MB max
        ]);

        $post->content = $request->input('content');

        if ($request->hasFile('media')) {
            $this->fileHandlingService->deleteOldMedia($post);
            $mediaInfo = $this->fileHandlingService->handleMediaUpload($request->file('media'));
            if ($mediaInfo) {
                $post->{$mediaInfo['type']} = $mediaInfo['path'];
                $post->{$mediaInfo['type'] === 'image' ? 'video' : 'image'} = null;
            }
        }

        $post->save();

        return redirect()->route('posts.show', $post->id)->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        if (auth()->id() !== $post->user_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        try {
            $post->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete post'], 500);
        }
    }
}
