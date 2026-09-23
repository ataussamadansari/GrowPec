<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollegeAccreditation extends Model
{
    protected $fillable = [
        'college_id',
        'authority',
        'accreditation',
        'grade',
        'rank',
        'year',
        'description',
        'certificate_image',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function getCertificateUrlAttribute(): ?string
    {
        if (! $this->certificate_image) {
            return null;
        }

        return str_starts_with($this->certificate_image, 'http')
            ? $this->certificate_image
            : asset('storage/'.$this->certificate_image);
    }
}
