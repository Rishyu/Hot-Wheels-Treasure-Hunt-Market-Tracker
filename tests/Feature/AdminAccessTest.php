<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Guests must log in before accessing the admin area.
     */
    public function test_guest_cannot_access_admin_area(): void
    {
        $response = $this->get(route('admin.index'));

        $response->assertRedirect(route('login'));
    }

    /**
     * Collector accounts must not access admin functionality.
     */
    public function test_collector_cannot_access_admin_area(): void
    {
        $collector = User::factory()->create();

        $response = $this->actingAs($collector)
            ->get(route('admin.index'));

        $response->assertForbidden();
    }

    /**
     * Administrator accounts can access admin functionality.
     */
    public function test_administrator_can_access_admin_area(): void
    {
        $administrator = User::factory()->create();

        $administrator->role = 'administrator';
        $administrator->save();

        $response = $this->actingAs($administrator)
            ->get(route('admin.index'));

        $response->assertOk();
        $response->assertSee('Administrator Area');
    }
}