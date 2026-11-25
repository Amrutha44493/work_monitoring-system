@extends('admin.layouts.app')

@section('title', 'Product Master')
@section('subtitle', 'Manage Products')

@section('content')

{{-- Filter Bar --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 mb-5 mt-2">
    <form method="GET"
          action="{{ route('admin.fitting-types.index') }}"
          class="flex items-center gap-3 flex-wrap">

        <input type="text"
               name="search"
               value="{{ request('search') }}"
                placeholder="Search Products..."
               class="flex-1 min-w-48 border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">

        <select name="category_id"
                class="border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}"
                    {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        <button type="submit"
                class="bg-gray-800 text-white px-4 py-2 rounded-xl text-sm hover:bg-gray-900 transition">
            Filter
        </button>

        <a href="{{ route('admin.fitting-types.index') }}"
           class="text-gray-400 text-sm hover:text-gray-600">
            Clear
        </a>

        <a href="{{ route('admin.fitting-types.create') }}"
           class="ml-auto bg-orange-500 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-orange-600 transition flex items-center gap-1">
            + Add New
        </a>

    </form>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">#</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Name</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Category</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Std Time</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Unit</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($fittingTypes as $type)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-3.5 text-sm text-gray-400">
                        {{ $fittingTypes->firstItem() + $loop->index }}
                    </td>
                    <td class="px-5 py-3.5">
                        <p class="text-sm font-medium text-gray-900">
                            {{ $type->name }}
                        </p>
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="bg-orange-50 text-orange-700 text-xs px-2.5 py-1 rounded-full font-medium">
                            {{ $type->category->name ?? '—' }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-gray-900">
                                {{ $type->standard_time }}
                            </span>
                            <span class="text-xs text-gray-400">mins</span>
                            <span class="text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full">
                                {{ $type->formatted_time }}
                            </span>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-sm text-gray-500">
                        {{ $type->unit }}
                    </td>
                    <td class="px-5 py-3.5">
                        @if($type->is_active)
                            <span class="bg-green-50 text-green-700 text-xs px-2.5 py-1 rounded-full">Active</span>
                        @else
                            <span class="bg-red-50 text-red-700 text-xs px-2.5 py-1 rounded-full">Inactive</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.fitting-types.edit', $type) }}"
                               class="bg-gray-100 text-gray-600 hover:bg-green-100 hover:text-orange-600 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                ✏️ Edit
                            </a>
                            <form method="POST"
                                  action="{{ route('admin.fitting-types.destroy', $type) }}"
                                  onsubmit="return confirm('Delete {{ $type->name }}?')">
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
                        <p class="text-4xl mb-3">⚙️</p>
                        <p class="text-gray-500 font-medium">No Products found!</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($fittingTypes->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $fittingTypes->links() }}
        </div>
    @endif
</div>

@endsection