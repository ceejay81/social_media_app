<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\TrendingController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FriendController;

use Illuminate\Support\Facades\Route;
use App\Models\Post;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Profile Management
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update');

    // Settings
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings');

    // Home Feed
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');

    // Create Post
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    // Saved Posts
    Route::get('/posts/saved', [PostController::class, 'saved'])->name('posts.saved');

    // Explore
    Route::get('/explore', [ExploreController::class, 'index'])->name('explore');

    // Trending
    Route::get('/trending', [TrendingController::class, 'index'])->name('trending');

    // Help Center
    Route::get('/help', [HelpController::class, 'index'])->name('help');

    // Feedback
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback');

    // Logout
    Route::post('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Comments
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::patch('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('/posts/{post}/comments', [CommentController::class, 'loadMore'])->name('comments.load-more');

    // Reactions
    Route::post('/posts/{post}/react', [ReactionController::class, 'react'])->name('posts.react');

    // Sharing posts
    Route::post('/posts/{post}/share', [ShareController::class, 'share'])->name('posts.share');

    // Like functionality
    Route::post('/posts/{post}/like', [LikeController::class, 'like'])->name('posts.like');

    // Delete Post
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Add the following line for the friends route
    Route::get('/friends', [FriendController::class, 'index'])->name('friends.index');
    Route::get('/friends/search', [FriendController::class, 'search'])->name('friends.search');

    // Friend Request Management
    Route::post('/friends/add/{user}', [FriendController::class, 'sendRequest'])->name('friends.add');
    Route::post('/friends/accept/{request}', [FriendController::class, 'acceptRequest'])->name('friends.accept');
    Route::post('/friends/decline/{request}', [FriendController::class, 'declineRequest'])->name('friends.decline');
});

require __DIR__.'/auth.php';
