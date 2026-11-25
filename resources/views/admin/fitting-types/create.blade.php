@extends('admin.layouts.app')

@section('title', '')
@section('subtitle', 'Create new Products')

@section('content')

<div class="mb-5 mt-2">
    <a href="{{ route('admin.fitting-types.index') }}"
       class="text-gray-500 hover:text-orange-500 text-sm transition">
        ← Back to Products
    </a>
</div>

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">

        <h3 class="text-base font-semibold text-gray-900 mb-5 pb-4 border-b border-gray-100">
            Product Details
        </h3>

        <form method="POST" action="{{ route('admin.fitting-types.store') }}">
        @csrf

            {{-- Category --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Category <span class="text-red-500">*</span>
                </label>
                <select name="category_id"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('category_id') border-red-400 @enderror">
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Name --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                     Name <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="e.g.Wall Shutter"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('name') border-red-400 @enderror">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Standard Time + Unit --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Standard Time (minutes) <span class="text-red-500">*</span>
                    </label>
                    <input type="number"
                           name="standard_time"
                           value="{{ old('standard_time') }}"
                           placeholder="25"
                           min="1"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('standard_time') border-red-400 @enderror">
                    @error('standard_time')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Unit <span class="text-red-500">*</span>
                    </label>
                    <select name="unit"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                        <option value="per piece" {{ old('unit') == 'per piece' ? 'selected' : '' }}>Per Piece</option>
                        <option value="per box" {{ old('unit') == 'per box' ? 'selected' : '' }}>Per Box</option>
                        <option value="per sheet" {{ old('unit') == 'per sheet' ? 'selected' : '' }}>Per Sheet</option>
                        <option value="per 8ft" {{ old('unit') == 'per 8ft' ? 'selected' : '' }}>Per 8ft</option>
                        <option value="per kitchen" {{ old('unit') == 'per kitchen' ? 'selected' : '' }}>Per Kitchen</option>
                        <option value="per wardrobe" {{ old('unit') == 'per wardrobe' ? 'selected' : '' }}>Per Wardrobe</option>
                    </select>
                </div>
            </div>

            {{-- Description --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Description
                </label>
                <textarea name="description"
                          rows="2"
                          placeholder="Description about product..."
                          class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">{{ old('description') }}</textarea>
            </div>
            {{-- Active toggle --}}
            <div class="mb-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <div class="relative">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', '1') ? 'checked' : '' }}
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
                    Create 
                </button>
                <a href="{{ route('admin.fitting-types.index') }}"
                   class="text-gray-500 hover:text-gray-700 text-sm">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>

@endsection