<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class College extends Model
{
    protected $fillable = [
        'name', 'slug', 'logo', 'banner_image', 'college_mode', 'college_type',
        'university_name', 'state', 'city', 'address', 'established_year',
        'campus_size', 'approvals', 'entrance_exams', 'rating', 'reviews_count',
        'highest_package', 'average_package', 'top_recruiters', 'has_boys_hostel',
        'has_girls_hostel', 'facilities', 'overview', 'admission_process',
        'scholarship_info', 'sample_certificate_image', 'brochure_pdf',
        'faqs', 'highlights', 'is_featured', 'status'
    ];

    protected $casts = [
        'facilities' => 'array',
        'faqs' => 'array',
        'highlights' => 'array',
        'has_boys_hostel' => 'boolean',
        'has_girls_hostel' => 'boolean',
        'is_featured' => 'boolean',
        'status' => 'boolean',
    ];

    public function collegeCourses(): HasMany
    {
        return $this->hasMany(CollegeCourse::class);
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'college_courses')
                    ->withPivot('specialization', 'fee_amount', 'fee_type', 'eligibility')
                    ->withTimestamps();
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }
}