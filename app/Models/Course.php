<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = ['stream_id', 'name', 'slug', 'level', 'degree_type', 'duration'];

    public function stream(): BelongsTo
    {
        return $this->belongsTo(Stream::class);
    }

    public function specializations(): HasMany
    {
        return $this->hasMany(Specialization::class);
    }

    public function collegeCourses(): HasMany
    {
        return $this->hasMany(CollegeCourse::class);
    }
}

// class Course extends Model
// {
//     protected $fillable = ['stream_id', 'name', 'slug', 'level', 'degree_type', 'duration'];

//     public function stream(): BelongsTo
//     {
//         return $this->belongsTo(Stream::class);
//     }

//     public function collegeCourses(): HasMany
//     {
//         return $this->hasMany(CollegeCourse::class);
//     }
// }