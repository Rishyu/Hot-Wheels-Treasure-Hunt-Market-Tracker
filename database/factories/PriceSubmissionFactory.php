<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\PriceSubmission>
 */
class PriceSubmissionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'car_id' => Car::factory(),
            'user_id' => User::factory(),

            'price' => fake()->randomFloat(2, 1, 500),
            'currency' => 'CAD',

            'source_type' => 'user-submitted',

            'submission_date' => now()->toDateString(),

            'status' => 'Pending Approval',
        ];
    }
}