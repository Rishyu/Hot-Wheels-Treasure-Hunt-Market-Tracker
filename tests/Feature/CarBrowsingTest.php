<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarBrowsingTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_view_car_catalog(): void
    {
        $response = $this->get(route('cars.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_collector_can_view_car_catalog(): void
    {
        $user = User::factory()->create();

        $car = Car::factory()->create([
            'model_name' => 'Mazda 787B',
            'series_name' => 'Factory Fresh',
            'release_year' => 2020,
            'category' => 'TH',
        ]);

        $response = $this->actingAs($user)
            ->get(route('cars.index'));

        $response->assertOk();
        $response->assertSee('Mazda 787B');
        $response->assertSee('Factory Fresh');
        $response->assertSee('2020');
        $response->assertSee('TH');
    }

    public function test_collector_can_view_car_details(): void
    {
        $user = User::factory()->create();

        $car = Car::factory()->create([
            'model_name' => 'Porsche 935',
            'series_name' => 'HW Exotics',
            'release_year' => 2024,
            'category' => 'STH',
            'description' => 'A Super Treasure Hunt test car.',
        ]);

        $response = $this->actingAs($user)
            ->get(route('cars.show', $car));

        $response->assertOk();
        $response->assertSee('Porsche 935');
        $response->assertSee('HW Exotics');
        $response->assertSee('2024');
        $response->assertSee('STH');
        $response->assertSee('A Super Treasure Hunt test car.');
    }
}