<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminCarController extends Controller
{
    /**
     * Display all cars for administration.
     */
    public function index(): View
    {
        $cars = Car::query()
            ->orderByDesc('release_year')
            ->orderBy('model_name')
            ->get();

        return view('admin.cars.index', [
            'cars' => $cars,
        ]);
    }

    /**
     * Show the form for creating a new car.
     */
    public function create(): View
    {
        return view('admin.cars.create');
    }

    /**
     * Store a newly created car.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'model_name' => [
                'required',
                'string',
                'max:255',
            ],
            'series_name' => [
                'required',
                'string',
                'max:255',
            ],
            'release_year' => [
                'required',
                'integer',
            ],
            'category' => [
                'required',
                Rule::in(['TH', 'STH']),
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'image' => [
                'nullable',
                'string',
                'max:2048',
            ],
        ]);

        Car::create($validated);

        return redirect()
            ->route('admin.cars.index')
            ->with('status', 'Car added successfully.');
    }

    /**
     * Show the form for editing a car.
     */
    public function edit(Car $car): View
    {
        return view('admin.cars.edit', [
            'car' => $car,
        ]);
    }

    /**
     * Update an existing car.
     */
    public function update(
        Request $request,
        Car $car
    ): RedirectResponse {
        $validated = $request->validate([
            'model_name' => [
                'required',
                'string',
                'max:255',
            ],
            'series_name' => [
                'required',
                'string',
                'max:255',
            ],
            'release_year' => [
                'required',
                'integer',
            ],
            'category' => [
                'required',
                Rule::in(['TH', 'STH']),
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'image' => [
                'nullable',
                'string',
                'max:2048',
            ],
        ]);

        $car->update($validated);

        return redirect()
            ->route('admin.cars.index')
            ->with('status', 'Car updated successfully.');
    }

    /**
     * Delete a car.
     */
    public function destroy(Car $car): RedirectResponse
    {
        $car->delete();

        return redirect()
            ->route('admin.cars.index')
            ->with('status', 'Car deleted successfully.');
    }
}
