<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollegeLoanOption extends Model
{
    protected $fillable = [
        'college_id',
        'provider',
        'loan_type',
        'amount',
        'interest_rate',
        'tenure',
        'emi_from',
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
}
