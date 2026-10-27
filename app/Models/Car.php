<?php

namespace App\Models;

use Database\Factories\CarFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    /** @use HasFactory<CarFactory> */
    use HasFactory;

    protected $fillable = [
        'model_name',
        'series_name',
        'release_year',
        'category',
        'description',
        'image',
    ];

    /**
     * Get collectors who saved this car.
     */
    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')
            ->withTimestamps();
    }
    /**
     * Pricing submissions associated with this car.
     */
    public function priceSubmissions(): HasMany
    {
        return $this->hasMany(PriceSubmission::class);
    }

    /**
     * Approved pricing history for this car.
     */
    public function approvedPrices(): HasMany
    {
        return $this->hasMany(ApprovedPrice::class);
    }
}