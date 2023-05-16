<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get all of the comments for the Social
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function RequestUserDetail()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    
    
}
