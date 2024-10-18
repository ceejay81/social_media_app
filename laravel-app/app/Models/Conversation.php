<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'other_user_id'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function otherUser()
    {
        return $this->belongsTo(User::class, 'other_user_id');
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }
}