@extends('team-leader.layouts.app')
@section('title', 'My Profile')
@section('subtitle', 'View and update your account')

@section('content')

<div class="max-w-2xl mt-2">

    {{-- Profile Card --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-5">

        {{-- Header --}}
        <div class="flex items-center gap-4 mb-6 pb-5 border-b border-gray-100">
            <div class="w-16 h-16 bg-orange-500 rounded-2xl flex items-center justify-center text-white font-bold text-2xl flex-shrink-0">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">
                    {{ $user->name }}
                </h2>
                <p class="text-gray-500 text-sm">{{ $user->email }}</p>
                <span class="inline-flex items-center gap-1.5 bg-purple-100 text-purple-700 text-xs px-2.5 py-1 rounded-full mt-1">
                    👑 Team Leader
                </span>
            </div>
        </div>

        {{-- Employee Info --}}
        @if($tl)
        <div class="grid grid-cols-2 gap-4 mb-2">
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs text-gray-400 mb-1">Employee Code</p>
                <p class="font-mono font-semibold text-gray-900">
                    {{ $tl->employee_code }}
                </p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs text-gray-400 mb-1">Phone</p>
                <p class="font-semibold text-gray-900">
                    {{ $tl->phone ?? '—' }}
                </p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs text-gray-400 mb-1">Joining Date</p>
                <p class="font-semibold text-gray-900">
                    {{ $tl->joining_date?->format('d M Y') ?? '—' }}
                </p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs text-gray-400 mb-1">Status</p>
                <span class="inline-flex items-center gap-1.5 text-sm font-semibold
                    {{ $tl->is_active ? 'text-green-600' : 'text-red-500' }}">
                    {{ $tl->is_active ? '✅ Active' : '❌ Inactive' }}
                </span>
            </div>
        </div>
        @endif

    </div>

    {{-- Change Password Card --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">

        <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-100">
            <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center text-xl">
                🔐
            </div>
            <div>
                <h3 class="font-semibold text-gray-900">Change Password</h3>
               
            </div>
        </div>

        {{-- Success --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-5 text-sm flex items-center gap-2">
                <span>✅</span> {{ session('success') }}
            </div>
        @endif

        {{-- Error --}}
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-5">
                @foreach($errors->all() as $error)
                    <p class="text-red-500 text-sm flex items-center gap-1.5">
                        <span>❌</span> {{ $error }}
                    </p>
                @endforeach
            </div>
        @endif

        <form method="POST"
              action="{{ route('tl.profile.password') }}">
        @csrf

            {{-- Current Password --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Current Password
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="password"
                           name="current_password"
                           id="currentPass"
                           placeholder="Enter current password"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 pr-11 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('current_password') border-red-400 @enderror">
                    <button type="button"
                            onclick="togglePass('currentPass', 'eyeIcon1')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <span id="eyeIcon1">👁️</span>
                    </button>
                </div>
                @error('current_password')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                        ⚠️ {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- New Password --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    New Password
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="password"
                           name="password"
                           id="newPass"
                           placeholder="Min 6 characters"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 pr-11 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('password') border-red-400 @enderror">
                    <button type="button"
                            onclick="togglePass('newPass', 'eyeIcon2')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <span id="eyeIcon2">👁️</span>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                        ⚠️ {{ $message }}
                    </p>
                @enderror

                {{-- Password Strength --}}
                <div class="mt-2" id="strengthBox" style="display:none">
                    <div class="flex items-center gap-2">
                        <div class="flex-1 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                            <div id="strengthBar"
                                 class="h-full rounded-full transition-all duration-300"
                                 style="width: 0%">
                            </div>
                        </div>
                        <span id="strengthText"
                              class="text-xs font-medium w-12">
                        </span>
                    </div>
                </div>
            </div>

            {{-- Confirm Password --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Confirm New Password
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="password"
                           name="password_confirmation"
                           id="confirmPass"
                           placeholder="Repeat new password"
                           onkeyup="checkMatch()"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 pr-11 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                    <button type="button"
                            onclick="togglePass('confirmPass', 'eyeIcon3')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <span id="eyeIcon3">👁️</span>
                    </button>
                </div>
                <p id="matchMsg" class="text-xs mt-1.5 hidden"></p>
            </div>

    

            <div class="flex gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="bg-orange-500 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-orange-600 transition active:scale-95">
                    🔐 Update Password
                </button>
                <a href="{{ route('tl.dashboard') }}"
                   class="text-gray-500 text-sm self-center hover:text-gray-700">
                    Cancel
                </a>
            </div>

        </form>
    </div>

</div>

{{-- JavaScript --}}
<script>
    // Toggle password visibility
    function togglePass(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if(input.type === 'password') {
            input.type = 'text';
            icon.textContent = '🙈';
        } else {
            input.type = 'password';
            icon.textContent = '👁️';
        }
    }

    // Password strength checker
    document.getElementById('newPass')
        .addEventListener('input', function() {
        const val      = this.value;
        const bar      = document.getElementById('strengthBar');
        const text     = document.getElementById('strengthText');
        const box      = document.getElementById('strengthBox');

        if(val.length === 0) {
            box.style.display = 'none';
            return;
        }

        box.style.display = 'block';

        let strength = 0;
        if(val.length >= 6)  strength++;
        if(val.length >= 10) strength++;
        if(/[A-Z]/.test(val)) strength++;
        if(/[0-9]/.test(val)) strength++;
        if(/[^A-Za-z0-9]/.test(val)) strength++;

        const levels = [
            { width: '20%', color: 'bg-red-500',    label: 'Weak',   textColor: 'text-red-500' },
            { width: '40%', color: 'bg-orange-500', label: 'Fair',   textColor: 'text-orange-500' },
            { width: '60%', color: 'bg-yellow-500', label: 'Good',   textColor: 'text-yellow-600' },
            { width: '80%', color: 'bg-blue-500',   label: 'Strong', textColor: 'text-blue-600' },
            { width: '100%',color: 'bg-green-500',  label: 'Great!', textColor: 'text-green-600' },
        ];

        const level = levels[Math.min(strength - 1, 4)] || levels[0];
        bar.style.width  = level.width;
        bar.className    = `h-full rounded-full transition-all duration-300 ${level.color}`;
        text.textContent = level.label;
        text.className   = `text-xs font-medium w-12 ${level.textColor}`;
    });

    // Password match checker
    function checkMatch() {
        const newPass     = document.getElementById('newPass').value;
        const confirmPass = document.getElementById('confirmPass').value;
        const msg         = document.getElementById('matchMsg');

        if(confirmPass.length === 0) {
            msg.classList.add('hidden');
            return;
        }

        msg.classList.remove('hidden');

        if(newPass === confirmPass) {
            msg.textContent = '✅ Passwords match!';
            msg.className   = 'text-xs mt-1.5 text-green-600';
        } else {
            msg.textContent = '❌ Passwords do not match!';
            msg.className   = 'text-xs mt-1.5 text-red-500';
        }
    }
</script>

@endsection