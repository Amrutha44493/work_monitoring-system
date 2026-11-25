@extends('team-leader.layouts.app')
@section('title', 'Assign Work')
@section('subtitle', 'Assign task to team member')

@section('content')

<div class="mb-5 mt-2">
    <a href="{{ route('tl.assign.index') }}"
       class="text-gray-500 hover:text-orange-500 text-sm">
        ← Back to Assignments
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- Main Form --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">

            <div class="mb-5 pb-5 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                    <span class="w-6 h-6 bg-orange-500 text-white rounded-full flex items-center justify-center text-xs">1</span>
                    Select Project
                </h3>

                {{-- Project select auto-submits to load products --}}
                <form method="GET"
                      action="{{ route('tl.assign.create') }}"
                      id="projectForm">
                    <select name="project_id"
                            onchange="document.getElementById('projectForm').submit()"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                        <option value="">Select Project...</option>
                        @foreach($projects as $p)
                            <option value="{{ $p->id }}"
                                {{ $selectedProject?->id == $p->id ? 'selected' : '' }}>
                                {{ $p->name }} — {{ $p->customer->name }}
                            </option>
                        @endforeach
                    </select>
                    @if($projects->isEmpty())
                        <p class="text-orange-500 text-xs mt-1.5">
                         No projects assigned to you yet!
                            Ask admin to assign a project.
                        </p>
                    @endif
                </form>
            </div>

            @if($selectedProject)

                {{-- Assignment Form --}}
                <form method="POST"
                      action="{{ route('tl.assign.store') }}">
                @csrf

                    <input type="hidden"
                           name="project_id"
                           value="{{ $selectedProject->id }}">

                    <div class="mb-4">
                        <h3 class="text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            <span class="w-6 h-6 bg-orange-500 text-white rounded-full flex items-center justify-center text-xs">2</span>
                            Select Employee
                        </h3>
                        <select name="employee_id"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                            <option value="">Select Employee...</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}"
                                    {{ old('employee_id') == $emp->id ? 'selected' : '' }}>
                                    {{ $emp->name }}
                                    ({{ $emp->employee_code }})
                                </option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        @if($employees->isEmpty())
                            <p class="text-orange-500 text-xs mt-1">
                                ⚠️ No employees in your team!
                            </p>
                        @endif
                    </div>

                    <div class="mb-4">
                        <h3 class="text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            <span class="w-6 h-6 bg-orange-500 text-white rounded-full flex items-center justify-center text-xs">3</span>
                            Select Product
                            <span class="text-gray-400 font-normal text-xs">
                                (from this project)
                            </span>
                        </h3>
                        <select name="fitting_type_id"
                                id="productSelect"
                                onchange="updateStdTime(this)"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                            <option value="">Select Product...</option>
                            @forelse($projectItems as $item)
                                <option value="{{ $item->fittingType->id }}"
                                        data-std="{{ $item->fittingType->standard_time }}"
                                        data-unit="{{ $item->fittingType->unit }}"
                                        {{ old('fitting_type_id') == $item->fittingType->id ? 'selected' : '' }}>
                                    {{ $item->fittingType->name }}
                                    ({{ $item->fittingType->standard_time }} mins
                                    / {{ $item->fittingType->unit }})
                                    — Total qty: {{ $item->quantity }}
                                </option>
                            @empty
                                <option value="" disabled>
                                    No products in this project!
                                </option>
                            @endforelse
                        </select>
                        @error('fitting_type_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        {{-- Standard time hint --}}
                        <p class="text-xs text-gray-400 mt-1.5" id="stdTimeHint">
                            Select a product to see standard time
                        </p>
                    </div>

                    {{-- STEP 4: Quantity + Date --}}
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Quantity <span class="text-red-500">*</span>
                            </label>
                            <input type="number"
                                   name="quantity"
                                   id="quantityInput"
                                   value="{{ old('quantity', 1) }}"
                                   min="1"
                                   onchange="updateTotalTime()"
                                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                            @error('quantity')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Work Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date"
                                   name="assigned_date"
                                   value="{{ old('assigned_date', today()->format('Y-m-d')) }}"
                                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                        </div>
                    </div>

                    {{-- Total Time Preview --}}
                    <div id="totalTimeBox"
                         class="hidden mb-4 p-3 bg-orange-50 border border-orange-200 rounded-xl">
                        <p class="text-xs text-orange-700">
                            ⏱️ Total Standard Time:
                            <span id="totalTimeText" class="font-bold text-orange-800">
                                0 mins
                            </span>
                        </p>
                    </div>

                    {{-- Notes --}}
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Notes (optional)
                        </label>
                        <textarea name="notes"
                                  rows="2"
                                  placeholder="Any special instructions..."
                                  class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">{{ old('notes') }}</textarea>
                    </div>

                    <div class="flex gap-3 pt-4 border-t border-gray-100">
                        <button type="submit"
                                class="bg-orange-500 text-white px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-orange-600 transition">
                            📋 Assign Work
                        </button>
                        <a href="{{ route('tl.assign.index') }}"
                           class="text-gray-500 text-sm self-center">Cancel</a>
                    </div>

                </form>

            @else

                {{-- No project selected yet --}}
                <div class="py-16 text-center text-gray-400">
                    <p class="text-sm font-medium text-gray-500">
                        Select a project above!
                    </p>
                 
                </div>

            @endif

        </div>
    </div>

    <div class="space-y-4">

        @if($selectedProject)

            {{-- Project Info --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
                <h3 class="font-semibold text-gray-900 text-sm mb-4">
                    📋 Project Details
                </h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-gray-400 text-xs">Project</p>
                        <p class="font-medium text-gray-900">
                            {{ $selectedProject->name }}
                        </p>
                        <p class="text-xs text-gray-400 font-mono">
                            {{ $selectedProject->project_code }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs">Customer</p>
                        <p class="font-medium text-gray-900">
                            {{ $selectedProject->customer->name }}
                        </p>
                    </div>
                    @if($selectedProject->site_city)
                    <div>
                        <p class="text-gray-400 text-xs">Location</p>
                        <p class="font-medium text-gray-900">
                            {{ $selectedProject->site_city }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Products in Project --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
                <h3 class="font-semibold text-gray-900 text-sm mb-3">
                    📦 Products to Fit
                </h3>
                <div class="space-y-2">
                    @forelse($projectItems as $item)
                        @php
                            $assignedQty = \App\Models\WorkAssignment::where('project_id', $selectedProject->id)
                                ->where('fitting_type_id', $item->fitting_type_id)
                                ->whereNotIn('status', ['cancelled'])
                                ->sum('quantity');
                            $remaining = $item->quantity - $assignedQty;
                        @endphp
                        <div class="p-3 rounded-xl border
                            {{ $remaining <= 0 ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }}">
                            <div class="flex items-center justify-between mb-1">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $item->fittingType->name }}
                                </p>
                                @if($remaining <= 0)
                                    <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">
                                        ✅ All Assigned
                                    </span>
                                @else
                                    <span class="text-xs bg-orange-100 text-orange-700 px-2 py-0.5 rounded-full">
                                        {{ $remaining }} left
                                    </span>
                                @endif
                            </div>
                            <div class="flex items-center gap-3 text-xs text-gray-500">
                                <span>Total: {{ $item->quantity }}</span>
                                <span>•</span>
                                <span>Assigned: {{ $assignedQty }}</span>
                                <span>•</span>
                                <span>Std: {{ $item->standard_time }}m</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 text-center py-4">
                            No products in this project!
                        </p>
                    @endforelse
                </div>

                {{-- Total standard time --}}
                @if($projectItems->count() > 0)
                    <div class="mt-3 pt-3 border-t border-gray-100 flex justify-between text-sm">
                        <span class="text-gray-500">Total Std Time:</span>
                        <span class="font-bold text-orange-600">
                            {{ $projectItems->sum('standard_time') }} mins
                        </span>
                    </div>
                @endif
            </div>

            {{-- Already Assigned --}}
            @php
                $existing = \App\Models\WorkAssignment::where('project_id', $selectedProject->id)
                    ->with(['employee', 'fittingType'])
                    ->latest()
                    ->get();
            @endphp
            @if($existing->count() > 0)
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
                    <h3 class="font-semibold text-gray-900 text-sm mb-3">
                        📌 Already Assigned
                    </h3>
                    <div class="space-y-2">
                        @foreach($existing as $a)
                            <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                                <div class="min-w-0">
                                    <p class="text-xs font-medium text-gray-900 truncate">
                                        {{ $a->employee->name }}
                                    </p>
                                    <p class="text-xs text-gray-400 truncate">
                                        {{ $a->fittingType->name }}
                                        × {{ $a->quantity }}
                                    </p>
                                </div>
                                <span class="text-xs px-2 py-0.5 rounded-full ml-2 flex-shrink-0
                                    bg-{{ $a->status_color }}-100
                                    text-{{ $a->status_color }}-700">
                                    {{ ucfirst($a->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        @else

       

        @endif

    </div>

</div>

{{-- JavaScript for live time calculation --}}
<script>
    let selectedStdTime = 0;

    function updateStdTime(select) {
        const option = select.options[select.selectedIndex];
        selectedStdTime = parseInt(option.dataset.std) || 0;
        const unit = option.dataset.unit || 'per piece';

        if(selectedStdTime > 0) {
            document.getElementById('stdTimeHint').textContent =
                '⏱️ Standard time: ' + selectedStdTime +
                ' mins ' + unit;
        } else {
            document.getElementById('stdTimeHint').textContent =
                'Select a product to see standard time';
        }
        updateTotalTime();
    }

    function updateTotalTime() {
        const qty = parseInt(
            document.getElementById('quantityInput').value
        ) || 1;
        const total = selectedStdTime * qty;

        if(total > 0) {
            const hours = Math.floor(total / 60);
            const mins  = total % 60;
            const timeStr = hours > 0
                ? hours + 'h ' + mins + 'm'
                : mins + ' mins';

            document.getElementById('totalTimeText').textContent = timeStr;
            document.getElementById('totalTimeBox').classList.remove('hidden');
        } else {
            document.getElementById('totalTimeBox').classList.add('hidden');
        }
    }
</script>

@endsection