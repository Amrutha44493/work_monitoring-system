@extends('admin.layouts.app')
@section('title', 'Completed Work')
@section('subtitle', 'All completed work records')

@section('content')

{{-- Filter --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 mb-5 mt-2">
    <form method="GET"
          action="{{ route('admin.reports.completed') }}"
          class="flex items-center gap-3 flex-wrap">
        <div class="flex items-center gap-2">
            <label class="text-sm text-gray-600">From:</label>
            <input type="date" name="start_date" value="{{ $startDate }}"
                   class="border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div class="flex items-center gap-2">
            <label class="text-sm text-gray-600">To:</label>
            <input type="date" name="end_date" value="{{ $endDate }}"
                   class="border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <button type="submit"
                class="bg-orange-500 text-white px-4 py-2 rounded-xl text-sm hover:bg-orange-600 transition">
            Filter
        </button>
    </form>
</div>

<div class="mb-3">
    <p class="text-sm text-gray-500">{{ $logs->count() }} completed tasks</p>
</div>

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Employee</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Product</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Project</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Std</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Actual</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Efficiency</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($logs as $log)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3.5 text-sm font-medium text-gray-900">{{ $log->employee->name }}</td>
                    <td class="px-5 py-3.5 text-sm text-gray-600">{{ $log->fittingType->name }}</td>
                    <td class="px-5 py-3.5 text-sm text-gray-500">{{ $log->project->name ?? '—' }}</td>
                    <td class="px-5 py-3.5 text-sm text-gray-500">
                        {{ $log->start_time?->format('d M Y') }}
                    </td>
                    <td class="px-5 py-3.5 text-sm text-gray-600">{{ $log->standard_time }}m</td>
                    <td class="px-5 py-3.5 text-sm font-medium text-gray-900">{{ $log->actual_time }}m</td>
                    <td class="px-5 py-3.5">
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium
                            {{ $log->efficiency >= 100 ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                            {{ $log->efficiency }}%
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-5 py-12 text-center text-gray-400 text-sm">
                        No completed work for selected period!
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection