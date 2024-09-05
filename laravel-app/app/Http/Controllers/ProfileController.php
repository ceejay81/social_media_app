<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        // Only allow viewing the profile of the logged-in user or the profile that exists
        if ($user->id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        return view('profile.show', ['user' => $user]);
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
        // Only allow updating the profile of the logged-in user or the profile that exists
        if ($user->id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $profilePicture = $request->file('profile_picture');
            
            // Generate a unique filename
            $filename = time() . '_' . $profilePicture->getClientOriginalName();
            
            // Save the file to the public/profile_pictures directory
            $profilePicture->move(public_path('profile_pictures'), $filename);
            
            // Update the user's profile picture URL
            $user->profile_picture_url = 'profile_pictures/' . $filename;
        }

        $user->save();

        return redirect()->route('profile.show', $user)->with('status', 'Profile updated!');
    }
}
