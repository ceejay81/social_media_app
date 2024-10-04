<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $friends = $user->friends()->paginate(10);
        $friendRequests = $user->pendingFriendRequests()->with('user')->get();
        $suggestions = User::whereDoesntHave('friends', function ($query) use ($user) {
            $query->where('friend_id', $user->id);
        })->where('id', '!=', $user->id)->inRandomOrder()->limit(5)->get();
        $pendingRequests = $user->sentFriendRequests()->pluck('friend_id')->toArray();
        $birthdays = $user->friends()->whereRaw('MONTH(birthday) = MONTH(CURDATE()) AND DAY(birthday) = DAY(CURDATE())')->get();

        return view('friends.index', compact('friends', 'friendRequests', 'suggestions', 'pendingRequests', 'birthdays'));
    }

    public function sendRequest(Request $request)
    {
        $friendship = Friendship::create([
            'user_id' => Auth::id(),
            'friend_id' => $request->friend_id,
            'accepted' => false,
        ]);

        return response()->json(['success' => true]);
    }

    public function cancelRequest(Request $request)
    {
        Friendship::where('user_id', Auth::id())
            ->where('friend_id', $request->friend_id)
            ->where('accepted', false)
            ->delete();

        return response()->json(['success' => true]);
    }

    public function acceptRequest(Request $request)
    {
        $friendship = Friendship::findOrFail($request->request_id);
        $friendship->update(['accepted' => true]);

        // Create reverse friendship
        Friendship::create([
            'user_id' => $friendship->friend_id,
            'friend_id' => $friendship->user_id,
            'accepted' => true,
        ]);

        return response()->json(['success' => true]);
    }

    public function declineRequest(Request $request)
    {
        Friendship::findOrFail($request->request_id)->delete();

        return response()->json(['success' => true]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $friends = Auth::user()->friends()
            ->where('name', 'LIKE', "%{$query}%")
            ->paginate(10);

        return view('friends.index', compact('friends'));
    }
}
