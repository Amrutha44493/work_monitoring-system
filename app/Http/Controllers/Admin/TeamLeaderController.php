<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Mail\TeamLeaderWelcome;
use Illuminate\Support\Facades\Mail;
class TeamLeaderController extends Controller
{
public function index()
    {
        $teamLeaders = Employee::teamLeaders()
            ->withCount('teamMembers')
            ->latest()
            ->paginate(10);

        return view('admin.team-leaders.index',
            compact('teamLeaders'));
    }

    public function create()
    {
        return view('admin.team-leaders.create');
    }

   public function store(Request $request)
{
     $request->validate([
        'name'         => 'required|string|max:255|min:3',
        'phone'        => 'required|digits_between:10,15|unique:employees,phone',
        'email'        => 'required|email|unique:users,email',
        'joining_date' => 'nullable|date|before_or_equal:today',
    ], [
        'name.required'      => 'Supervisor name is required!',
        'name.min'           => 'Name must be at least 3 characters!',
        'phone.required'     => 'Phone number is required!',
        'phone.digits_between' => 'Phone must be 10-15 digits!',
        'phone.unique'       => 'This phone number already exists!',
        'email.required'     => 'Email is required for login!',
        'email.email'        => 'Please enter a valid email address!',
        'email.unique'       => 'This email already registered!',
        'joining_date.before_or_equal' => 'Joining date cannot be future date!',
    ]);

    $password = 'password123';
    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($password),
    ]);
    $user->assignRole('team_leader');
    $employee = Employee::create([
        'employee_code'  => Employee::generateCode(),
        'name'           => $request->name,
        'phone'          => $request->phone,
        'email'          => $request->email,
        'role'           => 'team_leader',
        'team_leader_id' => null,
        'joining_date'   => $request->joining_date,
        'user_id'        => $user->id,
        'is_active'      => true,
    ]);

    // Send welcome email!
    try {
        Mail::to($request->email)
            ->queue(new TeamLeaderWelcome($employee, $password));

        return redirect()
            ->route('admin.team-leaders.index')
            ->with('success',
                'Supervisor created! Welcome email sent to '.$request->email);

    } catch(\Exception $e) {
        return redirect()
            ->route('admin.team-leaders.index')
            ->with('success',
                'Team Leader created! (Email could not be sent — '.
                $e->getMessage().')');
    }
}
    public function edit(Employee $teamLeader)
    {
        return view('admin.team-leaders.edit',
            compact('teamLeader'));
    }

    public function update(Request $request, Employee $teamLeader)
    {
         $request->validate([
        'name'         => 'required|string|max:255|min:3',
        'phone'        => 'required|digits_between:10,15|unique:employees,phone,'.$teamLeader->id,
        'joining_date' => 'nullable|date|before_or_equal:today',
    ], [
        'name.required'        => 'Supervisor name is required!',
        'name.min'             => 'Name must be at least 3 characters!',
        'phone.required'       => 'Phone number is required!',
        'phone.digits_between' => 'Phone must be 10-15 digits!',
        'phone.unique'         => 'This phone number already exists!',
        'joining_date.before_or_equal' => 'Joining date cannot be future date!',
    ]);

        $teamLeader->update([
            'name'         => $request->name,
            'phone'        => $request->phone,
            'joining_date' => $request->joining_date,
            'is_active'    => $request->has('is_active'),
        ]);

        return redirect()
            ->route('admin.team-leaders.index')
            ->with('success', 'Supervisor updated!');
    }

    public function destroy(Employee $teamLeader)
    {
        $teamLeader->delete();
        return redirect()
            ->route('admin.team-leaders.index')
            ->with('success', 'Supervisor deleted!');
    }
}
