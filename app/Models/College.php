<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class College extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'slug',
        'logo',
        'banner_image',
        'college_mode',
        'college_type',
        'university_name',
        'website',
        'state',
        'state_id',
        'city',
        'city_id',
        'address',
        'established_year',
        'campus_size',
        'approvals',
        'entrance_exams',
        'rating',
        'reviews_count',
        'highest_package',
        'average_package',
        'top_recruiters',
        'has_boys_hostel',
        'has_girls_hostel',
        'facilities',
        'overview',
        'admission_process',
        'scholarship_info',
        'sample_certificate_image',
        'brochure_pdf',
        'faqs',
        'highlights',
        'naac_grade',
        'ugc_approved',
        'nirf_rank',
        'nirf_year',
        'seo_title',
        'seo_description',
        'is_featured',
        'status',
    ];

    protected $casts = [
        'has_boys_hostel' => 'boolean',
        'has_girls_hostel' => 'boolean',
        'ugc_approved' => 'boolean',
        'is_featured' => 'boolean',
        'status' => 'boolean',
        'rating' => 'float',
        'reviews_count' => 'integer',
    ];

    /**
     * college_mode is now strictly 'regular' | 'online' — 'both' removed.
     */
    public const MODES = ['regular', 'online'];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (College $college) {
            if (empty($college->slug)) {
                $college->slug = Str::slug($college->name).'-'.rand(100, 999);
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships — Academic
    |--------------------------------------------------------------------------
    */

    public function collegeCourses(): HasMany
    {
        return $this->hasMany(CollegeCourse::class)->orderBy('sort_order');
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'college_courses')
            ->withPivot('specialization', 'fee_amount', 'fee_type', 'eligibility')
            ->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships — CRM
    |--------------------------------------------------------------------------
    */

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships — Location
    |--------------------------------------------------------------------------
    */

    public function stateRelation(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function cityRelation(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships — Content Child Tables
    |--------------------------------------------------------------------------
    */

    public function collegeHighlights(): HasMany
    {
        return $this->hasMany(CollegeHighlight::class)->orderBy('sort_order');
    }

    public function accreditations(): HasMany
    {
        return $this->hasMany(CollegeAccreditation::class)->orderBy('sort_order');
    }

    public function admissionSections(): HasMany
    {
        return $this->hasMany(CollegeAdmissionSection::class)->orderBy('sort_order');
    }

    public function scholarships(): HasMany
    {
        return $this->hasMany(CollegeScholarship::class)->orderBy('sort_order');
    }

    public function placementStats(): HasMany
    {
        return $this->hasMany(CollegePlacementStat::class)->orderBy('sort_order');
    }

    public function recruiters(): HasMany
    {
        return $this->hasMany(CollegeRecruiter::class)->orderBy('sort_order');
    }

    public function careerOutcomes(): HasMany
    {
        return $this->hasMany(CollegeCareerOutcome::class)->orderBy('sort_order');
    }

    public function collegeFacilities(): HasMany
    {
        return $this->hasMany(CollegeFacility::class)->orderBy('sort_order');
    }

    public function learningExperiences(): HasMany
    {
        return $this->hasMany(CollegeLearningExperience::class)->orderBy('sort_order');
    }

    public function loanOptions(): HasMany
    {
        return $this->hasMany(CollegeLoanOption::class)->orderBy('sort_order');
    }

    public function collegeFaqs(): HasMany
    {
        return $this->hasMany(CollegeFaq::class)->orderBy('sort_order');
    }

    public function gallery(): HasMany
    {
        return $this->hasMany(CollegeGallery::class)->orderBy('sort_order');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(CollegeDocument::class)->orderBy('sort_order');
    }

    public function alumni(): HasMany
    {
        return $this->hasMany(CollegeAlumni::class)->orderBy('sort_order');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(CollegeReview::class)
            ->where('status', true)
            ->orderByDesc('created_at');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getBannerUrlAttribute(): string
    {
        if (! $this->banner_image) {
            return 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=1200&q=80';
        }

        return str_starts_with($this->banner_image, 'http')
            ? $this->banner_image
            : asset('storage/'.$this->banner_image);
    }

    public function getLogoUrlAttribute(): string
    {
        if (! $this->logo) {
            return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=2E1E6B&color=fff';
        }

        return str_starts_with($this->logo, 'http')
            ? $this->logo
            : asset('storage/'.$this->logo);
    }

    public function getCertificateUrlAttribute(): ?string
    {
        if (! $this->sample_certificate_image) {
            return null;
        }

        return str_starts_with($this->sample_certificate_image, 'http')
            ? $this->sample_certificate_image
            : asset('storage/'.$this->sample_certificate_image);
    }

    public function isOnline(): bool
    {
        return $this->college_mode === 'online';
    }

    public function isRegular(): bool
    {
        return $this->college_mode === 'regular';
    }
}
