<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $cars = Car::query()
            ->withAvg('approvedPrices', 'price')
            ->orderByDesc('release_year')
            ->orderBy('model_name')
            ->limit(8)
            ->get();

        return view('dashboard', [
            'cars' => $cars,
            'carCount' => Car::count(),
            'favoritesCount' => $user->favorites()->count(),
            'submissionCount' => $user->priceSubmissions()->count(),
        ]);
    }
}