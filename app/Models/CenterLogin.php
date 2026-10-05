<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CenterLogin extends Model
{
    use HasFactory;

    protected $table = 'center_logins';

    protected $fillable = [
        'title',
        'url',
        'is_active',
        'index',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'index' => 'integer',
        ];
    }

    /**
     * Scope query to active center logins ordered by index.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->orderBy('index', 'asc')
            ->orderBy('id', 'asc');
    }

    /**
     * Get all active center logins cached.
     *
     * @return Collection<int, CenterLogin>
     */
    public static function getAllCached()
    {
        return Cache::remember('growpec_active_center_logins', 3600, function () {
            try {
                return self::active()->get();
            } catch (\Throwable $e) {
                return collect();
            }
        });
    }

    /**
     * Clear the cache.
     */
    public static function clearCache(): void
    {
        Cache::forget('growpec_active_center_logins');
    }

    /**
     * Model booted events.
     */
    protected static function booted(): void
    {
        static::saved(function () {
            static::clearCache();
        });

        static::deleted(function () {
            static::clearCache();
        });
    }
}
