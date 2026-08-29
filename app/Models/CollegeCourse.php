<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollegeCourse extends Model
{
    protected $fillable = [
        'college_id', 'course_id', 'specialization', 'fee_amount', 'fee_type', 'eligibility'
    ];

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}