<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')
        ->whereHas('roles', function($q) {
            $q->whereIn('name', ['admin', 'team_leader']);
        })
        ->latest()
        ->paginate(10);

    return view('admin.users.index',
        compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit',
            compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user->syncRoles([$request->role]);
        if($request->filled('password')) {
            $request->validate([
                'password' => 'min:6|confirmed',
            ]);
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated!');
    }

    public function destroy(User $user)
    {
        if($user->id === auth()->id()) {
            return back()->with('error',
                'Cannot delete yourself!');
        }
        $user->delete();
        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted!');
    }
}