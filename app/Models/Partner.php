<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status'     => 'boolean',
        'sort_order' => 'integer',
    ];

    // Dynamic Logo URL Accessor
    public function getLogoUrlAttribute(): string
    {
        if ($this->logo) {
            if (str_starts_with($this->logo, 'http')) {
                return $this->logo;
            }
            if (file_exists(public_path('storage/' . $this->logo))) {
                return asset('storage/' . $this->logo);
            }
            return asset($this->logo);
        }

        // Fallback UI Avatar if no image uploaded
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=F1EFF8&color=2E1E6B&size=120';
    }
}