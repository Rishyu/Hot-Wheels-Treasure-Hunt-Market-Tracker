<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminAction extends Model
{
    protected $fillable = [
        'admin_id',
        'price_submission_id',
        'action',
        'action_at',
    ];

    protected function casts(): array
    {
        return [
            'action_at' => 'datetime',
        ];
    }

    /**
     * Administrator who performed the review.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Pricing submission that was reviewed.
     */
    public function priceSubmission(): BelongsTo
    {
        return $this->belongsTo(PriceSubmission::class);
    }
}