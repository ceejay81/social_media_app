<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'image', 'user_id'];

    // Add this method to define the relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // If you have a likes relationship, add this method
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // If you have a comments relationship, add this method
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
