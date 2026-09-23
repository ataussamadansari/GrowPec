<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollegeDocument extends Model
{
    protected $fillable = [
        'college_id',
        'title',
        'document_type',
        'file_path',
        'file_name',
        'mime_type',
        'file_size',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function getFileUrlAttribute(): string
    {
        return str_starts_with($this->file_path, 'http')
            ? $this->file_path
            : asset('storage/'.$this->file_path);
    }
}
