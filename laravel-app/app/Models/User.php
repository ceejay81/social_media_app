<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB; // Add this line

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
}
