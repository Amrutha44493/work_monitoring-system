@extends('admin.layouts.app')
@section('title', 'Add Employee')
@section('subtitle', 'Create new employee ')

@section('content')

<div class="mb-5 mt-2">
    <a href="{{ route('admin.employees.index') }}"
       class="text-gray-500 hover:text-orange-500 text-sm">← Back</a>
</div>

<div class="max-w-xl">
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">

        <h3 class="text-base font-semibold text-gray-900 mb-5 pb-4 border-b border-gray-100">
            Employee Details
        </h3>

        <form method="POST" action="{{ route('admin.employees.store') }}">
        @csrf

            {{-- Name --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name"
                       value="{{ old('name') }}"
                       placeholder="Employee full name"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('name') border-red-400 @enderror">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Phone --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Phone <span class="text-red-500">*</span>
                </label>
                <input type="text" name="phone"
                       value="{{ old('phone') }}"
                       placeholder="+91 984562315789"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('phone') border-red-400 @enderror">
                @error('phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Email
                  
                </label>
                <input type="email" name="email"
                       value="{{ old('email') }}"
                       placeholder="employee@email.com"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Assign to Supervisor
                </label>
                <select name="team_leader_id"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                    <option value="">Select Supervisor</option>
                    @foreach($teamLeaders as $tl)
                        <option value="{{ $tl->id }}"
                            {{ old('team_leader_id') == $tl->id ? 'selected' : '' }}>
                            {{ $tl->name }}
                            ({{ $tl->employee_code }})
                        </option>
                    @endforeach
                </select>
                @if($teamLeaders->isEmpty())
                    <p class="text-orange-500 text-xs mt-1">
                        ⚠️ No Supervisor found!
                        <a href="{{ route('admin.team-leaders.create') }}"
                           class="underline">Create one first →</a>
                    </p>
                @endif
            </div>

            {{-- Joining Date --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Joining Date
                </label>
                <input type="date" name="joining_date"
                       value="{{ old('joining_date') }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>        

            <div class="flex gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="bg-orange-500 text-white px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-orange-600 transition">
                    Create 
                </button>
                <a href="{{ route('admin.employees.index') }}"
                   class="text-gray-500 text-sm self-center">Cancel</a>
            </div>

        </form>
    </div>
</div>

@endsection