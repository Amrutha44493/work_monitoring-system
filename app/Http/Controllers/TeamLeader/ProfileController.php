<?php

namespace App\Http\Controllers\TeamLeader;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    private function getTL()
    {
        return Employee::where('user_id', auth()->id())
            ->first();
    }

    public function index()
    {
        $tl   = $this->getTL();
        $user = auth()->user();

        return view('team-leader.profile',
            compact('tl', 'user'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => [
                'required',
                function($attr, $value, $fail) {
                    if(!Hash::check($value, auth()->user()->password)) {
                        $fail('Current password is incorrect!');
                    }
                }
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(6),
            ],
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success',
            'Password changed successfully!');
    }
}