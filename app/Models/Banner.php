<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status'     => 'boolean',
        'sort_order' => 'integer',
    ];

    // Image URL Accessor
    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            return asset('assets/hero_b1.jpg');
        }
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        if (file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        return asset($this->image);
    }
}