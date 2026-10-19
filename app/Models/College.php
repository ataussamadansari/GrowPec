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
        'institution_category',
        'university_name',
        'website',
        'state_id',
        'city_id',
        'state',
        'city',
        'address',
        'established_year',
        'campus_size',
        'approvals',
        'entrance_exams',
        'rating',
        'reviews_count',
        'highest_package',
        'average_package',
        'has_boys_hostel',
        'has_girls_hostel',
        'overview',
        'admission_process',
        'scholarship_info',
        'sample_certificate_image',
        'brochure_pdf',
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

    /**
     * Mutator: Automatically resolves state_id when 'state' string is supplied (e.g. in tests/seeders).
     */
    public function setStateAttribute(?string $value): void
    {
        if (! empty($value)) {
            $state = State::firstOrCreate(
                ['name' => $value],
                ['slug' => Str::slug($value), 'status' => true]
            );
            $this->attributes['state_id'] = $state->id;
        }
    }

    /**
     * Mutator: Automatically resolves city_id when 'city' string is supplied (e.g. in tests/seeders).
     */
    public function setCityAttribute(?string $value): void
    {
        if (! empty($value)) {
            $city = City::firstOrCreate(
                [
                    'name' => $value,
                    'state_id' => $this->attributes['state_id'] ?? null,
                ],
                ['slug' => Str::slug($value), 'status' => true]
            );
            $this->attributes['city_id'] = $city->id;
        }
    }

    /**
     * Accessor: String name of state for backwards compatibility.
     */
    public function getStateNameAttribute(): string
    {
        return $this->state?->name ?? '';
    }

    /**
     * Accessor: String name of city for backwards compatibility.
     */
    public function getCityNameAttribute(): string
    {
        return $this->city?->name ?? '';
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

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function stateRelation(): BelongsTo
    {
        return $this->state();
    }

    public function cityRelation(): BelongsTo
    {
        return $this->city();
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

    public function highlights(): HasMany
    {
        return $this->collegeHighlights();
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

    public function collegeScholarships(): HasMany
    {
        return $this->scholarships();
    }

    public function placementStats(): HasMany
    {
        return $this->hasMany(CollegePlacementStat::class)->orderBy('sort_order');
    }

    public function recruiters(): HasMany
    {
        return $this->hasMany(CollegeRecruiter::class)->orderBy('sort_order');
    }

    public function getTopRecruitersAttribute(): string
    {
        return $this->recruiters->pluck('name')->implode(', ');
    }

    public function careerOutcomes(): HasMany
    {
        return $this->hasMany(CollegeCareerOutcome::class)->orderBy('sort_order');
    }

    public function collegeFacilities(): HasMany
    {
        return $this->hasMany(CollegeFacility::class)->orderBy('sort_order');
    }

    public function facilities(): HasMany
    {
        return $this->collegeFacilities();
    }

    public function collegeFaqs(): HasMany
    {
        return $this->hasMany(CollegeFaq::class)->orderBy('sort_order');
    }

    public function faqs(): HasMany
    {
        return $this->collegeFaqs();
    }

    public function gallery(): HasMany
    {
        return $this->hasMany(CollegeGallery::class)->orderBy('sort_order');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(CollegeReview::class)
            ->orderByDesc('created_at');
    }

    public function approvedReviews(): HasMany
    {
        return $this->hasMany(CollegeReview::class)
            ->where('status', 'approved')
            ->orderByDesc('created_at');
    }

    public function pendingReviews(): HasMany
    {
        return $this->hasMany(CollegeReview::class)
            ->where('status', 'pending')
            ->orderByDesc('created_at');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getAverageRatingAttribute(): float
    {
        $avg = $this->approvedReviews()->avg('rating');

        return $avg !== null ? (float) round((float) $avg, 1) : (float) ($this->rating ?? 0.0);
    }

    public function getApprovedReviewsCountAttribute(): int
    {
        return $this->approvedReviews()->count();
    }

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

    public function getModeAttribute(): ?string
    {
        return $this->college_mode;
    }

    public function getTypeAttribute(): ?string
    {
        return $this->college_type;
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
