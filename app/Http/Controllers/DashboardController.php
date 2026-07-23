<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\IpRecord;
use Illuminate\Http\Request;
use App\Models\CocApplication;
use Carbon\Carbon; 
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     *
     * @return \Illuminate\View\View
     */
   
public function index()
{
    // Get all applications for tribe count
    $applications = CocApplication::all();

    $tribeCounts = [];

    foreach ($applications as $app) {
        $tribe = strtolower(trim($app->tribe ?? 'Unknown')); // normalize and remove extra spaces
        $tribeCounts[$tribe] = ($tribeCounts[$tribe] ?? 0) + 1;
    }

    $chartLabels = array_map('ucfirst', array_keys($tribeCounts));
    $chartData = array_values($tribeCounts);

    // Get monthly application data for the past 12 months
    $monthlyData = $this->getMonthlyApplicationData();

    // Get recent applications (last 10)
    $recentApplications = CocApplication::with('applicant')
        ->latest('created_at')
        ->limit(10)
        ->get();

    return view('dashboard', [
        'totalUsers' => User::count(),
        'totalIpRecords' => IpRecord::count(),
        'totalCOC' => CocApplication::count(),
        'totalPending' => CocApplication::where('coc_status', 'pending')->count(),
        'chartLabels' => $chartLabels,
        'chartData' => $chartData,
        'monthlyData' => $monthlyData,
        'recentApplications' => $recentApplications,
    ]);
}

/**
 * Get monthly application data for the past 12 months
 */
private function getMonthlyApplicationData()
{
    $labels = [];
    $data = [];

    // Get data for the past 12 months
    for ($i = 11; $i >= 0; $i--) {
        $date = Carbon::now()->subMonths($i);
        $month = $date->format('M Y'); // Example: "Jan 2025"
        $labels[] = $month;

        // Count applications created in this month
        $count = CocApplication::whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->count();

        $data[] = $count;
    }

    return [
        'labels' => $labels,
        'data' => $data,
    ];
}

}
