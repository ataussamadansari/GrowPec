<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollegeCourseFee extends Model
{
    protected $fillable = [
        'college_course_id',
        'fee_type',
        'label',
        'amount',
        'academic_session',
        'description',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'amount' => 'float',
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function collegeCourse(): BelongsTo
    {
        return $this->belongsTo(CollegeCourse::class);
    }
}
