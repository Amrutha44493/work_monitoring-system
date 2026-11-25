<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Employee;
use App\Models\Customer;
use App\Models\FittingType;
use App\Models\WorkLog;
use App\Models\WorkAssignment;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'active_projects'    => Project::where('status', 'in_progress')->count(),
            'working_now'        => WorkLog::where('status', 'started')->count(),
            'completed_today'    => WorkLog::where('status', 'completed')
                                    ->whereDate('updated_at', today())->count(),
            'avg_efficiency'     => round(WorkLog::where('status', 'completed')
                                    ->whereDate('updated_at', today())
                                    ->avg('efficiency') ?? 0, 1),
            'pending_assignments'=> WorkAssignment::where('status', 'pending')->count(),
            'total_employees'    => Employee::where('is_active', true)->count(),
            'total_customers'    => Customer::count(),
            'total_fitting_types'=> FittingType::where('is_active', true)->count(),
        ];

        $currentlyWorking = WorkLog::where('status', 'started')
            ->with(['employee', 'fittingType', 'project'])
            ->latest()
            ->take(8)
            ->get();

        $todaySummary = [
            'total_actual_time'   => WorkLog::where('status', 'completed')
                                    ->whereDate('updated_at', today())
                                    ->sum('actual_time') ?? 0,
            'total_standard_time' => WorkLog::where('status', 'completed')
                                    ->whereDate('updated_at', today())
                                    ->sum('standard_time') ?? 0,
            'variance'            => WorkLog::where('status', 'completed')
                                    ->whereDate('updated_at', today())
                                    ->sum('variance') ?? 0,
        ];

        $recentProjects = Project::with('customer')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'currentlyWorking',
            'todaySummary',
            'recentProjects'
        ));
    }
}