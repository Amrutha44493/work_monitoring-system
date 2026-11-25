@extends('team-leader.layouts.app')
@section('title', 'Pending Work')
@section('subtitle', 'All pending assignments')

@section('content')

@php
    $waText =
        "Pending Work Report - Team\n" .
        "Date: " . now()->format('d M Y') . "\n\n" .
        "Total Pending: " . $pending->count() . " tasks\n" .
        "Not Started: " . $pending->where('status','pending')->count() . "\n" .
        "In Progress: " . $pending->where('status','in_progress')->count() . "\n\n" .
        "Sent from Kitchen Work Tracker";
@endphp

<div class="flex items-center justify-between mb-5 mt-2 flex-wrap gap-3">
    <p class="text-sm text-gray-500">{{ $pending->count() }} pending tasks</p>
    <div class="flex items-center gap-2 no-print">
        <a href="{{ route('tl.reports.pending') }}?export=pdf"
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
                    <td class="px-5 py-3.5 text-sm font-medium">{{ $a->standard_time }}m</td>
                    <td class="px-5 py-3.5 text-sm text-gray-500">{{ $a->assigned_date->format('d M Y') }}</td>
                    <td class="px-5 py-3.5">
                        <span class="text-xs px-2 py-1 rounded-full
                            {{ $a->status === 'in_progress' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700' }}">
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

<style>@media print { aside, header, .no-print { display: none !important; } }</style>

@endsection