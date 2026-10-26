<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLogAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_administrator_can_view_error_logs(): void
    {
        $admin = User::factory()->create([
            'role' => 'administrator',
        ]);

        $response = $this->actingAs($admin)
            ->get(route('admin.logs.index'));

        $response->assertOk();
        $response->assertSee('System Error Logs');
    }

    public function test_collector_cannot_view_error_logs(): void
    {
        $collector = User::factory()->create([
            'role' => 'collector',
        ]);

        $response = $this->actingAs($collector)
            ->get(route('admin.logs.index'));

        $response->assertForbidden();
    }

    public function test_guest_cannot_view_error_logs(): void
    {
        $response = $this->get(route('admin.logs.index'));

        $response->assertRedirect();
    }
}