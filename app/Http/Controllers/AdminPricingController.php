<?php

namespace App\Http\Controllers;

use App\Models\AdminAction;
use App\Models\ApprovedPrice;
use App\Models\PriceSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminPricingController extends Controller
{
    /**
     * Display all pending pricing submissions.
     */
    public function index(): View
    {
        $pendingSubmissions = PriceSubmission::query()
            ->with(['car', 'user'])
            ->where('status', 'Pending Approval')
            ->orderBy('created_at')
            ->get();

        return view('admin.pricing.index', [
            'pendingSubmissions' => $pendingSubmissions,
        ]);
    }

    /**
     * Approve a pending pricing submission.
     */
    public function approve(
        Request $request,
        PriceSubmission $submission
    ): RedirectResponse {
        if ($submission->status !== 'Pending Approval') {
            return back()->with(
                'admin_pricing_status',
                'This pricing submission has already been reviewed.'
            );
        }

        DB::transaction(function () use ($request, $submission) {
            // Mark the original submission as approved.
            $submission->update([
                'status' => 'Approved',
            ]);

            // Store the validated price used by collectors.
            ApprovedPrice::create([
                'price_submission_id' => $submission->id,
                'car_id' => $submission->car_id,
                'price' => $submission->price,
                'currency' => $submission->currency,
                'approved_at' => now(),
            ]);

            // Record who approved the submission.
            AdminAction::create([
                'admin_id' => $request->user()->id,
                'price_submission_id' => $submission->id,
                'action' => 'approved',
                'action_at' => now(),
            ]);
        });

        return back()->with(
            'admin_pricing_status',
            'Pricing submission approved successfully.'
        );
    }

    /**
     * Reject a pending pricing submission.
     */
    public function reject(
        Request $request,
        PriceSubmission $submission
    ): RedirectResponse {
        if ($submission->status !== 'Pending Approval') {
            return back()->with(
                'admin_pricing_status',
                'This pricing submission has already been reviewed.'
            );
        }

        DB::transaction(function () use ($request, $submission) {
            // Rejected submissions do not become approved prices.
            $submission->update([
                'status' => 'Rejected',
            ]);

            // Record who rejected the submission.
            AdminAction::create([
                'admin_id' => $request->user()->id,
                'price_submission_id' => $submission->id,
                'action' => 'rejected',
                'action_at' => now(),
            ]);
        });

        return back()->with(
            'admin_pricing_status',
            'Pricing submission rejected.'
        );
    }
}