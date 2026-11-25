<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Customer;
use App\Models\FittingType;
use App\Models\ProjectFittingItem;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with('customer')->latest();

        if($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'LIKE', '%'.$request->search.'%')
                  ->orWhere('project_code', 'LIKE', '%'.$request->search.'%');
            });
        }

        if($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        $projects  = $query->paginate(10);
        $customers = Customer::orderBy('name')->get();

        return view('admin.projects.index',
            compact('projects', 'customers'));
    }

    public function create()
    {
        $customers    = Customer::orderBy('name')->get();
        $categories   = \App\Models\Category::with('fittingTypes')
            ->get();

        return view('admin.projects.create',
            compact('customers', 'categories'));
    }

    public function store(Request $request)
    {
       $request->validate([
        'customer_id'       => 'required|exists:customers,id',
        'team_leader_id'    => 'nullable|exists:employees,id',
        'name'              => 'required|string|max:255|min:3',
        'site_address'      => 'nullable|string|max:500',
        'site_city'         => 'nullable|string|max:100',
        'start_date'        => 'nullable|date',
        'expected_end_date' => 'nullable|date|after_or_equal:start_date',
        'status'            => 'required|in:pending,in_progress,completed,on_hold,cancelled',
        'notes'             => 'nullable|string|max:1000',
        'items'             => 'nullable|array',
        'items.*.fitting_type_id' => 'required|exists:fitting_types,id',
        'items.*.quantity'        => 'required|integer|min:1',
    ], [
        'customer_id.required'    => 'Please select a customer!',
        'name.required'           => 'Project name is required!',
        'name.min'                => 'Project name must be at least 3 characters!',
        'status.required'         => 'Please select project status!',
        'expected_end_date.after_or_equal' => 'End date must be after start date!',
        'items.*.fitting_type_id.required' => 'Please select a product!',
        'items.*.quantity.required'        => 'Quantity is required!',
        'items.*.quantity.min'             => 'Quantity must be at least 1!',
    ]);

        $project = Project::create([
            'project_code'      => Project::generateCode(),
            'customer_id'       => $request->customer_id,
             'team_leader_id'    => $request->team_leader_id,
            'name'              => $request->name,
            'site_address'      => $request->site_address,
            'site_city'         => $request->site_city,
            'start_date'        => $request->start_date,
            'expected_end_date' => $request->expected_end_date,
            'status'            => $request->status,
            'notes'             => $request->notes,
        ]);

        if($request->filled('items')) {
            foreach($request->items as $item) {
                if(!empty($item['fitting_type_id']) && !empty($item['quantity'])) {
                    $fittingType = FittingType::find($item['fitting_type_id']);
                    ProjectFittingItem::create([
                        'project_id'      => $project->id,
                        'fitting_type_id' => $item['fitting_type_id'],
                        'quantity'        => $item['quantity'],
                        'standard_time'   => $fittingType->standard_time * $item['quantity'],
                        'status'          => 'pending',
                    ]);
                }
            }
        }

        return redirect()
            ->route('admin.projects.show', $project)
            ->with('success', 'Project created successfully!');
    }

    public function show(Project $project)
    {
        $project->load([
            'customer',
            'fittingItems.fittingType',
            'workAssignments.employee',
            'workAssignments.fittingType',
            'workLogs.employee',
            'workLogs.fittingType',
        ]);

        return view('admin.projects.show',
            compact('project'));
    }

    public function edit(Project $project)
    {
        $project->load('fittingItems.fittingType');
        $customers  = Customer::orderBy('name')->get();
        $categories = \App\Models\Category::with('fittingTypes')
            ->get();

        return view('admin.projects.edit',
            compact('project', 'customers', 'categories'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'customer_id'       => 'required|exists:customers,id',
            'name'              => 'required|string|max:255',
            'status'            => 'required',
            'expected_end_date' => 'nullable|date',
        ]);

        $project->update([
            'customer_id'       => $request->customer_id,
            'name'              => $request->name,
            'site_address'      => $request->site_address,
            'site_city'         => $request->site_city,
            'start_date'        => $request->start_date,
            'expected_end_date' => $request->expected_end_date,
            'actual_end_date'   => $request->actual_end_date,
            'status'            => $request->status,
            'notes'             => $request->notes,
        ]);

        return redirect()
            ->route('admin.projects.show', $project)
            ->with('success', 'Project updated!');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project deleted!');
    }

    public function addItem(Request $request, Project $project)
    {
        $request->validate([
            'fitting_type_id' => 'required|exists:fitting_types,id',
            'quantity'        => 'required|integer|min:1',
        ]);

        $fittingType = FittingType::find($request->fitting_type_id);

        ProjectFittingItem::create([
            'project_id'      => $project->id,
            'fitting_type_id' => $request->fitting_type_id,
            'quantity'        => $request->quantity,
            'standard_time'   => $fittingType->standard_time * $request->quantity,
            'status'          => 'pending',
        ]);

        return back()->with('success', 'Item added to project!');
    }

    public function removeItem(Project $project, ProjectFittingItem $item)
    {
        $item->delete();
        return back()->with('success', 'Item removed!');
    }
}