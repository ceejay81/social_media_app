<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $posts = $user->posts()->orderBy('created_at', 'desc')->limit(3)->get();
        return view('dashboard', ['user' => $user, 'posts' => $posts]);
    }
}