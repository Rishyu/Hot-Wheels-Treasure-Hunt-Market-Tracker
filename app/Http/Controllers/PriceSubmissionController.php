<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\PriceSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PriceSubmissionController extends Controller
{
    /**
     * Store pricing submitted by a collector.
     */
    public function store(Request $request, Car $car): RedirectResponse
    {
        $validated = $request->validate([
            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'currency' => [
                'required',
                'string',
                'size:3',
            ],

            'submission_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
        ]);

        // Prevent duplicate pricing for the same car, price and date.
        $duplicateExists = PriceSubmission::query()
            ->where('car_id', $car->id)
            ->where('price', $validated['price'])
            ->whereDate('submission_date', $validated['submission_date'])
            ->exists();

        if ($duplicateExists) {
            throw ValidationException::withMessages([
                'price' => 'This pricing entry has already been submitted for this car and date.',
            ]);
        }

        PriceSubmission::create([
            'car_id' => $car->id,
            'user_id' => $request->user()->id,
            'price' => $validated['price'],
            'currency' => strtoupper($validated['currency']),
            'submission_date' => $validated['submission_date'],

            // Collector-created pricing is always user submitted.
            'source_type' => 'user-submitted',

            // Also explicitly set this even though the database has a default.
            'status' => 'Pending Approval',
        ]);

        return back()->with(
            'pricing_status',
            'Price submitted successfully and is waiting for administrator approval.'
        );
    }
}