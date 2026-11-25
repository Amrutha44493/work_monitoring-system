<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
      public function index(Request $request)
    {
        $query = Employee::employees() 
            ->with('teamLeader')
            ->latest();

        if($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'LIKE', '%'.$request->search.'%')
                  ->orWhere('employee_code', 'LIKE', '%'.$request->search.'%')
                  ->orWhere('phone', 'LIKE', '%'.$request->search.'%');
            });
        }

        if($request->filled('team_leader_id')) {
            $query->where('team_leader_id', $request->team_leader_id);
        }

        $employees   = $query->paginate(10);
        $teamLeaders = Employee::teamLeaders()->active()->get();

        return view('admin.employees.index',
            compact('employees', 'teamLeaders'));
    }

    public function create()
    {
        $teamLeaders = Employee::teamLeaders()
            ->active()->get();

        return view('admin.employees.create',
            compact('teamLeaders'));
    }

    public function store(Request $request)
    {
      $request->validate([
        'name'           => 'required|string|max:255|min:3',
        'phone'          => 'required|digits_between:10,15|unique:employees,phone',
        'email'          => 'nullable|email|unique:users,email',
        'team_leader_id' => 'nullable|exists:employees,id',
        'joining_date'   => 'nullable|date|before_or_equal:today',
    ], [
        'name.required'          => 'Employee name is required!',
        'name.min'               => 'Name must be at least 3 characters!',
        'phone.required'         => 'Phone number is required!',
        'phone.digits_between'   => 'Phone must be 10-15 digits!',
        'phone.unique'           => 'This phone already registered!',
        'email.email'            => 'Please enter a valid email!',
        'email.unique'           => 'This email already registered!',
        'joining_date.before_or_equal' => 'Joining date cannot be future!',
    ]);
        $userId = null;
        if($request->filled('email')) {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make('password123'),
            ]);
            $user->assignRole('employee');
            $userId = $user->id;
        }

        Employee::create([
            'employee_code'  => Employee::generateCode(),
            'name'           => $request->name,
            'phone'          => $request->phone,
            'email'          => $request->email,
            'role'           => 'employee', // auto!
            'team_leader_id' => $request->team_leader_id,
            'joining_date'   => $request->joining_date,
            'user_id'        => $userId,
            'is_active'      => true,
        ]);

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Employee created!');
    }

    public function edit(Employee $employee)
    {
        $teamLeaders = Employee::teamLeaders()
            ->active()->get();

        return view('admin.employees.edit',
            compact('employee', 'teamLeaders'));
    }

    public function update(Request $request, Employee $employee)
    {
       $request->validate([
        'name'           => 'required|string|max:255',
        'phone'          => 'required|string|max:20|unique:employees,phone,'.$employee->id,
        'team_leader_id' => 'nullable|exists:employees,id',
        'joining_date'   => 'nullable|date',
    ]);

        $employee->update([
            'name'           => $request->name,
            'phone'          => $request->phone,
            'email'   => $request->email,
            'team_leader_id' => $request->team_leader_id,
            'joining_date'   => $request->joining_date,
            'is_active'      => $request->has('is_active'),
        ]);

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Employee updated!');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Employee deleted!');
    }
}
