@extends('team-leader.layouts.app')
@section('title', 'All Assignments')
@section('subtitle', 'Work assigned to your team')

@section('content')

{{-- Filter --}}
<div class="flex items-center gap-3 mb-5 mt-2 flex-wrap">
    <form method="GET"
          action="{{ route('tl.assign.index') }}"
          class="flex gap-3 flex-1 flex-wrap">
        <select name="employee_id"
                class="border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            <option value="">All Employees</option>
            @foreach($employees as $emp)
                <option value="{{ $emp->id }}"
                    {{ request('employee_id') == $emp->id ? 'selected' : '' }}>
                    {{ $emp->name }}
                </option>
            @endforeach
        </select>
        <select name="status"
                class="border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            <option value="">All Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
        </select>
        <button type="submit"
                class="bg-gray-800 text-white px-4 py-2 rounded-xl text-sm hover:bg-gray-900 transition">
            Filter
        </button>
    </form>
    <a href="{{ route('tl.assign.create') }}"
       class="bg-orange-500 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-orange-600 transition">
        + Assign Work
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Employee</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Product</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Project</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Qty</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Std</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($assignments as $a)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3.5 text-sm font-medium text-gray-900">{{ $a->employee->name }}</td>
                    <td class="px-5 py-3.5 text-sm text-gray-600">{{ $a->fittingType->name }}</td>
                    <td class="px-5 py-3.5 text-sm text-gray-500">{{ $a->project->name ?? '—' }}</td>
                    <td class="px-5 py-3.5 text-sm text-gray-600">{{ $a->quantity }}</td>
                    <td class="px-5 py-3.5 text-sm font-medium text-gray-900">{{ $a->standard_time }}m</td>
                    <td class="px-5 py-3.5 text-sm text-gray-500">{{ $a->assigned_date->format('d M Y') }}</td>
                    <td class="px-5 py-3.5">
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium
                            bg-{{ $a->status_color }}-100
                            text-{{ $a->status_color }}-700">
                            {{ ucfirst($a->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5">
                        @if($a->status == 'pending')
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('tl.work.start', $a) }}">
                                    @csrf
                                    <button type="submit"
                                            class="bg-green-100 text-green-700 hover:bg-green-500 hover:text-white px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                        ▶ Start
                                    </button>
                                </form>
                                <form method="POST"
                                      action="{{ route('tl.assign.destroy', $a) }}"
                                      onsubmit="return confirm('Remove?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-gray-100 text-gray-500 hover:bg-red-100 hover:text-red-600 px-2.5 py-1.5 rounded-lg text-xs transition">
                                        ✕
                                    </button>
                                </form>
                            </div>
                        @elseif($a->status == 'in_progress')
                            @php
                                $activeLog = \App\Models\WorkLog::where('work_assignment_id', $a->id)
                                    ->where('status','started')->first();
                            @endphp
                            @if($activeLog)
                                <form method="POST" action="{{ route('tl.work.stop', $activeLog) }}">
                                    @csrf
                                    <button type="submit"
                                            class="bg-red-100 text-red-600 hover:bg-red-500 hover:text-white px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                        ⏹ Stop
                                    </button>
                                </form>
                            @endif
                        @else
                            <span class="text-xs text-gray-400">Done ✓</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-5 py-12 text-center text-gray-400 text-sm">
                        No assignments found!
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @if($assignments->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">{{ $assignments->links() }}</div>
    @endif
</div>

@endsection