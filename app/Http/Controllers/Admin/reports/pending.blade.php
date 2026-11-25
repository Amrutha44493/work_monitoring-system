@extends('admin.layouts.app')
@section('title', 'Pending Work')
@section('subtitle', 'All pending assignments')

@section('content')

<div class="flex items-center justify-between mb-5 mt-2">
    <p class="text-sm text-gray-500">{{ $pending->count() }} pending</p>
    <a href="{{ route('admin.assignments.create') }}"
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
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Std Time</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($pending as $a)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3.5 text-sm font-medium text-gray-900">{{ $a->employee->name }}</td>
                    <td class="px-5 py-3.5 text-sm text-gray-600">{{ $a->fittingType->name }}</td>
                    <td class="px-5 py-3.5 text-sm text-gray-500">{{ $a->project->name ?? '—' }}</td>
                    <td class="px-5 py-3.5 text-sm text-gray-600">{{ $a->quantity }}</td>
                    <td class="px-5 py-3.5 text-sm font-medium text-gray-900">{{ $a->standard_time }} mins</td>
                    <td class="px-5 py-3.5 text-sm text-gray-500">{{ $a->assigned_date->format('d M Y') }}</td>
                    <td class="px-5 py-3.5">
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium
                            bg-{{ $a->status_color }}-100
                            text-{{ $a->status_color }}-700">
                            {{ ucfirst($a->status) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-5 py-12 text-center">
                        <p class="text-3xl mb-2">🎉</p>
                        <p class="text-gray-400 text-sm">No pending work!</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection