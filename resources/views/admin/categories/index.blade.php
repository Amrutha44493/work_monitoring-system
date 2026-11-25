@extends('admin.layouts.app')

@section('title', 'Category Master')
@section('subtitle', 'Manage Product categories')

@section('content')

{{-- Header --}}
<div class="flex items-center justify-between mb-5 mt-2">
    <div>
        <p class="text-sm text-gray-500">
            {{ $categories->total() }} categories total
        </p>
    </div>
    <a href="{{ route('admin.categories.create') }}"
       class="flex items-center gap-2 bg-orange-500 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-orange-600 transition">
        <span>+</span> Add Category
    </a>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">#</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Name</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Description</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Products</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($categories as $category)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-4 text-sm text-gray-400">
                        {{ $loop->iteration }}
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-green-100 rounded-xl flex items-center justify-center text-orange-600 font-bold text-sm">
                                {{ substr($category->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $category->name }}
                                </p>
                                <p class="text-xs text-gray-400">
                                    {{ $category->slug }}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-500 max-w-xs">
                        <p class="truncate">
                            {{ $category->description ?? '—' }}
                        </p>
                    </td>
                    <td class="px-5 py-4">
                        <span class="bg-blue-50 text-blue-700 text-xs px-2.5 py-1 rounded-full font-medium">
                            {{ $category->fitting_types_count }} types
                        </span>
                    </td>
                 
                    <td class="px-5 py-4">
                        @if($category->is_active)
                            <span class="bg-green-50 text-green-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                Active
                            </span>
                        @else
                            <span class="bg-red-50 text-red-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                Inactive
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.categories.edit', $category) }}"
                               class="bg-gray-100 text-gray-600 hover:bg-orange-100 hover:text-orange-600 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                ✏️ Edit
                            </a>
                            <form method="POST"
                                  action="{{ route('admin.categories.destroy', $category) }}"
                                  onsubmit="return confirm('Delete {{ $category->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-gray-100 text-gray-600 hover:bg-red-100 hover:text-red-600 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                    🗑️ Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-5 py-16 text-center">
                        <p class="text-4xl mb-3">📁</p>
                        <p class="text-gray-500 font-medium">No categories yet!</p>
                        <a href="{{ route('admin.categories.create') }}"
                           class="text-orange-500 text-sm hover:underline mt-1 inline-block">
                            Add first category →
                        </a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($categories->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $categories->links() }}
        </div>
    @endif
</div>

@endsection