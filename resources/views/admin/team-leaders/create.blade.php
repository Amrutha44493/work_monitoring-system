@extends('admin.layouts.app')
@section('title', 'Add Supervisor')
@section('subtitle', 'Create new Supervisor')

@section('content')

<div class="mb-5 mt-2">
    <a href="{{ route('admin.team-leaders.index') }}"
       class="text-gray-500 hover:text-orange-500 text-sm">← Back</a>
</div>

<div class="max-w-xl">
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">

        <h3 class="text-base font-semibold text-gray-900 mb-5 pb-4 border-b border-gray-100">
            Supervisor Details
        </h3>

        <form method="POST"
              action="{{ route('admin.team-leaders.store') }}">
        @csrf

            {{-- Name --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name"
                       value="{{ old('name') }}"
                       placeholder="Supervisor name"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('name') border-red-400 @enderror">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Phone --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Phone <span class="text-red-500">*</span>
                </label>
                <input type="text" name="phone"
                       value="{{ old('phone') }}"
                       placeholder="+91 9856413254"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('phone') border-red-400 @enderror">
                @error('phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Email
                   
                </label>
                <input type="email" name="email"
                       value="{{ old('email') }}"
                       placeholder="Supervisor@email.com"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>

            {{-- Joining Date --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Joining Date
                </label>
                <input type="date" name="joining_date"
                       value="{{ old('joining_date') }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>

            
            <div class="flex gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="bg-orange-500 text-white px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-orange-600 transition">
                    Create 
                </button>
                <a href="{{ route('admin.team-leaders.index') }}"
                   class="text-gray-500 text-sm self-center">Cancel</a>
            </div>

        </form>
    </div>
</div>

@endsection