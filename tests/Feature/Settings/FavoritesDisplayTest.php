<?php

namespace Tests\Feature\Settings;

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoritesDisplayTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verify that a collector can see a saved favorite car.
     */
    public function test_collector_can_view_saved_favorite_car(): void
    {
        $user = User::factory()->create();

        $car = Car::factory()->create([
            'model_name' => 'Mazda 787B',
            'series_name' => 'Factory Fresh',
            'release_year' => 2020,
            'category' => 'TH',
        ]);

        $user->favorites()->attach($car->id);

        $response = $this->actingAs($user)
            ->get(route('profile.edit'));

        $response->assertOk();
        $response->assertSee('Saved Favorites');
        $response->assertSee('Mazda 787B');
        $response->assertSee('Factory Fresh');
        $response->assertSee('2020');
        $response->assertSee('TH');
    }

    /**
     * Verify the empty favorites state is displayed.
     */
    public function test_empty_favorites_message_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('profile.edit'));

        $response->assertOk();
        $response->assertSee(
            'You have not saved any favorite cars yet.'
        );
    }
}