<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Car>
 */
class CarFactory extends Factory
{
    protected $model = Car::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'model_name' => fake()->randomElement([
                'Bone Shaker',
                'Twin Mill',
                'Batmobile',
                'Porsche 935',
                'Mazda 787B',
            ]),

            'series_name' => fake()->randomElement([
                'HW Dream Garage',
                'HW Exotics',
                'HW Modified',
                'Factory Fresh',
            ]),

            'release_year' => fake()->numberBetween(2018, 2026),

            'category' => fake()->randomElement([
                'TH',
                'STH',
            ]),

            'description' => fake()->sentence(),

            'image' => null,
        ];
    }
}