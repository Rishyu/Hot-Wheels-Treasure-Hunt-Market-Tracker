<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCarManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_collector_cannot_access_admin_car_management(): void
    {
        $collector = User::factory()->create([
            'role' => 'collector',
        ]);

        $response = $this->actingAs($collector)
            ->get(route('admin.cars.index'));

        $response->assertForbidden();
    }

    public function test_administrator_can_view_car_management_page(): void
    {
        $admin = User::factory()->create([
            'role' => 'administrator',
        ]);

        $car = Car::factory()->create([
            'model_name' => 'Mazda 787B',
        ]);

        $response = $this->actingAs($admin)
            ->get(route('admin.cars.index'));

        $response->assertOk();
        $response->assertSee('Mazda 787B');
    }

    public function test_administrator_can_add_car(): void
    {
        $admin = User::factory()->create([
            'role' => 'administrator',
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.cars.store'), [
                'model_name' => 'Porsche 911 GT3',
                'series_name' => 'HW Exotics',
                'release_year' => 2026,
                'category' => 'STH',
                'description' => 'Test car',
                'image' => null,
            ]);

        $response->assertRedirect(route('admin.cars.index'));

        $this->assertDatabaseHas('cars', [
            'model_name' => 'Porsche 911 GT3',
            'series_name' => 'HW Exotics',
            'release_year' => 2026,
            'category' => 'STH',
        ]);
    }

    public function test_administrator_can_edit_car(): void
    {
        $admin = User::factory()->create([
            'role' => 'administrator',
        ]);

        $car = Car::factory()->create([
            'model_name' => 'Old Car Name',
            'series_name' => 'Old Series',
            'release_year' => 2025,
            'category' => 'TH',
        ]);

        $response = $this->actingAs($admin)
            ->put(route('admin.cars.update', $car), [
                'model_name' => 'Updated Car Name',
                'series_name' => 'Updated Series',
                'release_year' => 2026,
                'category' => 'STH',
                'description' => 'Updated description',
                'image' => null,
            ]);

        $response->assertRedirect(route('admin.cars.index'));

        $this->assertDatabaseHas('cars', [
            'id' => $car->id,
            'model_name' => 'Updated Car Name',
            'series_name' => 'Updated Series',
            'release_year' => 2026,
            'category' => 'STH',
        ]);
    }

    public function test_administrator_can_delete_car(): void
    {
        $admin = User::factory()->create([
            'role' => 'administrator',
        ]);

        $car = Car::factory()->create([
            'model_name' => 'Delete Me',
        ]);

        $response = $this->actingAs($admin)
            ->delete(route('admin.cars.destroy', $car));

        $response->assertRedirect(route('admin.cars.index'));

        $this->assertDatabaseMissing('cars', [
            'id' => $car->id,
        ]);
    }
}