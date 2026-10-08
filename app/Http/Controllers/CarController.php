<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CarController extends Controller
{
    /**
     * Display all Hot Wheels cars for collectors.
     */
    public function index(): View
    {
        $cars = Car::query()
            ->orderByDesc('release_year')
            ->orderBy('model_name')
            ->get();

        return view('cars.index', [
            'cars' => $cars,
        ]);
    }

    /**
     * Display detailed information for one Hot Wheels car.
     */
    public function show(Request $request, Car $car): View
    {
        $isFavorite = $request->user()
            ->favorites()
            ->where('cars.id', $car->id)
            ->exists();

        return view('cars.show', [
            'car' => $car,
            'isFavorite' => $isFavorite,
        ]);
    }

    /**
     * Save a car to the collector's favorites.
     */
    public function favorite(Request $request, Car $car): RedirectResponse
    {
        $request->user()
            ->favorites()
            ->syncWithoutDetaching([$car->id]);

        return back()->with(
            'status',
            'Car added to favorites.'
        );
    }

    /**
     * Remove a car from the collector's favorites.
     */
    public function unfavorite(Request $request, Car $car): RedirectResponse
    {
        $request->user()
            ->favorites()
            ->detach($car->id);

        return back()->with(
            'status',
            'Car removed from favorites.'
        );
    }
}