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

use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
});

require __DIR__.'/auth.php';
