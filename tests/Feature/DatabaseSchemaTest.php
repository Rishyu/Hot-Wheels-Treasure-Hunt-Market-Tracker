<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\PriceSubmission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSchemaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Requirement 3.3:
     * Each car must receive a unique ID.
     */
    public function test_each_car_has_a_unique_id(): void
    {
        $firstCar = Car::factory()->create();
        $secondCar = Car::factory()->create();

        $this->assertNotEquals(
            $firstCar->id,
            $secondCar->id
        );
    }

    /**
     * Requirement 3.5:
     * Each pricing submission must receive a unique ID.
     */
    public function test_each_price_submission_has_a_unique_id(): void
    {
        $firstSubmission = PriceSubmission::factory()->create();
        $secondSubmission = PriceSubmission::factory()->create();

        $this->assertNotEquals(
            $firstSubmission->id,
            $secondSubmission->id
        );
    }

    /**
     * Requirement 3.6:
     * Every pricing submission must belong to a car.
     */
    public function test_price_submission_is_associated_with_a_car(): void
    {
        $car = Car::factory()->create();

        $submission = PriceSubmission::factory()->create([
            'car_id' => $car->id,
        ]);

        $this->assertEquals(
            $car->id,
            $submission->car->id
        );

        $this->assertTrue(
            $car->priceSubmissions->contains($submission)
        );
    }

    /**
     * Requirement 3.7:
     * A user-submitted price must belong to the submitting collector.
     */
    public function test_user_submitted_price_is_associated_with_user(): void
    {
        $user = User::factory()->create();

        $submission = PriceSubmission::factory()->create([
            'user_id' => $user->id,
            'source_type' => 'user-submitted',
        ]);

        $this->assertEquals(
            $user->id,
            $submission->user->id
        );

        $this->assertTrue(
            $user->priceSubmissions->contains($submission)
        );
    }

    /**
     * Pricing data should contain the fields required by requirement 3.4.
     */
    public function test_price_submission_stores_required_pricing_data(): void
    {
        $submission = PriceSubmission::factory()->create([
            'price' => 49.99,
            'currency' => 'CAD',
            'source_type' => 'user-submitted',
            'submission_date' => '2026-10-08',
        ]);

        $this->assertDatabaseHas('price_submissions', [
            'id' => $submission->id,
            'price' => 49.99,
            'currency' => 'CAD',
            'source_type' => 'user-submitted',
        ]);

        $this->assertEquals(
            '2026-10-08',
            $submission->submission_date->toDateString()
        );
    }
    /**
     * New user submissions should begin pending approval.
     */
    public function test_user_submission_defaults_to_pending_approval(): void
    {
        $submission = PriceSubmission::factory()->create();

        $this->assertSame(
            'Pending Approval',
            $submission->status
        );
    }
}