<?php

namespace App\Http\Controllers\TeamLeader;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\WorkAssignment;
use App\Models\Project;
use App\Models\FittingType;
use App\Models\ProjectFittingItem;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    private function getTL()
    {
        return Employee::where('user_id', auth()->id())
            ->first();
    }

    public function index(Request $request)
    {
        $tl = $this->getTL();

        if(!$tl) {
            return view('team-leader.assignments.index', [
                'assignments' => collect(),
                'employees'   => collect(),
                'tl'          => null,
            ]);
        }

        $teamIds = Employee::where('team_leader_id', $tl->id)
            ->pluck('id')->toArray();

        $query = WorkAssignment::whereIn('employee_id', $teamIds)
            ->with(['employee', 'fittingType', 'project'])
            ->latest();

        if($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        $assignments = $query->paginate(15);
        $employees   = Employee::where('team_leader_id', $tl->id)
            ->active()->get();

        return view('team-leader.assignments.index',
            compact('assignments', 'employees', 'tl'));
    }

    public function create(Request $request)
    {
        $tl = $this->getTL();

        // Only TL's projects
        $projects = Project::where('team_leader_id', $tl?->id)
            ->whereIn('status', ['pending', 'in_progress'])
            ->with('customer')
            ->get();

        // Only TL's employees
        $employees = Employee::where('team_leader_id', $tl?->id)
            ->where('is_active', true)
            ->get();

        // Selected project with its products
        $selectedProject = null;
        $projectItems    = collect(); 

        if($request->filled('project_id')) {
            $selectedProject = Project::with([
                'customer',
                'fittingItems.fittingType.category',
            ])->find($request->project_id);

            if($selectedProject) {
                $projectItems = $selectedProject->fittingItems;
            }
        }

        return view('team-leader.assignments.create',
            compact(
                'tl',
                'projects',
                'employees',
                'selectedProject',
                'projectItems' 
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

        $tl          = $this->getTL();
        $fittingType = FittingType::find($request->fitting_type_id);

        $projectFittingItem = ProjectFittingItem::where(
            'project_id', $request->project_id
        )->where(
            'fitting_type_id', $request->fitting_type_id
        )->first(); 
        $projectFittingItemId = $projectFittingItem?->id;

        WorkAssignment::create([
            'project_id'              => $request->project_id,
            'project_fitting_item_id' => $projectFittingItemId,
            'employee_id'             => $request->employee_id,
            'team_leader_id'          => $tl->id,
            'fitting_type_id'         => $request->fitting_type_id,
            'quantity'                => $request->quantity,
            'standard_time'           => $fittingType->standard_time
                                         * $request->quantity,
            'assigned_date'           => $request->assigned_date,
            'status'                  => 'pending',
            'notes'                   => $request->notes,
        ]);

        return redirect()
            ->route('tl.assign.index')
            ->with('success', 'Work assigned successfully!');
    }

    public function destroy(WorkAssignment $assignment)
    {
        if($assignment->status === 'in_progress') {
            return back()->with('error',
                'Cannot remove! Work is in progress!');
        }
        if($assignment->status === 'completed') {
            return back()->with('error',
                'Cannot remove completed work!');
        }
        $assignment->delete();
        return back()->with('success', 'Assignment removed!');
    }
}