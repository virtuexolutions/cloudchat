<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
class Chat extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get all of the comments for the Chat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ChatUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->where("id","!=",Auth::id());
    }
    public function ChatTargetUser()
    {
        return $this->hasOne(User::class, 'id', 'target_id')->where("id","!=",Auth::id());
    }
    public function ChatRoom()
    {
        return $this->hasmany(ChatRoom::class, 'Chat_id');
    }
}
