<?php

namespace App\Http\Controllers;

use App\Models\AdminAction;
use App\Models\ApprovedPrice;
use App\Models\Car;
use App\Models\PriceSubmission;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $recentPendingSubmissions = PriceSubmission::query()
            ->with(['car', 'user'])
            ->where('status', 'Pending Approval')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('admin.index', [
            'carCount' => Car::count(),

            'pendingPricingCount' => PriceSubmission::query()
                ->where('status', 'Pending Approval')
                ->count(),

            'approvedPricingCount' => ApprovedPrice::count(),

            'adminActionCount' => AdminAction::count(),

            'recentPendingSubmissions' => $recentPendingSubmissions,
        ]);
    }
}