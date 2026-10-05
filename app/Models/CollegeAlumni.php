<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollegeAlumni extends Model
{
    /**
     * DB table is `college_alumni` (already plural in its own way) —
     * override to prevent Eloquent guessing `college_alumnis`.
     */
    protected $table = 'college_alumni';

    protected $fillable = [
        'college_id',
        'name',
        'designation',
        'company',
        'batch',
        'image',
        'description',
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

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=E2E8F0&color=475569';
        }

        return str_starts_with($this->image, 'http')
            ? $this->image
            : asset('storage/'.$this->image);
    }
}
