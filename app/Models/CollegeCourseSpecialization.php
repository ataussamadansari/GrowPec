<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollegeCourseSpecialization extends Model
{
    protected $fillable = [
        'college_course_id',
        'specialization_id',
        'fee_amount',
        'fee_type',
        'eligibility',
        'seats',
        'entrance_exam',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'fee_amount' => 'float',
        'seats' => 'integer',
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function collegeCourse(): BelongsTo
    {
        return $this->belongsTo(CollegeCourse::class);
    }

    public function specialization(): BelongsTo
    {
        return $this->belongsTo(Specialization::class);
    }

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
}
