@extends('admin.layouts.app')
@section('title', 'Standard vs Actual')
@section('subtitle', 'Compare standard and actual times')

@section('content')

{{-- Filter --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 mb-5 mt-2">
    <form method="GET"
          action="{{ route('admin.reports.standard-vs-actual') }}"
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

{{-- Summary --}}
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 mb-5">
    <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
        <p class="text-xl font-bold text-gray-900">{{ $summary['total_standard'] }}</p>
        <p class="text-xs text-gray-400">Std Mins</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
        <p class="text-xl font-bold text-gray-900">{{ $summary['total_actual'] }}</p>
        <p class="text-xs text-gray-400">Actual Mins</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
        <p class="text-xl font-bold {{ $summary['total_variance'] <= 0 ? 'text-green-600' : 'text-red-600' }}">
            {{ $summary['total_variance'] > 0 ? '+' : '' }}{{ $summary['total_variance'] }}
        </p>
        <p class="text-xs text-gray-400">Variance</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
        <p class="text-xl font-bold {{ $summary['avg_efficiency'] >= 100 ? 'text-green-600' : 'text-orange-500' }}">
            {{ $summary['avg_efficiency'] }}%
        </p>
        <p class="text-xs text-gray-400">Avg Efficiency</p>
    </div>
    <div class="bg-green-50 rounded-xl border border-green-200 p-4 text-center">
        <p class="text-xl font-bold text-green-600">{{ $summary['on_time'] }}</p>
        <p class="text-xs text-gray-400">On Time/Fast</p>
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
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Eff%</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Result</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($logs as $log)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3.5 text-sm font-medium text-gray-900">{{ $log->employee->name }}</td>
                    <td class="px-5 py-3.5 text-sm text-gray-600">{{ $log->fittingType->name }}</td>
                    <td class="px-5 py-3.5 text-sm text-gray-500">
                        {{ $log->start_time?->format('d M Y') }}
                    </td>
                    <td class="px-5 py-3.5 text-sm text-gray-600">{{ $log->standard_time }}m</td>
                    <td class="px-5 py-3.5 text-sm font-medium text-gray-900">{{ $log->actual_time }}m</td>
                    <td class="px-5 py-3.5 text-sm font-medium {{ $log->variance <= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $log->variance > 0 ? '+' : '' }}{{ $log->variance }}m
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="text-xs px-2 py-1 rounded-full
                            {{ $log->efficiency >= 100 ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                            {{ $log->efficiency }}%
                        </span>
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
                    <td colspan="8" class="px-5 py-12 text-center text-gray-400 text-sm">
                        No data for selected period!
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection