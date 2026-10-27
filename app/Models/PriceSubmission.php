<?php

namespace App\Models;

use Database\Factories\PriceSubmissionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PriceSubmission extends Model
{
    /** @use HasFactory<PriceSubmissionFactory> */
    use HasFactory;

    protected $fillable = [
        'car_id',
        'user_id',
        'price',
        'currency',
        'source_type',
        'submission_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'submission_date' => 'date',
        ];
    }

    /**
     * The car this pricing submission belongs to.
     */
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * The collector who submitted this price.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The approved price created from this submission.
     */
    public function approvedPrice(): HasOne
    {
        return $this->hasOne(ApprovedPrice::class);
    }
}