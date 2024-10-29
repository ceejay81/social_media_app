<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['conversation_id', 'sender_id', 'content', 'image_url', 'delivered', 'read_at', 'delivered_at'];

    protected $appends = ['is_sender'];

    protected $casts = [
        'read_at' => 'datetime',
        'delivered_at' => 'datetime',
        'delivered' => 'boolean'
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function getIsSenderAttribute()
    {
        return $this->sender_id === auth()->id();
    }
}
