<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $currentUser = Auth::user();
        $isFriend = $currentUser->friends()->where('friend_id', $user->id)->exists();
        $hasSentRequest = $currentUser->sentFriendRequests()->where('friend_id', $user->id)->exists();
        $hasReceivedRequest = $currentUser->pendingFriendRequests()->where('user_id', $user->id)->exists();

        return view('profile.show', [
            'user' => $user,
            'isFriend' => $isFriend,
            'hasSentRequest' => $hasSentRequest,
            'hasReceivedRequest' => $hasReceivedRequest,
        ]);
    }

    public function edit(User $user)
    {
        // Only allow editing the profile of the logged-in user or the profile that exists
        if ($user->id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        return view('profile.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'background_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string|max:500',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;

        if ($request->hasFile('profile_picture')) {
            $profilePicture = $request->file('profile_picture');
            $profilePicturePath = $profilePicture->store('profile_pictures', 'public');
            $user->profile_picture_url = $profilePicturePath; // This should be like 'profile_pictures/filename.jpg'
        }

        if ($request->hasFile('background_picture')) {
            $backgroundPicture = $request->file('background_picture');
            $backgroundPicturePath = $backgroundPicture->store('background_pictures', 'public');
            $user->background_picture_url = $backgroundPicturePath; // This should be like 'background_pictures/filename.jpg'
        }

        $user->save();

        return redirect()->route('profile.show', $user)->with('success', 'Profile updated successfully');
    }
}
