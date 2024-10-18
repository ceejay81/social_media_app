<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationController;
use App\Models\User;
use App\Events\NewNotification;
use App\Events\NotificationSent;
class ReactionController extends Controller
{
    public function react(Request $request, Post $post)
    {
        try {
            $reaction = $request->input('reaction');
            $user = Auth::user();

            $existingReaction = $post->reactions()->where('user_id', $user->id)->first();

            if ($existingReaction) {
                if ($existingReaction->type === $reaction) {
                    $existingReaction->delete();
                    $action = 'removed';
                    $userReaction = null;
                } else {
                    $existingReaction->update(['type' => $reaction]);
                    $action = 'updated';
                    $userReaction = $reaction;
                    $this->createNotification($post, $user, $reaction);
                }
            } else {
                $post->reactions()->create([
                    'user_id' => $user->id,
                    'type' => $reaction
                ]);
                $action = 'added';
                $userReaction = $reaction;
                $this->createNotification($post, $user, $reaction);
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
                'userReaction' => $userReaction,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in ReactionController@react: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function createNotification(Post $post, User $user, string $reaction)
    {
        if ($post->user_id !== $user->id) {
            $notificationController = new NotificationController();
            $notification = $notificationController->store(
                $post->user_id,
                'new_reaction',
                [
                    'message' => $user->name . ' reacted to your post with ' . $reaction,
                    'post_id' => $post->id,
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'action' => 'reacted to your post',
                    'reaction' => $reaction
                ]
            );
            broadcast(new NotificationSent($notification))->toOthers();
        }
    }
}
