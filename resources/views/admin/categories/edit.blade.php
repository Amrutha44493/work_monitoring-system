@extends('admin.layouts.app')

@section('title', 'Edit Category')
@section('subtitle', 'Update category details')

@section('content')

<div class="mb-5 mt-2">
    <a href="{{ route('admin.categories.index') }}"
       class="text-gray-500 hover:text-orange-500 text-sm transition">
        ← Back to Categories
    </a>
</div>

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">

        <h3 class="text-base font-semibold text-gray-900 mb-5 pb-4 border-b border-gray-100">
            Edit: {{ $category->name }}
        </h3>

        <form method="POST"
              action="{{ route('admin.categories.update', $category) }}">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Category Name <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $category->name) }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('name') border-red-400 @enderror">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Description
                </label>
                <textarea name="description"
                          rows="3"
                          class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">{{ old('description', $category->description) }}</textarea>
            </div>


            {{-- Is Active --}}
            <div class="mb-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <div class="relative">
                        <input type="checkbox"
                               name="is_active"
                               value="1"
                               {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-10 h-6 bg-gray-200 rounded-full peer peer-checked:bg-orange-500 transition"></div>
                        <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow peer-checked:translate-x-4 transition"></div>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Active</span>
                </label>
            </div>

         

            {{-- Buttons --}}
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="bg-orange-500 text-white px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-orange-600 transition">
                    Update 
                </button>
                <a href="{{ route('admin.categories.index') }}"
                   class="text-gray-500 hover:text-gray-700 text-sm transition">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>

@endsection