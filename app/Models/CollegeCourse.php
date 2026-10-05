<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CollegeCourse extends Model
{
    protected $fillable = [
        'college_id',
        'course_id',
        'specialization_id',
        'specialization',
        'fee_amount',
        'fee_type',
        'eligibility',
        'seats',
        'entrance_exam',
        'academic_session',
        'duration',
        'application_url',
        'brochure',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'fee_amount' => 'float',
        'seats' => 'integer',
        'sort_order' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function specialization(): BelongsTo
    {
        return $this->belongsTo(Specialization::class);
    }

    /**
     * Per-specialization fee rows for this college course.
     */
    public function specializationFees(): HasMany
    {
        return $this->hasMany(CollegeCourseSpecialization::class)->orderBy('sort_order');
    }

    /**
     * Detailed fee breakdown rows (per_year / per_semester / total_course).
     */
    public function fees(): HasMany
    {
        return $this->hasMany(CollegeCourseFee::class)->orderBy('sort_order');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Formatted fee label, e.g. "₹1,20,000 / Per Year"
     */
    public function getFormattedFeeAttribute(): string
    {
        if (! $this->fee_amount) {
            return 'As per college';
        }

        $label = match ($this->fee_type) {
            'per_year' => 'Per Year',
            'per_semester' => 'Per Semester',
            'total_course' => 'Total Course',
            default => ucwords(str_replace('_', ' ', $this->fee_type ?? '')),
        };

        return '₹'.number_format($this->fee_amount).' / '.$label;
    }

    /**
     * Effective duration — falls back to the linked course duration.
     */
    public function getEffectiveDurationAttribute(): ?string
    {
        return $this->duration ?? $this->course?->duration;
    }
}
