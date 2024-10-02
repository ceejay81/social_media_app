<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Friendship;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FriendController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $friends = $user->friends()->paginate(10);
        $friendRequests = $user->friendRequests;
        $suggestions = $this->getFriendSuggestions();
        $pendingRequests = $this->getPendingRequests();

        $birthdays = $user->friends()
            ->whereRaw("DATE_FORMAT(birthday, '%m-%d') = ?", [Carbon::now()->format('m-d')])
            ->get();

        return view('friends.index', compact('user', 'friends', 'friendRequests', 'suggestions', 'birthdays', 'pendingRequests'));
    }

    private function getPendingRequests()
    {
        return Friendship::where('user_id', Auth::id())
            ->where('accepted', false)
            ->pluck('friend_id')
            ->toArray();
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

        // Add a check to prevent sending a request to oneself
        if ($user->id === $friend->id) {
            return response()->json(['success' => false, 'message' => 'You cannot send a friend request to yourself.']);
        }

        // Check if a friendship already exists (accepted or pending)
        $existingFriendship = Friendship::where(function ($query) use ($user, $friend) {
            $query->where(function ($q) use ($user, $friend) {
                $q->where('user_id', $user->id)->where('friend_id', $friend->id);
            })->orWhere(function ($q) use ($user, $friend) {
                $q->where('user_id', $friend->id)->where('friend_id', $user->id);
            });
        })->first();

        if ($existingFriendship) {
            if ($existingFriendship->accepted) {
                return response()->json(['success' => false, 'message' => 'You are already friends with this user.']);
            } else {
                return response()->json(['success' => false, 'message' => 'A friend request already exists.']);
            }
        }

        // Create a new friendship request
        $friendship = Friendship::create([
            'user_id' => $user->id,
            'friend_id' => $friend->id,
            'accepted' => false
        ]);

        return response()->json([
            'success' => true, 
            'message' => 'Friend request sent.',
            'friendshipId' => $friendship->id
        ]);
    }

    public function accept($friendshipId)
    {
        $friendship = Friendship::findOrFail($friendshipId);
        
        if ($friendship->friend_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized action.']);
        }

        $friendship->update(['accepted' => true]);
        
        return response()->json([
            'success' => true, 
            'message' => 'Friend request accepted.',
            'friendName' => $friendship->user->name
        ]);
    }

    public function decline($friendshipId)
    {
        $friendship = Friendship::findOrFail($friendshipId);
        
        if ($friendship->friend_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized action.']);
        }

        $friendName = $friendship->user->name;
        $friendship->delete();
        
        return response()->json([
            'success' => true, 
            'message' => 'Friend request declined.',
            'friendName' => $friendName
        ]);
    }

    // Consider adding a method to remove a friend
    public function removeFriend($friendId)
    {
        $user = Auth::user();
        $friendship = Friendship::where(function ($query) use ($user, $friendId) {
            $query->where('user_id', $user->id)->where('friend_id', $friendId);
        })->orWhere(function ($query) use ($user, $friendId) {
            $query->where('user_id', $friendId)->where('friend_id', $user->id);
        })->firstOrFail();

        $friendship->delete();
        return response()->json(['success' => true, 'message' => 'Friend removed successfully.']);
    }

    public function cancelRequest($friendshipId)
    {
        $user = Auth::user();
        
        $friendship = Friendship::where('id', $friendshipId)
            ->where('user_id', $user->id)
            ->where('accepted', false)
            ->first();

        if ($friendship) {
            $friendship->delete();
            return response()->json([
                'success' => true, 
                'message' => 'Friend request cancelled.',
                'userId' => $friendship->friend_id
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'Friend request not found.'], 404);
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $searchResults = User::where('name', 'like', "%{$query}%")->paginate(10);

        return view('friends.search', [
            'searchResults' => $searchResults,
            'query' => $query
        ]);
    }
}