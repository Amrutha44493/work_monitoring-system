@extends('admin.layouts.app')
@section('title', 'Daily Report')
@section('subtitle', 'Work summary for selected date')

@section('content')

{{-- Date Filter --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 mb-5 mt-2">
    <form method="GET"
          action="{{ route('admin.reports.daily') }}"
          class="flex items-center gap-3">
        <label class="text-sm font-medium text-gray-700">Date:</label>
        <input type="date" name="date"
               value="{{ $date }}"
               class="border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
        <button type="submit"
                class="bg-orange-500 text-white px-4 py-2 rounded-xl text-sm hover:bg-orange-600 transition">
            View
        </button>
    </form>
</div>

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 mb-5">
    <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
        <p class="text-xl font-bold text-gray-900">{{ $summary['total_tasks'] }}</p>
        <p class="text-xs text-gray-400 mt-0.5">Total Tasks</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
        <p class="text-xl font-bold text-green-600">{{ $summary['completed'] }}</p>
        <p class="text-xs text-gray-400 mt-0.5">Completed</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
        <p class="text-xl font-bold text-blue-600">{{ $summary['in_progress'] }}</p>
        <p class="text-xs text-gray-400 mt-0.5">In Progress</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
        <p class="text-xl font-bold text-gray-900">{{ $summary['total_standard'] }}</p>
        <p class="text-xs text-gray-400 mt-0.5">Std Mins</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
        <p class="text-xl font-bold text-gray-900">{{ $summary['total_actual'] }}</p>
        <p class="text-xs text-gray-400 mt-0.5">Actual Mins</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
        <p class="text-xl font-bold {{ $summary['avg_efficiency'] >= 100 ? 'text-green-600' : 'text-orange-500' }}">
            {{ $summary['avg_efficiency'] }}%
        </p>
        <p class="text-xs text-gray-400 mt-0.5">Avg Efficiency</p>
    </div>
</div>

{{-- Detail Table --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Employee</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Product</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Project</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Start</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">End</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Std</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Actual</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Variance</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Eff%</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($logs as $log)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3.5 text-sm font-medium text-gray-900">
                        {{ $log->employee->name }}
                    </td>
                    <td class="px-5 py-3.5 text-sm text-gray-600">
                        {{ $log->fittingType->name }}
                    </td>
                    <td class="px-5 py-3.5 text-sm text-gray-500">
                        {{ $log->project->name ?? '—' }}
                    </td>
                    <td class="px-5 py-3.5 text-sm text-gray-500">
                        {{ $log->start_time?->format('h:i A') }}
                    </td>
                    <td class="px-5 py-3.5 text-sm text-gray-500">
                        {{ $log->end_time?->format('h:i A') ?? '—' }}
                    </td>
                    <td class="px-5 py-3.5 text-sm text-gray-600">
                        {{ $log->standard_time }}m
                    </td>
                    <td class="px-5 py-3.5 text-sm font-medium text-gray-900">
                        {{ $log->actual_time ?? '—' }}{{ $log->actual_time ? 'm' : '' }}
                    </td>
                    <td class="px-5 py-3.5 text-sm font-medium
                        {{ ($log->variance ?? 0) <= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $log->variance !== null ? (($log->variance > 0 ? '+' : '').$log->variance.'m') : '—' }}
                    </td>
                    <td class="px-5 py-3.5">
                        @if($log->efficiency)
                            <span class="text-xs px-2 py-1 rounded-full
                                {{ $log->efficiency >= 100 ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                {{ $log->efficiency }}%
                            </span>
                        @else
                            <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">
                                Running
                            </span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="px-5 py-12 text-center text-gray-400 text-sm">
                        No work recorded for
                        {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection