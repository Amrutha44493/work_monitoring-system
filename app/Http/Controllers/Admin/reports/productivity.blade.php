@extends('admin.layouts.app')
@section('title', 'Productivity Report')
@section('subtitle', 'Employee productivity ranking')

@section('content')

{{-- Filter --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 mb-5 mt-2">
    <form method="GET"
          action="{{ route('admin.reports.productivity') }}"
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

{{-- Leaderboard --}}
<div class="space-y-3">
    @forelse($employees as $index => $emp)
        <div class="bg-white rounded-2xl border {{ $index === 0 ? 'border-yellow-300' : 'border-gray-200' }} shadow-sm p-5">
            <div class="flex items-center gap-4">

                {{-- Rank --}}
                <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-lg flex-shrink-0
                    {{ $index === 0 ? 'bg-yellow-400 text-white' : ($index === 1 ? 'bg-gray-300 text-white' : ($index === 2 ? 'bg-amber-600 text-white' : 'bg-gray-100 text-gray-500')) }}">
                    {{ $index === 0 ? '🥇' : ($index === 1 ? '🥈' : ($index === 2 ? '🥉' : $index + 1)) }}
                </div>

                {{-- Avatar --}}
                <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center font-bold flex-shrink-0">
                    {{ substr($emp->name, 0, 1) }}
                </div>

                {{-- Info --}}
                <div class="flex-1">
                    <p class="font-semibold text-gray-900">{{ $emp->name }}</p>
                    <p class="text-xs text-gray-400">
                        {{ $emp->tasks_completed }} tasks |
                        {{ $emp->actual_time }} mins worked
                    </p>
                </div>

                {{-- Efficiency --}}
                <div class="text-right">
                    <p class="text-2xl font-bold {{ $emp->efficiency >= 100 ? 'text-green-600' : 'text-orange-500' }}">
                        {{ $emp->efficiency }}%
                    </p>
                    <p class="text-xs text-gray-400">efficiency</p>
                </div>

                {{-- Time Saved --}}
                <div class="text-right {{ $emp->time_saved >= 0 ? 'text-green-600' : 'text-red-500' }}">
                    <p class="font-bold text-sm">
                        {{ $emp->time_saved >= 0 ? '🚀 Saved' : '⚠️ Extra' }}
                    </p>
                    <p class="text-sm font-semibold">
                        {{ abs($emp->time_saved) }} mins
                    </p>
                </div>

            </div>

            {{-- Bar --}}
            <div class="mt-3">
                <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full {{ $emp->efficiency >= 100 ? 'bg-green-500' : 'bg-orange-500' }}"
                         style="width: {{ min($emp->efficiency, 100) }}%">
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-2xl border border-gray-200 p-12 text-center text-gray-400">
            No data for selected period!
        </div>
    @endforelse
</div>

@endsection