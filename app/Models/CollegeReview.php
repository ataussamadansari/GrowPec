<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollegeReview extends Model
{
    protected $attributes = [
        'status' => 'pending',
    ];

    protected $fillable = [
        'college_id',
        'user_id',
        'reviewer_name',
        'email',
        'course',
        'course_enrolled',
        'rating',
        'review',
        'review_text',
        'ip_address',
        'is_verified',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'is_verified' => 'boolean',
            'status' => 'string',
        ];
    }

    /**
     * Alias attribute: course_enrolled <-> course
     */
    protected function courseEnrolled(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->attributes['course'] ?? null,
            set: fn ($value) => ['course' => $value],
        );
    }

    /**
     * Alias attribute: review_text <-> review
     */
    protected function reviewText(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->attributes['review'] ?? null,
            set: fn ($value) => ['review' => $value],
        );
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

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
