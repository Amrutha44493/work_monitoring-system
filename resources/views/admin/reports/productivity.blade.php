@extends('admin.layouts.app')
@section('title', 'Productivity Report')
@section('subtitle', 'Employee ranking by time saved')

@section('content')

@php
    $totalSaved = $employees->sum('time_saved');
    $totalTasks = $employees->sum('tasks_completed');
    $waText =
        "Productivity Report\n" .
        "Period: " . $startDate . " to " . $endDate . "\n\n" .
        "Total Employees: " . $employees->count() . "\n" .
        "Total Tasks: " . $totalTasks . "\n" .
        "Total Time Saved: " . $totalSaved . " mins\n\n" .
        "Top Performer: " . ($employees->first()?->name ?? 'N/A') . "\n" .
        "Tasks: " . ($employees->first()?->tasks_completed ?? 0) . "\n" .
        "Time Saved: " . ($employees->first()?->time_saved ?? 0) . " mins\n\n" .
        "Sent from Kitchen Work Tracker";
@endphp

{{-- Filter + Actions --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 mb-5 mt-2">
    <div class="flex items-center justify-between flex-wrap gap-3">
        <form method="GET"
              action="{{ route('admin.reports.productivity') }}"
              class="flex items-center gap-3 flex-wrap">
            <div class="flex items-center gap-2">
                <label class="text-sm text-gray-600">From:</label>
                <input type="date" name="start_date"
                       value="{{ $startDate }}"
                       class="border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>
            <div class="flex items-center gap-2">
                <label class="text-sm text-gray-600">To:</label>
                <input type="date" name="end_date"
                       value="{{ $endDate }}"
                       class="border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>
            <button type="submit"
                    class="bg-orange-500 text-white px-4 py-2 rounded-xl text-sm hover:bg-orange-600 transition">
                Filter
            </button>
        </form>

        {{-- PDF + WhatsApp --}}
        <div class="flex items-center gap-2 no-print">
            <a href="{{ route('admin.reports.productivity') }}?start_date={{ $startDate }}&end_date={{ $endDate }}&export=pdf"
               class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                PDF
            </a>
            <a href="https://wa.me/?text={{ rawurlencode($waText) }}"
               target="_blank"
               class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                WhatsApp
            </a>
        </div>
    </div>
</div>

{{-- Summary Cards --}}
<div class="grid grid-cols-3 gap-3 mb-5">
    <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
        <p class="text-2xl font-bold text-gray-900">{{ $employees->count() }}</p>
        <p class="text-xs text-gray-400 mt-0.5">Employees</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
        <p class="text-2xl font-bold text-orange-600">{{ $totalTasks }}</p>
        <p class="text-xs text-gray-400 mt-0.5">Total Tasks</p>
    </div>
    <div class="bg-{{ $totalSaved >= 0 ? 'green' : 'red' }}-50 rounded-xl border border-{{ $totalSaved >= 0 ? 'green' : 'red' }}-200 p-4 text-center">
        <p class="text-2xl font-bold text-{{ $totalSaved >= 0 ? 'green' : 'red' }}-600">
            {{ $totalSaved >= 0 ? '+' : '' }}{{ $totalSaved }}m
        </p>
        <p class="text-xs text-gray-400 mt-0.5">Total Time Saved</p>
    </div>
</div>

{{-- Leaderboard --}}
<div class="space-y-3">
    @forelse($employees as $i => $emp)
        <div class="bg-white rounded-2xl border
            {{ $i === 0 ? 'border-yellow-300 shadow-md' : 'border-gray-200 shadow-sm' }}
            p-5">
            <div class="flex items-center gap-4">

             

                {{-- Avatar --}}
                <div class="w-11 h-11 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center font-bold text-lg flex-shrink-0">
                    {{ substr($emp->name, 0, 1) }}
                </div>

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-900">{{ $emp->name }}</p>
                    <div class="flex items-center gap-3 mt-0.5">
                        <span class="text-xs text-gray-400">
                            {{ $emp->tasks_completed }} tasks
                        </span>
                        <span class="text-xs text-gray-300">•</span>
                        <span class="text-xs text-gray-400">
                            Std: {{ $emp->standard_time }}m
                        </span>
                        <span class="text-xs text-gray-300">•</span>
                        <span class="text-xs text-gray-400">
                            Actual: {{ $emp->actual_time }}m
                        </span>
                    </div>
                </div>

                {{-- Time Saved -- Main Metric! --}}
                <div class="text-right flex-shrink-0">
                    @if($emp->time_saved >= 0)
                        <p class="text-2xl font-bold text-green-600">
                            +{{ $emp->time_saved }}m
                        </p>
                    @else
                        <p class="text-2xl font-bold text-red-500">
                            {{ $emp->time_saved }}m
                        </p>
                        <p class="text-xs text-red-400">Extra Time ⚠️</p>
                    @endif
                </div>

                {{-- Tasks Badge --}}
                <div class="text-center flex-shrink-0 px-3 py-2 bg-orange-50 border border-orange-200 rounded-xl">
                    <p class="text-xl font-bold text-orange-600">
                        {{ $emp->tasks_completed }}
                    </p>
                    <p class="text-xs text-gray-400">Tasks</p>
                </div>

            </div>

            {{-- Progress Bar based on time saved --}}
            @php
                $maxSaved = $employees->first()->time_saved ?? 1;
                $barWidth = $maxSaved > 0
                    ? min(abs($emp->time_saved / max($maxSaved, 1)) * 100, 100)
                    : 0;
            @endphp
            <div class="mt-3 h-2 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full rounded-full {{ $emp->time_saved >= 0 ? 'bg-green-500' : 'bg-red-400' }}"
                     style="width: {{ $barWidth }}%">
                </div>
            </div>

        </div>
    @empty
        <div class="bg-white rounded-2xl border border-gray-200 p-16 text-center">
            <p class="text-4xl mb-3">📊</p>
            <p class="text-gray-400">No data for selected period!</p>
        </div>
    @endforelse
</div>

<style>
@media print {
    aside, header, form, .no-print { display: none !important; }
    body { background: white !important; }
}
</style>

@endsection