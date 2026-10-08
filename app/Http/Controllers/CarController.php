<?php

namespace App\Http\Controllers;

use App\Models\Car;
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
    public function show(Car $car): View
    {
        return view('cars.show', [
            'car' => $car,
        ]);
    }
}