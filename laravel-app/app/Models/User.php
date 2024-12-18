<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture_url',
        'background_picture_url',
        'bio',
        'location',
        'workplace',
        'birthday',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birthday' => 'date',
        ];
    }

    
    public function posts()
    {
        return $this->hasMany(Post::class)->latest();
    }

    // If you have a likes relationship, add this method
    public function likes()
    {
        return $this->belongsToMany(Post::class, 'likes');
    }

    // If you have a comments relationship, add this method
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function sharedPosts()
    {
        return $this->hasManyThrough(Post::class, Share::class, 'user_id', 'id', 'id', 'post_id')->latest('shares.created_at');
    }

    public function shares()
    {
        return $this->hasMany(Share::class);
    }

    public function allPosts()
    {
        return Post::select('posts.*', DB::raw('"post" as type'), DB::raw('posts.created_at as order_date'))
            ->where('user_id', $this->id)
            ->unionAll(
                Share::select('posts.*', DB::raw('"share" as type'), DB::raw('shares.created_at as order_date'))
                    ->join('posts', 'shares.post_id', '=', 'posts.id')
                    ->where('shares.user_id', $this->id)
            )
            ->orderBy('order_date', 'desc');
    }

    public function friendships()
    {
        return $this->hasMany(Friendship::class, 'user_id');
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
            ->wherePivot('accepted', true);
    }

    public function pendingFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'friend_id')
            ->where('accepted', false);
    }

    public function sentFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'user_id')
            ->where('accepted', false);
    }

    public function hasSentFriendRequestTo(User $user)
    {
        return $this->friendRequestsSent()->where('friend_id', $user->id)->exists();
    }

    // Add this method to get the sender of a friend request
    public function friendRequestsReceived()
    {
        return $this->belongsToMany(User::class, 'friendships', 'friend_id', 'user_id')
                    ->withTimestamps()
                    ->withPivot('accepted')
                    ->wherePivot('accepted', false)
                    ->select('users.*');
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function getConversations()
    {
        $sentMessages = $this->sentMessages()
            ->select('receiver_id as user_id')
            ->selectRaw('MAX(created_at) as last_message_at')
            ->groupBy('receiver_id');

        $receivedMessages = $this->receivedMessages()
            ->select('sender_id as user_id')
            ->selectRaw('MAX(created_at) as last_message_at')
            ->groupBy('sender_id');

        $conversations = $sentMessages->union($receivedMessages)
            ->orderBy('last_message_at', 'desc')
            ->get();

        return User::whereIn('id', $conversations->pluck('user_id'))
            ->withCount(['sentMessages', 'receivedMessages'])
            ->get();
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
}
