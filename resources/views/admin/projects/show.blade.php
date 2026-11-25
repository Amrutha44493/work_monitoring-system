@extends('admin.layouts.app')
@section('title', $project->name)
@section('subtitle', 'Project Code: '.$project->project_code)

@section('content')

{{-- Header --}}
<div class="flex items-center justify-between mb-5 mt-2">
    <a href="{{ route('admin.projects.index') }}"
       class="text-gray-500 hover:text-orange-500 text-sm">
        ← Back to Projects
    </a>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.projects.edit', $project) }}"
           class="bg-gray-100 text-gray-600 hover:bg-orange-100 hover:text-orange-600 px-4 py-2 rounded-xl text-sm font-medium transition">
            ✏️ Edit Project
        </a>
       
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">

    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h2 class="text-lg font-bold text-gray-900">
                    {{ $project ->name ?? '-' }}
                    
                </h2>
                <p class="text-sm text-gray-500 mt-0.5">
                   {{ $project->customer->name ?? 'No customer' }}
                    @if($project->site_city)
                        — {{ $project->site_city }}
                    @endif
                </p>
                @if($project->teamLeader)
                    <p class="text-xs text-gray-400 mt-0.5">
                        👑 Supervisor: {{ $project->teamLeader ->name ?? '-' }}
                    </p>
                @endif
            </div>
            <span class="text-xs px-3 py-1.5 rounded-full font-medium
                bg-{{ $project->status_color }}-100
                text-{{ $project->status_color }}-700">
                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
            </span>
        </div>

        <div class="grid grid-cols-4 gap-3">
            <div class="bg-gray-50 rounded-xl p-3 text-center">
                <p class="text-xl font-bold text-gray-900">
                    {{ $project->fittingItems->count() }}
                </p>
                <p class="text-xs text-gray-400 mt-0.5">Items</p>
            </div>
            <div class="bg-orange-50 rounded-xl p-3 text-center">
                <p class="text-xl font-bold text-orange-600">
                    {{ $project->fittingItems->sum('standard_time') }}
                </p>
                <p class="text-xs text-gray-400 mt-0.5">Std Mins</p>
            </div>
            <div class="bg-blue-50 rounded-xl p-3 text-center">
                <p class="text-xl font-bold text-blue-600">
                    {{ $project->workAssignments->count() }}
                </p>
                <p class="text-xs text-gray-400 mt-0.5">Assigned</p>
            </div>
            <div class="bg-green-50 rounded-xl p-3 text-center">
                <p class="text-xl font-bold text-green-600">
                    {{ $project->workLogs->where('status','completed')->count() }}
                </p>
                <p class="text-xs text-gray-400 mt-0.5">Completed</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
        <h3 class="font-semibold text-gray-900 mb-4 text-sm">📅 Timeline</h3>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-400">Project Code</span>
                <span class="font-mono text-xs bg-gray-100 px-2 py-0.5 rounded">
                    {{ $project->project_code }}
                </span>
            </div>
            @if($project->start_date)
                <div class="flex justify-between">
                    <span class="text-gray-400">Start Date</span>
                    <span class="font-medium">{{ $project->start_date->format('d M Y') }}</span>
                </div>
            @endif
            @if($project->expected_end_date)
                <div class="flex justify-between">
                    <span class="text-gray-400">Expected End</span>
                    <span class="font-medium">{{ $project->expected_end_date->format('d M Y') }}</span>
                </div>
            @endif
            @if($project->notes)
                <div class="pt-2 border-t border-gray-100">
                    <p class="text-gray-400 text-xs mb-1">Notes</p>
                    <p class="text-gray-600 text-xs">{{ $project->notes }}</p>
                </div>
            @endif
        </div>
    </div>

</div>

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-5">
    <div class="flex items-center justify-between p-4 border-b border-gray-100">
        <h3 class="font-semibold text-gray-900 text-sm">📦 Fitting Items</h3>
    </div>
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Product</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Category</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Qty</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Std Time</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($project->fittingItems as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3.5 text-sm font-medium text-gray-900">
                        {{ $item->fittingType ->name ?? '-' }}
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="bg-orange-50 text-orange-600 text-xs px-2 py-1 rounded-lg">
                            {{ $item->fittingType->category->name ?? '—' }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-sm text-gray-600">
                        {{ $item->quantity }}
                        <span class="text-gray-400 text-xs">
                            {{ $item->fittingType->unit }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-sm font-medium text-gray-900">
                        {{ $item->standard_time }} mins
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="text-xs px-2 py-1 rounded-full
                            bg-{{ $item->status_color }}-100
                            text-{{ $item->status_color }}-700">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5">
                        <form method="POST"
                              action="{{ route('admin.projects.items.remove', [$project, $item]) }}"
                              onsubmit="return confirm('Remove this item?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-red-400 hover:text-red-600 text-xs transition">
                                Remove
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-5 py-8 text-center text-gray-400 text-sm">
                        No items added yet!
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Add More Items --}}
    <div class="p-4 border-t border-gray-100 bg-gray-50"
         x-data="{ open: false }">
        <button @click="open = !open"
                type="button"
                class="text-orange-500 text-sm font-medium hover:text-orange-600">
            + Add More Items
        </button>
        <div x-show="open" x-transition class="mt-4">
            <form method="POST"
                  action="{{ route('admin.projects.items.add', $project) }}"
                  class="flex items-end gap-3">
                @csrf
                <div class="flex-1">
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        Select Product
                    </label>
                    <select name="fitting_type_id"
                            class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                        <option value="">Select...</option>
                        @foreach(\App\Models\FittingType::with('category')->get() as $ft)
                            <option value="{{ $ft->id }}">
                                {{ $ft->category->name ?? '' }} —
                                {{ $ft ->name ?? '-' }}
                                ({{ $ft->standard_time }} mins)
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="w-24">
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        Quantity
                    </label>
                    <input type="number" name="quantity"
                           value="1" min="1"
                           class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                </div>
                <button type="submit"
                        class="bg-orange-500 text-white px-4 py-2 rounded-xl text-sm hover:bg-orange-600 transition">
                    Add
                </button>
            </form>
        </div>
    </div>
</div>

@if($project->workAssignments->count() > 0)
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="p-4 border-b border-gray-100">
        <h3 class="font-semibold text-gray-900 text-sm">👷 Work Assignments</h3>
    </div>
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Employee</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Product</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Qty</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Std Time</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($project->workAssignments as $assignment)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3.5 text-sm font-medium text-gray-900">
                        {{ $assignment->employee ->name ?? '-' }}
                    </td>
                    <td class="px-5 py-3.5 text-sm text-gray-600">
                        {{ $assignment->fittingType ->name ?? '-' }}
                    </td>
                    <td class="px-5 py-3.5 text-sm text-gray-600">
                        {{ $assignment->quantity }}
                    </td>
                    <td class="px-5 py-3.5 text-sm text-gray-600">
                        {{ $assignment->standard_time }} mins
                    </td>
                    <td class="px-5 py-3.5 text-sm text-gray-500">
                        {{ $assignment->assigned_date->format('d M Y') }}
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="text-xs px-2 py-1 rounded-full
                            bg-{{ $assignment->status_color }}-100
                            text-{{ $assignment->status_color }}-700">
                            {{ ucfirst($assignment->status) }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@endsection