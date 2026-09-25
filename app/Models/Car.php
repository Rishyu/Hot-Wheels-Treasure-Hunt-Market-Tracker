<?php

namespace App\Models;

use Database\Factories\CarFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
}