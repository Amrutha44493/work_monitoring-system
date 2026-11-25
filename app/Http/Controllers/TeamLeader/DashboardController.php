<?php

namespace App\Http\Controllers\TeamLeader;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\WorkAssignment;
use App\Models\WorkLog;
use App\Models\Project;

class DashboardController extends Controller
{
    // Get current logged in TL's employee record
    private function getTL()
    {
        return Employee::where('user_id', auth()->id())
            ->first();
    }

    // Get team member IDs
    private function getTeamIds($tl)
    {
        return Employee::where('team_leader_id', $tl->id)
            ->pluck('id')
            ->toArray();
    }

    public function index()
    {
        $tl      = $this->getTL();
        $teamIds = $this->getTeamIds($tl);

        // Stats
        $stats = [
            'team_count'      => count($teamIds),
            'working_now'     => WorkLog::whereIn('employee_id', $teamIds)
                                    ->where('status', 'started')
                                    ->count(),
            'pending_work'    => WorkAssignment::whereIn('employee_id', $teamIds)
                                    ->where('status', 'pending')
                                    ->count(),
            'completed_today' => WorkLog::whereIn('employee_id', $teamIds)
                                    ->where('status', 'completed')
                                    ->whereDate('updated_at', today())
                                    ->count(),
            'avg_efficiency'  => round(
                WorkLog::whereIn('employee_id', $teamIds)
                    ->where('status', 'completed')
                    ->whereDate('updated_at', today())
                    ->avg('efficiency') ?? 0, 1
            ),
        ];

        // Team members with their current status
        $teamMembers = Employee::where('team_leader_id', $tl->id)
            ->with(['workLogs' => function($q) {
                $q->where('status', 'started')
                  ->with('fittingType');
            }])
            ->get();

        $workingNow = WorkLog::whereIn('employee_id', $teamIds)
            ->where('status', 'started')
            ->with(['employee', 'fittingType', 'project'])
            ->get();

        $pendingWork = WorkAssignment::whereIn('employee_id', $teamIds)
            ->where('status', 'pending')
            ->with(['employee', 'fittingType', 'project'])
            ->orderBy('assigned_date')
            ->take(10)
            ->get();

        $completedToday = WorkLog::whereIn('employee_id', $teamIds)
            ->where('status', 'completed')
            ->whereDate('updated_at', today())
            ->with(['employee', 'fittingType'])
            ->latest()
            ->take(10)
            ->get();

        return view('team-leader.dashboard', compact(
            'tl', 'stats', 'teamMembers',
            'workingNow', 'pendingWork', 'completedToday'
        ));
    }

    public function employees()
    {
        $tl = $this->getTL();

        $employees = Employee::where('team_leader_id', $tl->id)
            ->get()
            ->map(function($emp) {
                $todayLogs = WorkLog::where('employee_id', $emp->id)
                    ->whereDate('start_time', today())
                    ->get();

                $emp->is_working     = $todayLogs->where('status','started')->count() > 0;
                $emp->today_tasks    = $todayLogs->where('status','completed')->count();
                $emp->today_time     = $todayLogs->where('status','completed')->sum('actual_time');
                $emp->today_eff      = round($todayLogs->where('status','completed')->avg('efficiency') ?? 0, 1);
                $emp->current_task   = $todayLogs->where('status','started')->first();
                return $emp;
            });

        return view('team-leader.employees',
            compact('tl', 'employees'));
    }
}