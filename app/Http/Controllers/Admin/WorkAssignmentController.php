<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkAssignment;
use App\Models\Project;
use App\Models\Employee;
use App\Models\FittingType;
use Illuminate\Http\Request;

class WorkAssignmentController extends Controller
{
    public function index(Request $request)
    {
        $query = WorkAssignment::with([
            'employee', 'fittingType', 'project'
        ])->latest();

        if($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $assignments = $query->paginate(15);
        $projects    = Project::orderBy('name')->get();

        return view('admin.assignments.index',
            compact('assignments', 'projects'));
    }

   public function create(Request $request)
{
    $projects = Project::whereIn('status', [
        'pending', 'in_progress'
    ])->with('customer')->get();

    $employees = Employee::employees()->active()->get();

    $selectedProject = null;
    $projectItems    = collect();

    if($request->filled('project_id')) {
        $selectedProject = Project::with([
            'customer',
            'fittingItems.fittingType.category',
            'teamLeader',
        ])->find($request->project_id);

        if($selectedProject) {
            $projectItems = $selectedProject->fittingItems;
        }
    }

    return view('admin.assignments.create',
        compact(
            'projects', 'employees',
            'selectedProject', 'projectItems'
        ));
}
    public function store(Request $request)
    {
        $request->validate([
            'project_id'      => 'required|exists:projects,id',
            'employee_id'     => 'required|exists:employees,id',
            'fitting_type_id' => 'required|exists:fitting_types,id',
            'quantity'        => 'required|integer|min:1',
            'assigned_date'   => 'required|date',
            'notes'           => 'nullable|string',
        ]);

        $fittingType = FittingType::find(
            $request->fitting_type_id
        );

        $project = Project::find($request->project_id);

        WorkAssignment::create([
            'project_id'      => $request->project_id,
            'employee_id'     => $request->employee_id,
            'team_leader_id'  => $project->team_leader_id,
            'fitting_type_id' => $request->fitting_type_id,
            'quantity'        => $request->quantity,
            'standard_time'   => $fittingType->standard_time
                                  * $request->quantity,
            'assigned_date'   => $request->assigned_date,
            'status'          => 'pending',
            'notes'           => $request->notes,
        ]);

        return redirect()
            ->route('admin.assignments.index')
            ->with('success', 'Work assigned successfully!');
    }

    public function destroy(WorkAssignment $assignment)
    {
        if($assignment->status === 'in_progress') {
            return back()->with('error',
                'Cannot delete — work is in progress!');
        }
        $assignment->delete();
        return back()->with('success', 'Assignment removed!');
    }
}