<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollegeComparison extends Model
{
    protected $fillable = [
        'college_id',
        'compared_college_id',
        'title',
        'comparison_data',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'comparison_data' => 'array',
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function comparedCollege(): BelongsTo
    {
        return $this->belongsTo(College::class, 'compared_college_id');
    }
}
