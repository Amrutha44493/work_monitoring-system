<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkLog;
use App\Models\WorkAssignment;
use Illuminate\Http\Request;

class WorkLogController extends Controller
{
    public function index()
    {
        $workingNow = WorkLog::where('status', 'started')
            ->with(['employee', 'fittingType', 'project'])
            ->latest()
            ->get();

        $completedToday = WorkLog::where('status', 'completed')
            ->whereDate('updated_at', today())
            ->with(['employee', 'fittingType', 'project'])
            ->latest()
            ->get();

        $pendingWork = WorkAssignment::where('status', 'pending')
            ->with(['employee', 'fittingType', 'project'])
            ->orderBy('assigned_date')
            ->take(20)
            ->get();

        return view('admin.work-logs.index', compact(
            'workingNow',
            'completedToday',
            'pendingWork'
        ));
    }

    public function start(WorkAssignment $assignment)
    {
        $alreadyWorking = WorkLog::where(
            'employee_id', $assignment->employee_id
        )->where('status', 'started')->exists();

        if($alreadyWorking) {
            return back()->with('error',
                $assignment->employee->name.
                ' is already working on something!');
        }

        WorkLog::create([
            'work_assignment_id' => $assignment->id,
            'employee_id'        => $assignment->employee_id,
            'project_id'         => $assignment->project_id,
            'fitting_type_id'    => $assignment->fitting_type_id,
            'start_time'         => now(),
            'standard_time'      => $assignment->standard_time,
            'status'             => 'started',
        ]);

        $assignment->update(['status' => 'in_progress']);

        return back()->with('success',
            'Work started for '.
            $assignment->employee->name.'!');
    }

   public function stop(WorkLog $workLog)
{
    $endTime    = now();
   $actualTime = max(1, (int) round($workLog->start_time->diffInMinutes($endTime)));

    $variance   = $actualTime - $workLog->standard_time;

    $efficiency = $workLog->standard_time > 0
        ? round(($workLog->standard_time / $actualTime) * 100, 1)
        : 0;

    if($efficiency > 999.9) $efficiency = 999.9;

    $workLog->update([
        'end_time'    => $endTime,
        'actual_time' => $actualTime,
        'variance'    => $variance,
        'efficiency'  => $efficiency,
        'status'      => 'completed',
    ]);

    $workLog->workAssignment->update([
        'status' => 'completed'
    ]);

    return back()->with('success',
        'Work done! Time: '.$actualTime.
        ' mins | Efficiency: '.$efficiency.'%');
}
}