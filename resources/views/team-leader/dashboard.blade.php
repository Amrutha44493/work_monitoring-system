@extends('team-leader.layouts.app')
@section('title', 'Team Dashboard')
@section('subtitle', 'Overview of team today')

@section('content')

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-5 mt-2">
    <div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-sm">
        <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center text-lg mb-2">👷</div>
        <h3 class="text-2xl font-bold text-gray-900">{{ $stats['team_count'] }}</h3>
        <p class="text-gray-400 text-xs">Team Members</p>
    </div>
    <div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-sm">
        <div class="w-9 h-9 bg-green-100 rounded-xl flex items-center justify-center text-lg mb-2">⚡</div>
        <h3 class="text-2xl font-bold text-green-600">{{ $stats['working_now'] }}</h3>
        <p class="text-gray-400 text-xs">Working Now</p>
    </div>
    <div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-sm">
        <div class="w-9 h-9 bg-yellow-100 rounded-xl flex items-center justify-center text-lg mb-2">⏳</div>
        <h3 class="text-2xl font-bold text-yellow-600">{{ $stats['pending_work'] }}</h3>
        <p class="text-gray-400 text-xs">Pending Tasks</p>
    </div>
    <div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-sm">
        <div class="w-9 h-9 bg-orange-100 rounded-xl flex items-center justify-center text-lg mb-2">✅</div>
        <h3 class="text-2xl font-bold text-gray-900">{{ $stats['completed_today'] }}</h3>
        <p class="text-gray-400 text-xs">Done Today</p>
    </div>
  <div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-sm">
    <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center text-lg mb-2">
        📅
    </div>
    <h3 class="text-2xl font-bold text-gray-900">
        {{ \App\Models\WorkLog::whereIn('employee_id', 
            \App\Models\Employee::where('team_leader_id', $tl?->id)
                ->pluck('id')->toArray()
            )->where('status','completed')
            ->whereMonth('updated_at', now()->month)
            ->count() 
        }}
    </h3>
    <p class="text-gray-400 text-xs">Done This Month</p>
</div>
</div>


<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-5">
    @foreach($teamMembers as $member)
        @php $isWorking = $member->workLogs->count() > 0; @endphp
        <div class="bg-white rounded-2xl p-4 border {{ $isWorking ? 'border-green-300' : 'border-gray-200' }} shadow-sm">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold flex-shrink-0
                    {{ $isWorking ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-500' }}">
                    {{ substr($member->name, 0, 1) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $member->name }}</p>
                    <p class="text-xs {{ $isWorking ? 'text-green-600' : 'text-gray-400' }}">
                        {{ $isWorking ? '🟢 Working' : '⚪ Idle' }}
                    </p>
                </div>
            </div>
            @if($isWorking && $member->workLogs->first())
                <p class="text-xs text-green-700 bg-green-100 px-2 py-1 rounded-lg truncate">
                    {{ $member->workLogs->first()->fittingType->name ?? '—' }}
                </p>
            @endif
        </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">

    {{-- Working Now --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between p-4 border-b border-gray-100">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                <h3 class="font-semibold text-gray-900 text-sm">Live Work</h3>
            </div>
            <a href="{{ route('tl.work.index') }}"
               class="text-orange-500 text-xs hover:underline">View All →</a>
        </div>
        @forelse($workingNow as $log)
            @php
                $elapsed  = (int) $log->start_time->diffInMinutes(now());
                $overTime = $elapsed > $log->standard_time;
            @endphp
            <div class="flex items-center gap-3 p-4 border-b border-gray-50">
                <div class="w-9 h-9 bg-green-500 rounded-xl flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                    {{ substr($log->employee->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900">{{ $log->employee->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ $log->fittingType->name }}</p>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="text-xs {{ $overTime ? 'text-red-500 font-bold' : 'text-green-600' }}">
                        {{ $elapsed }}m / {{ $log->standard_time }}m
                    </p>
                    <p class="text-xs text-gray-400">{{ $log->start_time->format('h:i A') }}</p>
                </div>
                <form method="POST" action="{{ route('tl.work.stop', $log) }}">
                    @csrf
                    <button type="submit"
                            class="bg-red-100 text-red-600 hover:bg-red-500 hover:text-white px-2.5 py-1.5 rounded-lg text-xs font-medium transition"
                            onclick="return confirm('Stop work?')">
                        ⏹
                    </button>
                </form>
            </div>
        @empty
            <div class="p-8 text-center">
                <p class="text-2xl mb-1">😴</p>
                <p class="text-gray-400 text-xs">No one working right now</p>
            </div>
        @endforelse
    </div>

    {{-- Pending Work --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between p-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900 text-sm">⏳ Pending Work</h3>
          
        </div>
        @forelse($pendingWork as $assignment)
            <div class="flex items-center gap-3 p-4 border-b border-gray-50">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900">{{ $assignment->employee->name }}</p>
                    <p class="text-xs text-gray-400 truncate">
                        {{ $assignment->fittingType->name }} × {{ $assignment->quantity }}
                        — {{ $assignment->standard_time }}m
                    </p>
                </div>
                <form method="POST" action="{{ route('tl.work.start', $assignment) }}">
                    @csrf
                    <button type="submit"
                            class="bg-green-100 text-green-700 hover:bg-green-500 hover:text-white px-3 py-1.5 rounded-lg text-xs font-medium transition">
                        ▶ Start
                    </button>
                </form>
            </div>
        @empty
            <div class="p-8 text-center">
                <p class="text-2xl mb-1">🎉</p>
                <p class="text-gray-400 text-xs">No pending work!</p>
            </div>
        @endforelse
    </div>

</div>

{{-- Completed Today --}}
@if($completedToday->count() > 0)
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="p-4 border-b border-gray-100">
        <h3 class="font-semibold text-gray-900 text-sm">
            ✅ Completed Today ({{ $completedToday->count() }})
        </h3>
    </div>
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-5 py-2.5 text-left text-xs font-semibold text-gray-500 uppercase">Employee</th>
                <th class="px-5 py-2.5 text-left text-xs font-semibold text-gray-500 uppercase">Product</th>
                <th class="px-5 py-2.5 text-left text-xs font-semibold text-gray-500 uppercase">Standard</th>
                <th class="px-5 py-2.5 text-left text-xs font-semibold text-gray-500 uppercase">Actual</th>
                <th class="px-5 py-2.5 text-left text-xs font-semibold text-gray-500 uppercase">Variance</th>
                <th class="px-5 py-2.5 text-left text-xs font-semibold text-gray-500 uppercase">Efficiency</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($completedToday as $log)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 text-sm font-medium text-gray-900">{{ $log->employee->name }}</td>
                    <td class="px-5 py-3 text-sm text-gray-600">{{ $log->fittingType->name }}</td>
                    <td class="px-5 py-3 text-sm text-gray-500">{{ $log->standard_time }}m</td>
                    <td class="px-5 py-3 text-sm font-medium text-gray-900">{{ $log->actual_time }}m</td>
                    <td class="px-5 py-3 text-sm font-medium {{ $log->variance <= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $log->variance > 0 ? '+' : '' }}{{ $log->variance }}m
                    </td>
                    <td class="px-5 py-3">
                        <span class="text-xs px-2 py-1 rounded-full
                            {{ $log->efficiency >= 100 ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                            {{ $log->efficiency }}%
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@endsection