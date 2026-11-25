@extends('admin.layouts.app')
@section('title', 'Standard vs Actual')
@section('subtitle', 'Compare planned vs actual work time')

@section('content')

@php
    $waText =
        "Standard vs Actual Report\n" .
        "Period: " . $startDate . " to " . $endDate . "\n\n" .
        "Total Standard: " . $summary['total_standard'] . " mins\n" .
        "Total Actual: " . $summary['total_actual'] . " mins\n" .
        "Total Variance: " . $summary['total_variance'] . " mins\n" .
        "Avg Efficiency: " . $summary['avg_efficiency'] . "%\n" .
        "On Time/Fast: " . $summary['on_time'] . "\n" .
        "Delayed: " . $summary['delayed'] . "\n\n" .
        "Sent from Kitchen Work Tracker";
@endphp

{{-- Filter + Actions --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 mb-5 mt-2">
    <div class="flex items-center justify-between flex-wrap gap-3">
        <form method="GET"
              action="{{ route('admin.reports.standard-vs-actual') }}"
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
        <div class="flex items-center gap-2 no-print">
            <a href="{{ route('admin.reports.standard-vs-actual') }}?start_date={{ $startDate }}&end_date={{ $endDate }}&export=pdf"
               class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
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

{{-- Summary --}}
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 mb-5">
    <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
        <p class="text-xl font-bold">{{ $summary['total_standard'] }}</p>
        <p class="text-xs text-gray-400">Std Mins</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
        <p class="text-xl font-bold">{{ $summary['total_actual'] }}</p>
        <p class="text-xs text-gray-400">Actual Mins</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
        <p class="text-xl font-bold {{ $summary['total_variance'] <= 0 ? 'text-green-600' : 'text-red-600' }}">
            {{ $summary['total_variance'] > 0 ? '+' : '' }}{{ $summary['total_variance'] }}m
        </p>
        <p class="text-xs text-gray-400">Variance</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
        <p class="text-xl font-bold {{ $summary['avg_efficiency'] >= 100 ? 'text-green-600' : 'text-orange-500' }}">
            {{ $summary['avg_efficiency'] }}%
        </p>
        <p class="text-xs text-gray-400">Avg Eff</p>
    </div>
    <div class="bg-green-50 rounded-xl border border-green-200 p-4 text-center">
        <p class="text-xl font-bold text-green-600">{{ $summary['on_time'] }}</p>
        <p class="text-xs text-gray-400">Fast/OnTime</p>
    </div>
    <div class="bg-red-50 rounded-xl border border-red-200 p-4 text-center">
        <p class="text-xl font-bold text-red-600">{{ $summary['delayed'] }}</p>
        <p class="text-xs text-gray-400">Delayed</p>
    </div>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Employee</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Product</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Standard</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Actual</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Variance</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Result</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($logs as $log)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3.5 text-sm font-medium text-gray-900">{{ $log->employee->name }}</td>
                    <td class="px-5 py-3.5 text-sm text-gray-600">{{ $log->fittingType->name }}</td>
                    <td class="px-5 py-3.5 text-sm text-gray-500">{{ $log->start_time?->format('d M Y') }}</td>
                    <td class="px-5 py-3.5 text-sm text-gray-600">{{ $log->standard_time }}m</td>
                    <td class="px-5 py-3.5 text-sm font-medium text-gray-900">{{ $log->actual_time }}m</td>
                    <td class="px-5 py-3.5 text-sm font-medium {{ $log->variance <= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $log->variance > 0 ? '+' : '' }}{{ $log->variance }}m
                    </td>
                    <td class="px-5 py-3.5">
                        @if($log->variance <= 0)
                            <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">✅ Fast</span>
                        @else
                            <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded-full">⚠️ Slow</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-5 py-12 text-center text-gray-400">No data!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<style>@media print { aside, header, .no-print { display: none !important; } }</style>

@endsection