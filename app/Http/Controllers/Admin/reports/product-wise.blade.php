@extends('admin.layouts.app')
@section('title', 'Product-wise Report')
@section('subtitle', 'Time analysis per product')

@section('content')

{{-- Filter --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 mb-5 mt-2">
    <form method="GET"
          action="{{ route('admin.reports.product-wise') }}"
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

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Product</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Tasks</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Std/Unit</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Total Std</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Total Actual</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Avg Efficiency</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($data as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3.5 text-sm font-medium text-gray-900">{{ $item['name'] }}</td>
                    <td class="px-5 py-3.5 text-sm text-gray-600">{{ $item['count'] }}</td>
                    <td class="px-5 py-3.5 text-sm text-gray-500">{{ $item['standard_time'] }}m</td>
                    <td class="px-5 py-3.5 text-sm text-gray-900">{{ $item['total_standard'] }}m</td>
                    <td class="px-5 py-3.5 text-sm font-medium text-gray-900">{{ $item['total_actual'] }}m</td>
                    <td class="px-5 py-3.5">
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium
                            {{ $item['avg_efficiency'] >= 100 ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                            {{ $item['avg_efficiency'] }}%
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center text-gray-400 text-sm">
                        No data for selected period!
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection