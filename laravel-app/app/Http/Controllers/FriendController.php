<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\FriendRequest;
use Carbon\Carbon;
use App\Models\Friendship;

class FriendController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $friends = $user->friends()->paginate(10); // Paginate with 10 items per page
        $friendRequests = $user->friendRequestsReceived;
        $suggestions = $this->getFriendSuggestions();

        // Fetch friends with birthdays today
        $birthdays = $user->friends()
            ->whereRaw("DATE_FORMAT(birthday, '%m-%d') = ?", [Carbon::now()->format('m-d')])
            ->get();

        return view('friends.index', compact('user', 'friends', 'friendRequests', 'suggestions', 'birthdays'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $friends = Auth::user()->friends()
            ->where('name', 'like', "%{$query}%")
            ->paginate(10);

        return view('friends.index', [
            'friends' => $friends,
            'suggestions' => $this->getFriendSuggestions(),
            'friendRequests' => $this->getFriendRequests(),
            'birthdays' => $this->getFriendBirthdays(),
        ]);
    }

    private function getFriendSuggestions()
    {
        $user = Auth::user();
        $friendIds = $user->friends()->pluck('id')->toArray();
        $friendIds[] = $user->id;

        return User::whereNotIn('id', $friendIds)
            ->inRandomOrder()
            ->limit(5)
            ->get();
    }

    private function getFriendRequests()
    {
        return Auth::user()->friendRequests()
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    private function getFriendBirthdays()
    {
        $today = now()->format('m-d');
        return Auth::user()->friends()
            ->whereNotNull('birthday')
            ->whereRaw("DATE_FORMAT(birthday, '%m-%d') = ?", [$today])
            ->get();
    }

    public function sendRequest($userId)
    {
        $user = Auth::user();
        $friend = User::findOrFail($userId);

        if (!$user->hasSentFriendRequestTo($friend)) {
            $user->sentFriendRequests()->attach($friend, ['accepted' => false]);
            return response()->json(['success' => true, 'message' => 'Friend request sent.']);
        }

        return response()->json(['success' => false, 'message' => 'Friend request already sent.']);
    }

    public function acceptRequest($requestId)
    {
        $friendship = Friendship::findOrFail($requestId);
        
        if ($friendship->friend_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized action.']);
        }

        $friendship->update(['accepted' => true]);
        return response()->json(['success' => true, 'message' => 'Friend request accepted.']);
    }

    public function declineRequest($requestId)
    {
        $friendship = Friendship::findOrFail($requestId);
        
        if ($friendship->friend_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized action.']);
        }

        $friendship->delete();
        return response()->json(['success' => true, 'message' => 'Friend request declined.']);
    }
}
