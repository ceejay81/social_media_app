<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReactionController extends Controller
{
    public function react(Request $request, Post $post)
    {
        $reaction = $request->input('reaction');
        $user = Auth::user();

        $existingReaction = $post->reactions()->where('user_id', $user->id)->first();

        if ($existingReaction) {
            if ($existingReaction->type === $reaction) {
                $existingReaction->delete();
                $action = 'removed';
            } else {
                $existingReaction->update(['type' => $reaction]);
                $action = 'updated';
            }
        } else {
            $post->reactions()->create([
                'user_id' => $user->id,
                'type' => $reaction
            ]);
            $action = 'added';
        }

        $reactionsCount = $post->reactions()->count();
        $topReactions = $post->reactions()
            ->select('type', \DB::raw('count(*) as count'))
            ->groupBy('type')
            ->orderBy('count', 'desc')
            ->take(3)
            ->pluck('type')
            ->toArray();

        return response()->json([
            'success' => true,
            'action' => $action,
            'reactionsCount' => $reactionsCount,
            'topReactions' => $topReactions,
        ]);
    }
}