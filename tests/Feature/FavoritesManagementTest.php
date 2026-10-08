<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoritesManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_collector_can_save_car_to_favorites(): void
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('cars.favorite', $car));

        $response->assertRedirect();

        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'car_id' => $car->id,
        ]);
    }

    public function test_collector_can_remove_car_from_favorites(): void
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        $user->favorites()->attach($car->id);

        $response = $this->actingAs($user)
            ->delete(route('cars.unfavorite', $car));

        $response->assertRedirect();

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'car_id' => $car->id,
        ]);
    }

    public function test_saving_same_car_twice_does_not_duplicate_favorite(): void
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        $this->actingAs($user)
            ->post(route('cars.favorite', $car));

        $this->actingAs($user)
            ->post(route('cars.favorite', $car));

        $this->assertSame(
            1,
            $user->favorites()
                ->where('cars.id', $car->id)
                ->count()
        );
    }

    public function test_car_page_shows_remove_button_when_already_favorited(): void
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        $user->favorites()->attach($car->id);

        $response = $this->actingAs($user)
            ->get(route('cars.show', $car));

        $response->assertOk();
        $response->assertSee('Remove Favorite');
    }
}