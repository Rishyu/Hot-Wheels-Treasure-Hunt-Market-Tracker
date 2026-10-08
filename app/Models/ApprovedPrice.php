<?php

namespace App\Models;

use Database\Factories\ApprovedPriceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApprovedPrice extends Model
{
    /** @use HasFactory<ApprovedPriceFactory> */
    use HasFactory;

    protected $fillable = [
        'price_submission_id',
        'car_id',
        'price',
        'currency',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'approved_at' => 'datetime',
        ];
    }

    /**
     * Original pricing submission.
     */
    public function priceSubmission(): BelongsTo
    {
        return $this->belongsTo(PriceSubmission::class);
    }

    /**
     * Hot Wheels car associated with this approved price.
     */
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}