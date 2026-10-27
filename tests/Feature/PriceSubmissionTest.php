<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\PriceSubmission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PriceSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_collector_can_submit_valid_pricing(): void
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('cars.pricing.store', $car), [
                'price' => 59.99,
                'currency' => 'CAD',
                'submission_date' => now()->toDateString(),
            ]);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('price_submissions', [
            'car_id' => $car->id,
            'user_id' => $user->id,
            'price' => 59.99,
            'currency' => 'CAD',
            'source_type' => 'user-submitted',
            'status' => 'Pending Approval',
        ]);
    }

    public function test_price_cannot_be_negative(): void
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('cars.pricing.store', $car), [
                'price' => -5,
                'currency' => 'CAD',
                'submission_date' => now()->toDateString(),
            ]);

        $response->assertSessionHasErrors('price');
    }

    public function test_currency_is_required(): void
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('cars.pricing.store', $car), [
                'price' => 49.99,
                'currency' => '',
                'submission_date' => now()->toDateString(),
            ]);

        $response->assertSessionHasErrors('currency');
    }

    public function test_submission_date_cannot_be_in_future(): void
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('cars.pricing.store', $car), [
                'price' => 49.99,
                'currency' => 'CAD',
                'submission_date' => now()->addDay()->toDateString(),
            ]);

        $response->assertSessionHasErrors('submission_date');
    }

    public function test_duplicate_pricing_entry_is_rejected(): void
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        PriceSubmission::factory()->create([
            'car_id' => $car->id,
            'user_id' => $user->id,
            'price' => 59.99,
            'submission_date' => now()->toDateString(),
        ]);

        $response = $this->actingAs($user)
            ->post(route('cars.pricing.store', $car), [
                'price' => 59.99,
                'currency' => 'CAD',
                'submission_date' => now()->toDateString(),
            ]);

        $response->assertSessionHasErrors('price');

        $this->assertSame(
            1,
            PriceSubmission::where('car_id', $car->id)
                ->where('price', 59.99)
                ->count()
        );
    }

    public function test_new_submission_is_pending_approval(): void
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        $this->actingAs($user)
            ->post(route('cars.pricing.store', $car), [
                'price' => 79.99,
                'currency' => 'cad',
                'submission_date' => now()->toDateString(),
            ]);

        $submission = PriceSubmission::first();

        $this->assertNotNull($submission);
        $this->assertSame('Pending Approval', $submission->status);
        $this->assertSame('user-submitted', $submission->source_type);
        $this->assertSame('CAD', $submission->currency);
        $this->assertSame($user->id, $submission->user_id);
        $this->assertSame($car->id, $submission->car_id);
    }
}