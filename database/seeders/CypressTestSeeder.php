<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CypressTestSeeder extends Seeder
{
    /**
     * Create data used by the Cypress Milestone 1 tests.
     */
    public function run(): void
    {
        $user = User::firstOrNew([
            'email' => 'cypress@example.com',
        ]);

        $user->name = 'cypresscollector';
        $user->username = 'cypresscollector';
        $user->email = 'cypress@example.com';
        $user->password = Hash::make('password');
        $user->role = 'collector';
        $user->email_verified_at = now();

        $user->save();

        $car = Car::firstOrCreate(
            [
                'model_name' => 'Mazda 787B',
                'series_name' => 'Factory Fresh',
                'release_year' => 2020,
                'category' => 'TH',
            ],
            [
                'description' => 'Cypress test favorite car.',
                'image' => null,
            ]
        );

        $user->favorites()->syncWithoutDetaching([
            $car->id,
        ]);
    }
}