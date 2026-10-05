<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollegeScholarship extends Model
{
    protected $fillable = [
        'college_id',
        'name',
        'eligibility',
        'criteria',
        'amount',
        'amount_label',
        'percentage',
        'description',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'amount' => 'float',
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    /**
     * Display label: prefers amount_label, then formatted amount, then percentage.
     */
    public function getDisplayAmountAttribute(): string
    {
        if ($this->amount_label) {
            return $this->amount_label;
        }

        if ($this->amount) {
            return '₹'.number_format($this->amount);
        }

        if ($this->percentage) {
            return $this->percentage.'% Waiver';
        }

        return 'As per eligibility';
    }
}
