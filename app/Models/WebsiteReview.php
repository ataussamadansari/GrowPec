<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class WebsiteReview extends Model
{
    use HasFactory;

    protected $attributes = [
        'status' => 'pending',
        'is_featured' => false,
    ];

    protected $fillable = [
        'reviewer_name',
        'email',
        'rating',
        'title',
        'review',
        'status',
        'ip_address',
        'is_featured',
        'moderated_by',
        'moderated_at',
        'moderation_reason',
    ];

    /**
     * Hidden fields to guarantee privacy when models are serialized.
     */
    protected $hidden = [
        'email',
        'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'is_featured' => 'boolean',
            'moderated_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::saved(function () {
            Cache::forget('growpec_website_reviews_stats');
            Cache::forget('growpec_website_featured_reviews');
        });

        static::deleted(function () {
            Cache::forget('growpec_website_reviews_stats');
            Cache::forget('growpec_website_featured_reviews');
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeRejected(Builder $query): Builder
    {
        return $query->where('status', 'rejected');
    }

    public function scopeFlagged(Builder $query): Builder
    {
        return $query->where('status', 'flagged');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Checks
    |--------------------------------------------------------------------------
    */

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function moderatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'moderated_by');
    }
}
