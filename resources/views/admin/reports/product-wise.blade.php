@extends('admin.layouts.app')
@section('title', 'Product-wise Report')
@section('subtitle', 'Time taken')

@section('content')

{{-- Filter + Export --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 mb-5 mt-2">
    <div class="flex items-center justify-between flex-wrap gap-3">
        <form method="GET"
              action="{{ route('admin.reports.product-wise') }}"
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
{{-- After filter form, add: --}}
@php
    $waText =
        "Product-wise Report\n" .
        "Period: " . $startDate . " to " . $endDate . "\n\n" .
        "Total Products: " . count($data) . "\n" .
        "Total Tasks: " . collect($data)->sum('count') . "\n" .
        "Total Std: " . collect($data)->sum('total_standard') . " mins\n" .
        "Total Actual: " . collect($data)->sum('total_actual') . " mins\n\n" .
        "From: Kitchen Work Tracker";
@endphp

<x-report-actions
    :pdfUrl="route('admin.reports.product-wise') . '?start_date=' . $startDate . '&end_date=' . $endDate . '&export=pdf'"
    :whatsappText="$waText"
/>
</div>
</div>
{{-- Summary Cards --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-5">
    <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
        <p class="text-2xl font-bold text-gray-900">{{ count($data) }}</p>
        <p class="text-xs text-gray-400 mt-0.5">Products</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
        <p class="text-2xl font-bold text-orange-600">
            {{ collect($data)->sum('count') }}
        </p>
        <p class="text-xs text-gray-400 mt-0.5">Total Tasks</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
        <p class="text-2xl font-bold text-blue-600">
            {{ collect($data)->sum('total_standard') }}m
        </p>
        <p class="text-xs text-gray-400 mt-0.5">Total Std Time</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
        <p class="text-2xl font-bold text-green-600">
            {{ collect($data)->sum('total_actual') }}m
        </p>
        <p class="text-xs text-gray-400 mt-0.5">Total Actual</p>
    </div>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">#</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Product</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Tasks</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Std/Unit</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Total Std</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Total Actual</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Variance</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Avg Eff%</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($data as $i => $item)
                @php $variance = $item['total_actual'] - $item['total_standard']; @endphp
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3.5 text-sm text-gray-400">{{ $i + 1 }}</td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center font-bold text-xs">
                                {{ substr($item['name'], 0, 1) }}
                            </div>
                            <p class="text-sm font-medium text-gray-900">{{ $item['name'] }}</p>
                        </div>
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="bg-blue-50 text-blue-700 text-xs px-2.5 py-1 rounded-full">
                            {{ $item['count'] }} tasks
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-sm text-gray-500">{{ $item['standard_time'] }}m</td>
                    <td class="px-5 py-3.5 text-sm font-medium text-gray-900">{{ $item['total_standard'] }}m</td>
                    <td class="px-5 py-3.5 text-sm font-medium text-gray-900">{{ $item['total_actual'] }}m</td>
                    <td class="px-5 py-3.5 text-sm font-medium {{ $variance <= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $variance > 0 ? '+' : '' }}{{ $variance }}m
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="text-xs px-2 py-1 rounded-full
                            {{ $item['avg_efficiency'] >= 100 ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                            {{ $item['avg_efficiency'] }}%
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-5 py-16 text-center">
                        <p class="text-4xl mb-2">📦</p>
                        <p class="text-gray-400 text-sm">No data for selected period!</p>
                    </td>
                </tr>
            @endforelse
        </tbody>

        @if(count($data) > 0)
        <tfoot class="bg-gray-50 border-t-2 border-gray-200">
            <tr>
                <td colspan="2" class="px-5 py-3 text-sm font-bold text-gray-900">TOTAL</td>
                <td class="px-5 py-3">
                    <span class="bg-blue-100 text-blue-800 text-xs px-2.5 py-1 rounded-full font-bold">
                        {{ collect($data)->sum('count') }} tasks
                    </span>
                </td>
                <td class="px-5 py-3 text-sm text-gray-400">—</td>
                <td class="px-5 py-3 text-sm font-bold">{{ collect($data)->sum('total_standard') }}m</td>
                <td class="px-5 py-3 text-sm font-bold">{{ collect($data)->sum('total_actual') }}m</td>
                <td class="px-5 py-3 text-sm font-bold
                    {{ (collect($data)->sum('total_actual') - collect($data)->sum('total_standard')) <= 0 ? 'text-green-600' : 'text-red-600' }}">
                    @php $tv = collect($data)->sum('total_actual') - collect($data)->sum('total_standard'); @endphp
                    {{ $tv > 0 ? '+' : '' }}{{ $tv }}m
                </td>
                <td class="px-5 py-3">
                    <span class="text-xs px-2 py-1 rounded-full bg-orange-100 text-orange-700">
                        {{ round(collect($data)->avg('avg_efficiency'), 1) }}%
                    </span>
                </td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>

<style>
@media print {
    aside, header, form, .no-print { display: none !important; }
    body, main { background: white !important; padding: 0 !important; }
    table { font-size: 11px !important; }
}
</style>

@endsection