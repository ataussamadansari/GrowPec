<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class College extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'banner_image',
        'college_mode',
        'college_type',
        'university_name',
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
        'is_featured',
        'status',
    ];

    protected $casts = [
        'facilities'       => 'array',
        'faqs'             => 'array',
        'highlights'       => 'array',
        'has_boys_hostel'  => 'boolean',
        'has_girls_hostel' => 'boolean',
        'is_featured'      => 'boolean',
        'status'           => 'boolean',
        'rating'           => 'float',
        'reviews_count'    => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($college) {
            if (empty($college->slug)) {
                $college->slug = Str::slug($college->name) . '-' . rand(100, 999);
            }
        });
    }

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

    // Accessors for storage/URL images
    public function getBannerUrlAttribute(): string
    {
        if (!$this->banner_image) {
            return 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=1200&q=80';
        }
        return str_starts_with($this->banner_image, 'http')
            ? $this->banner_image
            : asset('storage/' . $this->banner_image);
    }

    public function getLogoUrlAttribute(): string
    {
        if (!$this->logo) {
            return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=2E1E6B&color=fff';
        }
        return str_starts_with($this->logo, 'http')
            ? $this->logo
            : asset('storage/' . $this->logo);
    }

    public function getCertificateUrlAttribute(): ?string
    {
        if (!$this->sample_certificate_image) {
            return null;
        }
        return str_starts_with($this->sample_certificate_image, 'http')
            ? $this->sample_certificate_image
            : asset('storage/' . $this->sample_certificate_image);
    }
}