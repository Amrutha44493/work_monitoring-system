<?php

namespace App\Http\Controllers\TeamLeader;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\WorkAssignment;
use App\Models\WorkLog;
use Illuminate\Http\Request;
class WorkLogController extends Controller
{
    private function getTL()
    {
        return Employee::where('user_id', auth()->id())->first();
    }

    public function index()
    {
        $tl      = $this->getTL();
        $teamIds = Employee::where('team_leader_id', $tl->id)
            ->pluck('id')->toArray();

        $workingNow = WorkLog::whereIn('employee_id', $teamIds)
            ->where('status', 'started')
            ->with(['employee', 'fittingType', 'project', 'workAssignment'])
            ->get();

        $pendingAssignments = WorkAssignment::whereIn('employee_id', $teamIds)
            ->where('status', 'pending')
            ->with(['employee', 'fittingType', 'project'])
            ->orderBy('assigned_date')
            ->get();

        $completedToday = WorkLog::whereIn('employee_id', $teamIds)
            ->where('status', 'completed')
            ->whereDate('updated_at', today())
            ->with(['employee', 'fittingType'])
            ->latest()
            ->get();

        return view('team-leader.work.index', compact(
            'tl', 'workingNow',
            'pendingAssignments', 'completedToday'
        ));
    }
public function reassign(WorkAssignment $assignment, Request $request)
{
    $request->validate([
        'new_employee_id' => 'required|exists:employees,id',
    ]);

    $currentLog = WorkLog::where('work_assignment_id', $assignment->id)
        ->where('status', 'started')
        ->first();

    if($currentLog) {
        $endTime    = now();
$actualTime = max(1, (int) round($currentLog->start_time->diffInMinutes($endTime)));
$variance   = $actualTime - $currentLog->standard_time;
        $efficiency = round(($currentLog->standard_time / $actualTime) * 100, 2);

        $currentLog->update([
            'end_time'    => $endTime,
            'actual_time' => $actualTime,
            'variance'    => $variance,
            'efficiency'  => $efficiency,
            'status'      => 'completed',
            'notes'       => 'Partial work — reassigned to '.
                Employee::find($request->new_employee_id)->name,
        ]);
    }

    WorkAssignment::create([
        'project_id'      => $assignment->project_id,
        'employee_id'     => $request->new_employee_id,
        'team_leader_id'  => $assignment->team_leader_id,
        'fitting_type_id' => $assignment->fitting_type_id,
        'quantity'        => $assignment->quantity,
        'standard_time'   => $assignment->standard_time,
        'assigned_date'   => today(),
        'status'          => 'pending',
        'notes'           => 'Reassigned from '.
            $assignment->employee->name,
    ]);

    $assignment->update(['status' => 'completed']);

    return back()->with('success',
        'Work reassigned successfully!');
}
    // START work
    public function start(WorkAssignment $assignment)
    {
        // Check if employee already working
        $alreadyWorking = WorkLog::where('employee_id', $assignment->employee_id)
            ->where('status', 'started')
            ->exists();

        if($alreadyWorking) {
            return back()->with('error',
                $assignment->employee->name.
                ' is already working on a task! Stop that first!');
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
            '▶ Work started for '.
            $assignment->employee->name.'!');
    }

    // STOP work
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