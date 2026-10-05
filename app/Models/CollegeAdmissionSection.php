<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollegeAdmissionSection extends Model
{
    protected $fillable = [
        'college_id',
        'section_key',
        'title',
        'content',
        'items',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'items' => 'array',
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }
}
