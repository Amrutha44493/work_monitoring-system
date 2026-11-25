@extends('admin.layouts.app')

@section('title', 'Customers')
@section('subtitle', 'Manage customers')

@section('content')

<div class="flex items-center gap-3 mb-5 mt-2">
    <form method="GET"
          action="{{ route('admin.customers.index') }}"
          class="flex-1 flex gap-3">
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Search by name, phone or city..."
               class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
        <button type="submit"
                class="bg-gray-800 text-white px-4 py-2.5 rounded-xl text-sm hover:bg-gray-900 transition">
            Search
        </button>
        @if(request('search'))
            <a href="{{ route('admin.customers.index') }}"
               class="text-gray-400 text-sm self-center hover:text-gray-600">
                Clear
            </a>
        @endif
    </form>
    <a href="{{ route('admin.customers.create') }}"
       class="bg-orange-500 text-white px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-orange-600 transition flex items-center gap-1 flex-shrink-0">
        + Add Customer
    </a>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">#</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Customer</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Phone</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Email</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">City</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Projects</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($customers as $customer)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-4 text-sm text-gray-400">
                        {{ $loop->iteration }}
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 font-bold text-sm flex-shrink-0">
                                {{ substr($customer->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $customer->name }}
                                </p>
                                @if($customer->address)
                                    <p class="text-xs text-gray-400 truncate max-w-xs">
                                        {{ $customer->address }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-600">
                        {{ $customer->phone }}
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-500">
                        {{ $customer->email ?? '—' }}
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-500">
                        {{ $customer->city ?? '—' }}
                    </td>
                    <td class="px-5 py-4">
                        <span class="bg-orange-50 text-orange-700 text-xs px-2.5 py-1 rounded-full font-medium">
                            {{ $customer->projects()->count() }} projects
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.customers.edit', $customer) }}"
                               class="bg-gray-100 text-gray-600 hover:bg-orange-100 hover:text-orange-600 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                ✏️ Edit
                            </a>
                            <form method="POST"
                                  action="{{ route('admin.customers.destroy', $customer) }}"
                                  onsubmit="return confirm('Delete {{ $customer->name }}?')">
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
                        <p class="text-4xl mb-3">👤</p>
                        <p class="text-gray-500 font-medium">No customers yet!</p>
                        <a href="{{ route('admin.customers.create') }}"
                           class="text-orange-500 text-sm hover:underline mt-1 inline-block">
                            Add first customer →
                        </a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($customers->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $customers->links() }}
        </div>
    @endif
</div>

@endsection