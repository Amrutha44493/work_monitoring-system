@extends('team-leader.layouts.app')
@section('title', 'Work Status')
@section('subtitle', 'Start, stop and monitor work')

@section('content')

{{-- Currently Working --}}
<div class="mb-5 mt-2">
    <div class="flex items-center gap-2 mb-3">
        <span class="w-2.5 h-2.5 bg-green-500 rounded-full animate-pulse"></span>
        <h3 class="font-semibold text-gray-900">
            Working Now ({{ $workingNow->count() }})
        </h3>
    </div>

    @if($workingNow->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($workingNow as $log)
                @php
                    $elapsed  = (int) $log->start_time->diffInMinutes(now());
                    $progress = min(($elapsed / max($log->standard_time, 1)) * 100, 100);
                    $overTime = $elapsed > $log->standard_time;
                @endphp
                <div class="bg-white rounded-2xl border {{ $overTime ? 'border-red-300' : 'border-green-300' }} shadow-sm p-5">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center text-white font-bold flex-shrink-0">
                                {{ substr($log->employee->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">
                                    {{ $log->employee->name }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $log->fittingType->name }}
                                </p>
                                <p class="text-xs text-gray-400">
                                    {{ $log->project->name ?? '—' }}
                                </p>
                            </div>
                        </div>
                        <form method="POST"
                              action="{{ route('tl.work.stop', $log) }}">
                            @csrf
                            <button type="submit"
                                    class="bg-red-500 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-red-600 transition"
                                    onclick="return confirm('Stop work for {{ $log->employee->name }}?')">
                                ⏹ Stop
                            </button>
                        </form>
                    </div>

                    {{-- Time info --}}
                    <div class="grid grid-cols-3 gap-2 mb-3 text-center text-xs">
                        <div class="bg-gray-50 rounded-lg p-2">
                            <p class="font-bold text-gray-900">{{ $log->start_time->format('h:i A') }}</p>
                            <p class="text-gray-400">Started</p>
                        </div>
                        
                        <div class="bg-blue-50 rounded-lg p-2">
                            <p class="font-bold text-blue-600">{{ $log->standard_time }}m</p>
                            <p class="text-gray-400">Standard</p>
                        </div>
                    </div>

                    {{-- Progress --}}
                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full {{ $overTime ? 'bg-red-500' : 'bg-green-500' }}"
                             style="width: {{ $progress }}%">
                        </div>
                    </div>
                    @if($overTime)
                        <p class="text-red-500 text-xs mt-1 text-center">
                            ⚠️ Over by {{ $elapsed - $log->standard_time }} mins!
                        </p>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-2xl border border-gray-200 p-10 text-center">
            <p class="text-3xl mb-2">😴</p>
            <p class="text-gray-400 text-sm">No one working right now!</p>
        </div>
    @endif
</div>

{{-- Pending --}}
<div class="mb-5">
    <div class="flex items-center justify-between mb-3">
        <h3 class="font-semibold text-gray-900">
            ⏳ Pending ({{ $pendingAssignments->count() }})
        </h3>
    </div>
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Employee</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Product</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Project</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Std Time</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pendingAssignments as $a)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3.5 text-sm font-medium text-gray-900">{{ $a->employee->name }}</td>
                        <td class="px-5 py-3.5 text-sm text-gray-600">{{ $a->fittingType->name }}</td>
                        <td class="px-5 py-3.5 text-sm text-gray-500">{{ $a->project->name ?? '—' }}</td>
                        <td class="px-5 py-3.5 text-sm font-medium text-gray-900">{{ $a->standard_time }}m</td>
                        <td class="px-5 py-3.5 text-sm text-gray-500">{{ $a->assigned_date->format('d M') }}</td>
                        <td class="px-5 py-3.5">
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('tl.work.start', $a) }}">
                                    @csrf
                                    <button type="submit"
                                            class="bg-green-100 text-green-700 hover:bg-green-500 hover:text-white px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                        ▶ Start
                                    </button>
                                </form>
                                <form method="POST"
                                      action="{{ route('tl.assign.destroy', $a) }}"
                                      onsubmit="return confirm('Remove?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-gray-100 text-gray-500 hover:bg-red-100 hover:text-red-600 px-3 py-1.5 rounded-lg text-xs transition">
                                        ✕
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-gray-400 text-sm">
                            No pending assignments!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Completed Today --}}
@if($completedToday->count() > 0)
<div>
    <h3 class="font-semibold text-gray-900 mb-3">
        ✅ Completed Today ({{ $completedToday->count() }})
    </h3>
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Employee</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Product</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Std</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Actual</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Variance</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Eff%</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($completedToday as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 text-sm font-medium text-gray-900">{{ $log->employee->name }}</td>
                        <td class="px-5 py-3 text-sm text-gray-600">{{ $log->fittingType->name }}</td>
                        <td class="px-5 py-3 text-sm text-gray-500">{{ $log->standard_time }}m</td>
                        <td class="px-5 py-3 text-sm font-medium">{{ $log->actual_time }}m</td>
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
</div>
@endif

@endsection