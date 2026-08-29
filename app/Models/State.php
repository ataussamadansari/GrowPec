<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    protected $fillable = ['name', 'slug', 'status'];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}