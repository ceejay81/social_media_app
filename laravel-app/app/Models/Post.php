<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['content', 'image', 'video', 'user_id'];

    // Add this method to define the relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // If you have a likes relationship, add this method
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    // If you have a comments relationship, add this method
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the top 3 reactions for this post.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getTopReactionsAttribute()
    {
        return $this->reactions()
            ->select('type')
            ->groupBy('type')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(3)
            ->pluck('type')
            ->map(function ($type) {
                return $this->reactionEmoji($type);
            });
    }

    /**
     * Get the emoji for a given reaction type.
     *
     * @param string $type
     * @return string
     */
    private function reactionEmoji($type)
    {
        $emojis = [
            'like' => '👍',
            'love' => '❤️',
            'haha' => '😆',
            'wow' => '😮',
            'sad' => '😢',
            'angry' => '😠',
        ];

        return $emojis[$type] ?? '👍';
    }

    /**
     * Get the reactions for the post.
     */
    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function shares()
    {
        return $this->hasMany(Share::class);
    }

    public function originalPost()
    {
        return $this->belongsTo(Post::class, 'original_post_id');
    }
}
