@extends('admin.layouts.app')

@section('title', 'Edit Products')
@section('subtitle', 'Update Products')

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
            Edit: {{ $fittingType->name }}
        </h3>

        <form method="POST"
              action="{{ route('admin.fitting-types.update', $fittingType) }}">
        @csrf
        @method('PUT')

            {{-- Category --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Category <span class="text-red-500">*</span>
                </label>
                <select name="category_id"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('category_id', $fittingType->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Name --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Product Name <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $fittingType->name) }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>

            {{-- Standard Time + Unit --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Standard Time (minutes) <span class="text-red-500">*</span>
                    </label>
                    <input type="number"
                           name="standard_time"
                           value="{{ old('standard_time', $fittingType->standard_time) }}"
                           min="1"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Unit <span class="text-red-500">*</span>
                    </label>
                    <select name="unit"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                        @foreach(['per piece','per box','per sheet','per 8ft','per kitchen','per wardrobe'] as $unit)
                            <option value="{{ $unit }}"
                                {{ old('unit', $fittingType->unit) == $unit ? 'selected' : '' }}>
                                {{ ucfirst($unit) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Description --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                <textarea name="description" rows="2"
                          class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">{{ old('description', $fittingType->description) }}</textarea>
            </div>

           

            {{-- Active --}}
            <div class="mb-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <div class="relative">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $fittingType->is_active) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-10 h-6 bg-gray-200 rounded-full peer peer-checked:bg-orange-500 transition"></div>
                        <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow peer-checked:translate-x-4 transition"></div>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Active</span>
                </label>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="bg-orange-500 text-white px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-orange-600 transition">
                    Update 
                </button>
                <a href="{{ route('admin.fitting-types.index') }}"
                   class="text-gray-500 hover:text-gray-700 text-sm">Cancel</a>
            </div>

        </form>
    </div>
</div>

@endsection