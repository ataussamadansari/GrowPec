<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollegeReview extends Model
{
    protected $fillable = [
        'college_id',
        'user_id',
        'reviewer_name',
        'course',
        'rating',
        'review',
        'is_verified',
        'status',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_verified' => 'boolean',
        'status' => 'boolean',
    ];

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
