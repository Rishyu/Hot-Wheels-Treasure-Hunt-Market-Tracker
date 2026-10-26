<?php

namespace Tests\Feature;

use App\Models\ApprovedPrice;
use App\Models\Car;
use App\Models\PriceSubmission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarSearchFilterSortTest extends TestCase
{
    use RefreshDatabase;

    public function test_collector_can_search_by_model_name(): void
    {
        $user = User::factory()->create();

        Car::factory()->create([
            'model_name' => 'Batmobile',
        ]);

        Car::factory()->create([
            'model_name' => 'Mazda 787B',
        ]);

        $response = $this->actingAs($user)
            ->get(route('cars.index', [
                'model' => 'Batmobile',
            ]));

        $response->assertOk();

        $response->assertSee('Batmobile');

        $response->assertDontSee('Mazda 787B');
    }


    public function test_collector_can_search_by_series_name(): void
    {
        $user = User::factory()->create();

        Car::factory()->create([
            'model_name' => 'Car One',
            'series_name' => 'Factory Fresh',
        ]);

        Car::factory()->create([
            'model_name' => 'Car Two',
            'series_name' => 'HW Exotics',
        ]);

        $response = $this->actingAs($user)
            ->get(route('cars.index', [
                'series' => 'Factory Fresh',
            ]));

        $response->assertOk();

        $response->assertSee('Car One');

        $response->assertDontSee('Car Two');
    }


    public function test_collector_can_filter_by_release_year(): void
    {
        $user = User::factory()->create();

        Car::factory()->create([
            'model_name' => '2020 Car',
            'release_year' => 2020,
        ]);

        Car::factory()->create([
            'model_name' => '2026 Car',
            'release_year' => 2026,
        ]);

        $response = $this->actingAs($user)
            ->get(route('cars.index', [
                'year' => 2020,
            ]));

        $response->assertOk();

        $response->assertSee('2020 Car');

        $response->assertDontSee('2026 Car');
    }


    public function test_collector_can_filter_by_category(): void
    {
        $user = User::factory()->create();

        Car::factory()->create([
            'model_name' => 'Basic TH Model',
            'category' => 'TH',
        ]);

        Car::factory()->create([
            'model_name' => 'Rare STH Model',
            'category' => 'STH',
        ]);

        $response = $this->actingAs($user)
            ->get(route('cars.index', [
                'category' => 'STH',
            ]));

        $response->assertOk();

        $response->assertSee(
            'Rare STH Model'
        );

        $response->assertDontSee(
            'Basic TH Model'
        );
    }


    public function test_collector_can_sort_by_year(): void
    {
        $user = User::factory()->create();

        Car::factory()->create([
            'model_name' => 'Old Car',
            'release_year' => 2019,
        ]);

        Car::factory()->create([
            'model_name' => 'New Car',
            'release_year' => 2026,
        ]);

        $response = $this->actingAs($user)
            ->get(route('cars.index', [
                'sort' => 'year_asc',
            ]));

        $response->assertOk();

        $response->assertSeeInOrder([
            'Old Car',
            'New Car',
        ]);
    }


    public function test_average_price_uses_only_approved_prices(): void
    {
        $user = User::factory()->create();

        /*
         * Car A has an approved price of $100.
         */
        $carA = Car::factory()->create([
            'model_name' => 'Car A',
        ]);

        $approvedSubmissionA =
            PriceSubmission::factory()->create([
                'car_id' => $carA->id,
                'price' => 100,
                'status' => 'Approved',
            ]);

        ApprovedPrice::create([
            'price_submission_id' =>
                $approvedSubmissionA->id,

            'car_id' => $carA->id,

            'price' => 100,

            'currency' => 'CAD',

            'approved_at' => now(),
        ]);

        /*
         * This pending price should NOT affect
         * Car A's average.
         */
        PriceSubmission::factory()->create([
            'car_id' => $carA->id,
            'price' => 1,
            'status' => 'Pending Approval',
        ]);


        /*
         * Car B has an approved price of $50.
         */
        $carB = Car::factory()->create([
            'model_name' => 'Car B',
        ]);

        $approvedSubmissionB =
            PriceSubmission::factory()->create([
                'car_id' => $carB->id,
                'price' => 50,
                'status' => 'Approved',
            ]);

        ApprovedPrice::create([
            'price_submission_id' =>
                $approvedSubmissionB->id,

            'car_id' => $carB->id,

            'price' => 50,

            'currency' => 'CAD',

            'approved_at' => now(),
        ]);


        /*
         * Lowest approved average should be Car B.
         *
         * Car B = $50
         * Car A = $100
         *
         * The pending $1 submission must be ignored.
         */
        $response = $this->actingAs($user)
            ->get(route('cars.index', [
                'sort' => 'price_asc',
            ]));

        $response->assertOk();

        $response->assertSeeInOrder([
            'Car B',
            'Car A',
        ]);
    }
}