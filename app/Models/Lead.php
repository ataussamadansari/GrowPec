<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    protected $fillable = [
        'college_id', 'course_id', 'name', 'phone', 'email', 'city', 'state', 'source', 'status', 'notes'
    ];

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}