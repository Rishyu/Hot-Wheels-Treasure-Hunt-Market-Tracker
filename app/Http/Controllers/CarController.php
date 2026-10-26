<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CarController extends Controller
{
    /**
     * Display the car catalog with searching,
     * filtering, and sorting.
     */
    public function index(Request $request): View
    {
        $query = Car::query()
            ->withAvg('approvedPrices', 'price');

        /*
        |--------------------------------------------------------------------------
        | Search by Model Name
        |--------------------------------------------------------------------------
        */

        if ($request->filled('model')) {
            $query->where(
                'model_name',
                'like',
                '%' . $request->model . '%'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Search by Series Name
        |--------------------------------------------------------------------------
        */

        if ($request->filled('series')) {
            $query->where(
                'series_name',
                'like',
                '%' . $request->series . '%'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter by Release Year
        |--------------------------------------------------------------------------
        */

        if ($request->filled('year')) {
            $query->where(
                'release_year',
                $request->year
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter by Category
        |--------------------------------------------------------------------------
        */

        if ($request->filled('category')) {
            $query->where(
                'category',
                $request->category
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        switch ($request->get('sort', 'year_desc')) {

            case 'year_asc':
                $query->orderBy('release_year');
                break;

            case 'price_asc':
                // Cars without approved prices appear last.
                $query->orderByRaw(
                    'approved_prices_avg_price IS NULL'
                );

                $query->orderBy(
                    'approved_prices_avg_price'
                );
                break;

            case 'price_desc':
                // Cars without approved prices appear last.
                $query->orderByRaw(
                    'approved_prices_avg_price IS NULL'
                );

                $query->orderByDesc(
                    'approved_prices_avg_price'
                );
                break;

            case 'year_desc':
            default:
                $query->orderByDesc('release_year');
                break;
        }

        $cars = $query
            ->orderBy('model_name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Years for Filter Dropdown
        |--------------------------------------------------------------------------
        */

        $years = Car::query()
            ->select('release_year')
            ->distinct()
            ->orderByDesc('release_year')
            ->pluck('release_year');

        return view('cars.index', [
            'cars' => $cars,
            'years' => $years,
        ]);
    }

    /**
     * Display a single car.
     */
    public function show(
        Request $request,
        Car $car
    ): View {
        $isFavorite = $request->user()
            ->favorites()
            ->where('cars.id', $car->id)
            ->exists();
    
        $car->loadAvg('approvedPrices', 'price');
    
        $car->load([
            'approvedPrices' => function ($query) {
                $query
                    ->orderByDesc('approved_at')
                    ->limit(8);
            },
        ]);
    
        return view('cars.show', [
            'car' => $car,
            'isFavorite' => $isFavorite,
        ]);
    }

    /**
     * Add a car to collector favorites.
     */
    public function favorite(
        Request $request,
        Car $car
    ): RedirectResponse {
        $request->user()
            ->favorites()
            ->syncWithoutDetaching([
                $car->id,
            ]);

        return back()->with(
            'status',
            'Car added to favorites.'
        );
    }

    /**
     * Remove a car from collector favorites.
     */
    public function unfavorite(
        Request $request,
        Car $car
    ): RedirectResponse {
        $request->user()
            ->favorites()
            ->detach($car->id);

        return back()->with(
            'status',
            'Car removed from favorites.'
        );
    }
}