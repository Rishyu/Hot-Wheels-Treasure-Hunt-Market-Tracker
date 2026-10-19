<?php

namespace Tests\Feature;

use App\Models\AdminAction;
use App\Models\ApprovedPrice;
use App\Models\PriceSubmission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPricingTest extends TestCase
{
    use RefreshDatabase;

    public function test_collector_cannot_view_admin_pricing_page(): void
    {
        $collector = User::factory()->create();

        $response = $this->actingAs($collector)
            ->get(route('admin.pricing.index'));

        $response->assertForbidden();
    }

    public function test_administrator_can_view_pending_submissions(): void
    {
        $admin = User::factory()->create([
            'role' => 'administrator',
        ]);

        $submission = PriceSubmission::factory()->create([
            'status' => 'Pending Approval',
        ]);

        $response = $this->actingAs($admin)
            ->get(route('admin.pricing.index'));

        $response->assertOk();

        $response->assertSee(
            $submission->car->model_name
        );

        $response->assertSee('Pending Approval');
    }

    public function test_administrator_can_approve_submission(): void
    {
        $admin = User::factory()->create([
            'role' => 'administrator',
        ]);

        $submission = PriceSubmission::factory()->create([
            'status' => 'Pending Approval',
        ]);

        $response = $this->actingAs($admin)
            ->patch(
                route('admin.pricing.approve', $submission)
            );

        $response->assertRedirect();

        $this->assertSame(
            'Approved',
            $submission->fresh()->status
        );

        $this->assertDatabaseHas('approved_prices', [
            'price_submission_id' => $submission->id,
            'car_id' => $submission->car_id,
        ]);

        $this->assertDatabaseHas('admin_actions', [
            'admin_id' => $admin->id,
            'price_submission_id' => $submission->id,
            'action' => 'approved',
        ]);
    }

    public function test_administrator_can_reject_submission(): void
    {
        $admin = User::factory()->create([
            'role' => 'administrator',
        ]);

        $submission = PriceSubmission::factory()->create([
            'status' => 'Pending Approval',
        ]);

        $response = $this->actingAs($admin)
            ->patch(
                route('admin.pricing.reject', $submission)
            );

        $response->assertRedirect();

        $this->assertSame(
            'Rejected',
            $submission->fresh()->status
        );

        $this->assertDatabaseMissing('approved_prices', [
            'price_submission_id' => $submission->id,
        ]);

        $this->assertDatabaseHas('admin_actions', [
            'admin_id' => $admin->id,
            'price_submission_id' => $submission->id,
            'action' => 'rejected',
        ]);
    }

    public function test_approved_submission_is_removed_from_pending_list(): void
    {
        $admin = User::factory()->create([
            'role' => 'administrator',
        ]);

        $submission = PriceSubmission::factory()->create([
            'status' => 'Pending Approval',
        ]);

        $this->actingAs($admin)
            ->patch(
                route('admin.pricing.approve', $submission)
            );

        $response = $this->actingAs($admin)
            ->get(route('admin.pricing.index'));

        $response->assertDontSee('Pending Approval');
    }
}