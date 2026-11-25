@extends('admin.layouts.app')
@section('title', 'Edit Supervisor')
@section('subtitle', 'Update Supervisor details')

@section('content')

<div class="mb-5 mt-2">
    <a href="{{ route('admin.team-leaders.index') }}"
       class="text-gray-500 hover:text-orange-500 text-sm">← Back</a>
</div>

<div class="max-w-xl">
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">

        <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-100">
            <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center font-bold text-lg">
                {{ substr($teamLeader->name, 0, 1) }}
            </div>
            <div>
                <h3 class="font-semibold text-gray-900">{{ $teamLeader->name }}</h3>
                <p class="text-xs text-gray-400">{{ $teamLeader->employee_code }}</p>
            </div>
        </div>

        <form method="POST"
              action="{{ route('admin.team-leaders.update', $teamLeader) }}">
        @csrf
        @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name"
                       value="{{ old('name', $teamLeader->name) }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Phone <span class="text-red-500">*</span>
                </label>
                <input type="text" name="phone"
                       value="{{ old('phone', $teamLeader->phone) }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Joining Date
                </label>
                <input type="date" name="joining_date"
                       value="{{ old('joining_date', $teamLeader->joining_date?->format('Y-m-d')) }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>

            {{-- Active toggle --}}
            <div class="mb-5">
                <label class="flex items-center gap-3 cursor-pointer">
                    <div class="relative">
                        <input type="checkbox" name="is_active"
                               value="1"
                               {{ old('is_active', $teamLeader->is_active) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-10 h-6 bg-gray-200 rounded-full peer peer-checked:bg-orange-500 transition"></div>
                        <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow peer-checked:translate-x-4 transition"></div>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Active</span>
                </label>
            </div>

            <div class="flex gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="bg-orange-500 text-white px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-orange-600 transition">
                    Update 
                </button>
                <a href="{{ route('admin.team-leaders.index') }}"
                   class="text-gray-500 text-sm self-center">Cancel</a>
            </div>

        </form>
    </div>
</div>

@endsection