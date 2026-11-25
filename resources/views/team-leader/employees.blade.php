@extends('team-leader.layouts.app')
@section('title', 'My Team')
@section('subtitle', 'Employees under My supervision')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-2">
    @forelse($employees as $emp)
        <div class="bg-white rounded-2xl border {{ $emp->is_working ? 'border-green-300' : 'border-gray-200' }} shadow-sm p-5">

            {{-- Header --}}
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center font-bold text-lg flex-shrink-0
                    {{ $emp->is_working ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-600' }}">
                    {{ substr($emp->name, 0, 1) }}
                </div>
                <div>
                    <p class="font-semibold text-gray-900">{{ $emp->name }}</p>
                    <p class="text-xs text-gray-400">{{ $emp->employee_code }}</p>
                    <p class="text-xs {{ $emp->is_working ? 'text-green-600 font-medium' : 'text-gray-400' }}">
                        {{ $emp->is_working ? '🟢 Working Now' : '⚪ Available' }}
                    </p>
                </div>
            </div>

            {{-- Current task --}}
            @if($emp->is_working && $emp->current_task)
                <div class="bg-green-50 border border-green-200 rounded-xl p-2 mb-3">
                    <p class="text-xs text-green-700 font-medium">
                        {{ $emp->current_task->fittingType->name ?? '—' }}
                    </p>
                    <p class="text-xs text-green-500">
                        Started {{ $emp->current_task->start_time?->format('h:i A') }}
                    </p>
                </div>
            @endif

            {{-- Today stats --}}
            <div class="grid grid-cols-3 gap-2 mb-4">
                <div class="bg-gray-50 rounded-xl p-2 text-center">
                    <p class="text-base font-bold text-gray-900">{{ $emp->today_tasks }}</p>
                    <p class="text-xs text-gray-400">Done</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-2 text-center">
                    <p class="text-base font-bold text-gray-900">{{ $emp->today_time }}</p>
                    <p class="text-xs text-gray-400">Mins</p>
                </div>
                <div class="bg-{{ $emp->today_eff >= 100 ? 'green' : 'orange' }}-50 rounded-xl p-2 text-center">
                    <p class="text-base font-bold text-{{ $emp->today_eff >= 100 ? 'green' : 'orange' }}-600">
                        {{ $emp->today_eff }}%
                    </p>
                    <p class="text-xs text-gray-400">Eff</p>
                </div>
            </div>

            <a href="{{ route('tl.assign.create', ['employee_id' => $emp->id]) }}"
               class="block w-full bg-orange-500 text-white py-2 rounded-xl text-xs font-medium text-center hover:bg-orange-600 transition">
                + Assign Work
            </a>

        </div>
    @empty
        <div class="col-span-3 bg-white rounded-2xl border border-gray-200 p-16 text-center">
            <p class="text-4xl mb-3">👷</p>
            <p class="text-gray-500">No team members yet!</p>
            <p class="text-gray-400 text-sm mt-1">Ask admin to assign employees to your team.</p>
        </div>
    @endforelse
</div>

@endsection