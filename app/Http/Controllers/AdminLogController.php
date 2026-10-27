<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class AdminLogController extends Controller
{
    /**
     * Display recent Laravel application log entries.
     */
    public function index(): View
    {
        $logPath = storage_path('logs/laravel.log');

        if (! File::exists($logPath)) {
            $logContent = 'No application log file exists yet.';
        } else {
            $lines = file($logPath);

            // Show only the most recent 200 lines.
            $recentLines = array_slice($lines, -200);

            $logContent = implode('', $recentLines);
        }

        return view('admin.logs.index', [
            'logContent' => $logContent,
        ]);
    }
}