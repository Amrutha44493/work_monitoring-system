@extends('admin.layouts.app')

@section('title', 'Edit Project')
@section('subtitle', 'Update project details')

@section('content')

<div class="mb-5 mt-2">
    <a href="{{ route('admin.projects.show', $project) }}"
       class="text-gray-500 hover:text-orange-500 text-sm transition">
        ← Back to Project
    </a>
</div>

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">

        <h3 class="text-base font-semibold text-gray-900 mb-5 pb-4 border-b border-gray-100">
            Edit: {{ $project->name }}
            <span class="text-gray-400 font-normal text-sm ml-2">{{ $project->project_code }}</span>
        </h3>

        <form method="POST"
              action="{{ route('admin.projects.update', $project) }}">
        @csrf
        @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Customer <span class="text-red-500">*</span>
                    </label>
                    <select name="customer_id"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}"
                                {{ old('customer_id', $project->customer_id) == $c->id ? 'selected' : '' }}>
                                {{ $c->name }} — {{ $c->phone }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Name --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Project Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name"
                           value="{{ old('name', $project->name) }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Site Address
                    </label>
                    <textarea name="site_address" rows="2"
                              class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">{{ old('site_address', $project->site_address) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">City</label>
                    <input type="text" name="site_city"
                           value="{{ old('site_city', $project->site_city) }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                        @foreach(['pending','in_progress','completed','on_hold','cancelled'] as $s)
                            <option value="{{ $s }}"
                                {{ old('status', $project->status) == $s ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_',' ',$s)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Start Date</label>
                    <input type="date" name="start_date"
                           value="{{ old('start_date', $project->start_date?->format('Y-m-d')) }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Expected End</label>
                    <input type="date" name="expected_end_date"
                           value="{{ old('expected_end_date', $project->expected_end_date?->format('Y-m-d')) }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                </div>

                {{-- Actual End --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Actual End Date
                    </label>
                    <input type="date" name="actual_end_date"
                           value="{{ old('actual_end_date', $project->actual_end_date?->format('Y-m-d')) }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                </div>

                {{-- Notes --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Notes</label>
                    <textarea name="notes" rows="2"
                              class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">{{ old('notes', $project->notes) }}</textarea>
                </div>

            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="bg-orange-500 text-white px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-orange-600 transition">
                    Update 
                </button>
                <a href="{{ route('admin.projects.show', $project) }}"
                   class="text-gray-500 text-sm">Cancel</a>
            </div>

        </form>
    </div>
</div>

@endsection