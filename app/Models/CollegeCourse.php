<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    protected static function booted(): void
    {
        static::saving(function (CollegeCourse $collegeCourse) {
            // Auto-fill duration from Course master if blank
            if (empty($collegeCourse->duration) && $collegeCourse->course_id) {
                $collegeCourse->duration = Course::find($collegeCourse->course_id)?->duration;
            }

            // Keep specialization string and specialization_id synchronized
            if ($collegeCourse->specialization_id && empty($collegeCourse->specialization)) {
                $collegeCourse->specialization = Specialization::find($collegeCourse->specialization_id)?->name;
            } elseif ($collegeCourse->specialization && empty($collegeCourse->specialization_id) && $collegeCourse->course_id) {
                $collegeCourse->specialization_id = Specialization::where('course_id', $collegeCourse->course_id)
                    ->where('name', $collegeCourse->specialization)
                    ->value('id');
            }
        });
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

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function specialization(): BelongsTo
    {
        return $this->belongsTo(Specialization::class);
    }

    public function specializationRelation(): BelongsTo
    {
        return $this->belongsTo(Specialization::class, 'specialization_id');
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

    /**
     * Resolves specialization title from relationship or attribute fallback.
     */
    public function getSpecializationTitleAttribute(): string
    {
        return $this->specializationRelation?->name
            ?? (is_string($this->attributes['specialization'] ?? null) && ! empty($this->attributes['specialization']) ? $this->attributes['specialization'] : 'General / Core');
    }
}
