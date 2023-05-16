<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    /**
     * Get all of the comments for the device
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deviceLog()
    {
        return $this->hasMany(DeviceLog::class, 'device_id');
    }
}
