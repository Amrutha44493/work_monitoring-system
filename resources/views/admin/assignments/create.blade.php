@extends('admin.layouts.app')
@section('title', 'Assign Work')
@section('subtitle', 'Assign a task to an employee')

@section('content')

<div class="mb-5 mt-2">
    <a href="{{ route('admin.assignments.index') }}"
       class="text-gray-500 hover:text-orange-500 text-sm">← Back</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- Form --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">

            {{-- Step 1: Select Project --}}
            <div class="mb-5 pb-5 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                    <span class="w-6 h-6 bg-orange-500 text-white rounded-full flex items-center justify-center text-xs font-bold">1</span>
                    Select Project
                </h3>
                <form method="GET"
                      action="{{ route('admin.assignments.create') }}"
                      id="projectForm">
                    <select name="project_id"
                            onchange="document.getElementById('projectForm').submit()"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                        <option value="">Select Project...</option>
                        @foreach($projects as $p)
                            <option value="{{ $p->id }}"
                                {{ $selectedProject?->id == $p->id ? 'selected' : '' }}>
                                {{ $p->name }} — {{ $p->customer->name }}
                                @if($p->teamLeader)
                                    (TL: {{ $p->teamLeader->name }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            @if($selectedProject)
            <form method="POST"
                  action="{{ route('admin.assignments.store') }}">
            @csrf
                <input type="hidden" name="project_id" value="{{ $selectedProject->id }}">

                {{-- Step 2: Employee --}}
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                        <span class="w-6 h-6 bg-orange-500 text-white rounded-full flex items-center justify-center text-xs font-bold">2</span>
                        Select Employee
                    </h3>
                    <select name="employee_id"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                        <option value="">Select Employee...</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}"
                                {{ old('employee_id') == $emp->id ? 'selected' : '' }}>
                                {{ $emp->name }} ({{ $emp->employee_code }})
                                @if($emp->teamLeader)
                                    — {{ $emp->teamLeader->name }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('employee_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Step 3: Product from project --}}
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                        <span class="w-6 h-6 bg-orange-500 text-white rounded-full flex items-center justify-center text-xs font-bold">3</span>
                        Select Product
                        <span class="text-gray-400 text-xs font-normal">(from this project)</span>
                    </h3>
                    <select name="fitting_type_id"
                            onchange="updateStdTime(this)"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                        <option value="">Select Product...</option>
                        @forelse($projectItems as $item)
                            <option value="{{ $item->fittingType->id }}"
                                    data-std="{{ $item->fittingType->standard_time }}"
                                    {{ old('fitting_type_id') == $item->fittingType->id ? 'selected' : '' }}>
                                {{ $item->fittingType->name }}
                                ({{ $item->fittingType->standard_time }}m / {{ $item->fittingType->unit }})
                                — Qty: {{ $item->quantity }}
                            </option>
                        @empty
                            <option disabled>No products in this project!</option>
                        @endforelse
                    </select>
                    @error('fitting_type_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-400 mt-1" id="stdHint">
                        Select product to see standard time
                    </p>
                </div>

                {{-- Qty + Date --}}
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Quantity <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="quantity"
                               id="qtyInput"
                               value="{{ old('quantity', 1) }}"
                               min="1"
                               onchange="updateTotal()"
                               class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="assigned_date"
                               value="{{ old('assigned_date', today()->format('Y-m-d')) }}"
                               class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                    </div>
                </div>

                {{-- Total time --}}
                <div id="totalBox" class="hidden mb-4 p-3 bg-orange-50 border border-orange-200 rounded-xl">
                    <p class="text-xs text-orange-700">
                        ⏱️ Total Standard Time:
                        <strong id="totalText">0 mins</strong>
                    </p>
                </div>

                {{-- Notes --}}
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Notes</label>
                    <textarea name="notes" rows="2"
                              class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">{{ old('notes') }}</textarea>
                </div>

                <div class="flex gap-3 pt-4 border-t border-gray-100">
                    <button type="submit"
                            class="bg-orange-500 text-white px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-orange-600 transition">
                        📋 Assign Work
                    </button>
                    <a href="{{ route('admin.assignments.index') }}"
                       class="text-gray-500 text-sm self-center">Cancel</a>
                </div>

            </form>
            @else
                <div class="py-16 text-center text-gray-400">
                    <p class="text-4xl mb-3">👆</p>
                    <p class="text-sm">Select a project to continue!</p>
                </div>
            @endif

        </div>
    </div>

    {{-- Right side --}}
    <div>
        @if($selectedProject)
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 mb-4">
            <h3 class="font-semibold text-gray-900 text-sm mb-3">📋 Project Info</h3>
            <div class="space-y-2 text-sm">
                <div>
                    <p class="text-gray-400 text-xs">Project</p>
                    <p class="font-medium">{{ $selectedProject->name }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs">Customer</p>
                    <p class="font-medium">{{ $selectedProject->customer->name }}</p>
                </div>
                @if($selectedProject->teamLeader)
                <div>
                    <p class="text-gray-400 text-xs">Team Leader</p>
                    <p class="font-medium">{{ $selectedProject->teamLeader->name }}</p>
                </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
            <h3 class="font-semibold text-gray-900 text-sm mb-3">📦 Products</h3>
            <div class="space-y-2">
                @foreach($projectItems as $item)
                    @php
                        $assigned = \App\Models\WorkAssignment::where('project_id', $selectedProject->id)
                            ->where('fitting_type_id', $item->fitting_type_id)
                            ->sum('quantity');
                        $left = $item->quantity - $assigned;
                    @endphp
                    <div class="p-2.5 rounded-xl {{ $left <= 0 ? 'bg-green-50 border border-green-200' : 'bg-gray-50 border border-gray-200' }}">
                        <p class="text-xs font-medium text-gray-900">
                            {{ $item->fittingType->name }}
                        </p>
                        <div class="flex gap-3 text-xs text-gray-400 mt-0.5">
                            <span>Total: {{ $item->quantity }}</span>
                            <span>•</span>
                            <span>Assigned: {{ $assigned }}</span>
                            <span>•</span>
                            <span class="{{ $left <= 0 ? 'text-green-600 font-medium' : 'text-orange-600 font-medium' }}">
                                {{ $left <= 0 ? '✅ Done' : $left.' left' }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="bg-white rounded-2xl border border-gray-200 p-10 text-center text-gray-400">
            <p class="text-3xl mb-2">🏗️</p>
            <p class="text-sm">Select project first</p>
        </div>
        @endif
    </div>

</div>

<script>
    let stdTime = 0;
    function updateStdTime(sel) {
        const opt = sel.options[sel.selectedIndex];
        stdTime = parseInt(opt.dataset.std) || 0;
        document.getElementById('stdHint').textContent =
            stdTime > 0 ? '⏱️ ' + stdTime + ' mins per unit' : 'Select product to see standard time';
        updateTotal();
    }
    function updateTotal() {
        const qty   = parseInt(document.getElementById('qtyInput').value) || 1;
        const total = stdTime * qty;
        if(total > 0) {
            const h = Math.floor(total/60);
            const m = total % 60;
            document.getElementById('totalText').textContent =
                h > 0 ? h+'h '+m+'m' : m+' mins';
            document.getElementById('totalBox').classList.remove('hidden');
        } else {
            document.getElementById('totalBox').classList.add('hidden');
        }
    }
</script>

@endsection