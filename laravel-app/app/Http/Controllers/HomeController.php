<?php

// In app/Http/Controllers/HomeController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'reactions', 'comments'])
            ->latest()
            ->paginate(10);

        $suggestedFriends = User::where('id', '!=', auth()->id())
            ->inRandomOrder()
            ->limit(5)
            ->get();

        return view('home.index', compact('posts', 'suggestedFriends'));
    }
}
