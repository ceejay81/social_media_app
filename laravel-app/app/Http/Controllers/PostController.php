<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $validatedData = $request->validate([
            'content' => 'required|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = new Post($validatedData);
        $post->user_id = auth()->id();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
            $post->image = $imagePath;
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
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $post->title = $request->input('title');
        $post->content = $request->input('content');

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $imagePath = $request->file('image')->store('posts', 'public');
            $post->image = $imagePath;
        }

        $post->save();

        return redirect()->route('posts.show', $post->id)->with('success', 'Post updated successfully!');
    }
}
