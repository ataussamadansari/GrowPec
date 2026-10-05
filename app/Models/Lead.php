<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    protected $fillable = [
        'college_id',
        'college_course_id',
        'course_id',
        'specialization_id',
        'state_id',
        'city_id',
        'name',
        'phone',
        'email',
        'city',
        'state',
        'source',
        'preferred_mode',
        'message',
        'status',
        'assigned_to',
        'next_followup_at',
        'contacted_at',
        'closed_at',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'notes',
    ];

    protected $casts = [
        'next_followup_at' => 'datetime',
        'contacted_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function collegeCourse(): BelongsTo
    {
        return $this->belongsTo(CollegeCourse::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function specialization(): BelongsTo
    {
        return $this->belongsTo(Specialization::class);
    }

    public function stateRelation(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function cityRelation(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function assignedCounselor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(LeadActivity::class);
    }
}
