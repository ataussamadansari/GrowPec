<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollegeGallery extends Model
{
    /**
     * DB table is `college_gallery` (singular) — override Eloquent's default pluralisation.
     */
    protected $table = 'college_gallery';

    protected $fillable = [
        'college_id',
        'title',
        'image',
        'category',
        'alt_text',
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

    public function getImageUrlAttribute(): string
    {
        return str_starts_with($this->image, 'http')
            ? $this->image
            : asset('storage/'.$this->image);
    }
}
