@extends('admin.layouts.app')
@section('title', 'Employee Report')
@section('subtitle', 'Performance per employee')

@section('content')

{{-- Date Filter --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 mb-5 mt-2">
    <form method="GET"
          action="{{ route('admin.reports.employee') }}"
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
</div>

{{-- Employee Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($employees as $emp)
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-11 h-11 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center font-bold flex-shrink-0">
                    {{ substr($emp->name, 0, 1) }}
                </div>
                <div>
                    <p class="font-semibold text-gray-900">{{ $emp->name }}</p>
                    <p class="text-xs text-gray-400">{{ $emp->employee_code }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2 mb-3">
                <div class="bg-gray-50 rounded-xl p-3 text-center">
                    <p class="text-lg font-bold text-gray-900">{{ $emp->tasks_done }}</p>
                    <p class="text-xs text-gray-400">Tasks Done</p>
                </div>
                <div class="bg-{{ $emp->avg_efficiency >= 100 ? 'green' : 'orange' }}-50 rounded-xl p-3 text-center">
                    <p class="text-lg font-bold text-{{ $emp->avg_efficiency >= 100 ? 'green' : 'orange' }}-600">
                        {{ $emp->avg_efficiency }}%
                    </p>
                    <p class="text-xs text-gray-400">Efficiency</p>
                </div>
            </div>

            <div class="space-y-1.5 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Standard</span>
                    <span class="font-medium">{{ $emp->total_standard }} mins</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Actual</span>
                    <span class="font-medium">{{ $emp->total_actual }} mins</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Variance</span>
                    <span class="font-medium {{ $emp->variance <= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $emp->variance > 0 ? '+' : '' }}{{ $emp->variance }} mins
                    </span>
                </div>
            </div>

            <div class="mt-3">
                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full {{ $emp->avg_efficiency >= 100 ? 'bg-green-500' : 'bg-orange-500' }}"
                         style="width: {{ min($emp->avg_efficiency, 100) }}%">
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-3 bg-white rounded-2xl border border-gray-200 p-12 text-center text-gray-400">
            No data for this period!
        </div>
    @endforelse
</div>

@endsection