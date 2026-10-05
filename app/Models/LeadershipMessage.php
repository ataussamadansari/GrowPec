<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadershipMessage extends Model
{
    protected $fillable = [
        'role',
        'name',
        'designation',
        'photo',
        'message',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? asset('storage/'.$this->photo) : null;
    }
}
