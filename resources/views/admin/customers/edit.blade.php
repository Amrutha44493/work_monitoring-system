@extends('admin.layouts.app')

@section('title', 'Edit Customer')
@section('subtitle', 'Update customer Details')

@section('content')

<div class="mb-5 mt-2">
    <a href="{{ route('admin.customers.index') }}"
       class="text-gray-500 hover:text-orange-500 text-sm transition">
        ← Back to Customers
    </a>
</div>

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">

        <h3 class="text-base font-semibold text-gray-900 mb-5 pb-4 border-b border-gray-100">
            Edit: {{ $customer->name }}
        </h3>

        <form method="POST"
              action="{{ route('admin.customers.update', $customer) }}">
        @csrf
        @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Customer Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name"
                           value="{{ old('name', $customer->name) }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Phone <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="phone"
                           value="{{ old('phone', $customer->phone) }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input type="email" name="email"
                           value="{{ old('email', $customer->email) }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Address</label>
                    <textarea name="address" rows="2"
                              class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">{{ old('address', $customer->address) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">City</label>
                    <input type="text" name="city"
                           value="{{ old('city', $customer->city) }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">State</label>
                    <input type="text" name="state"
                           value="{{ old('state', $customer->state) }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                </div>

            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="bg-orange-500 text-white px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-orange-600 transition">
                    Update 
                </button>
                <a href="{{ route('admin.customers.index') }}"
                   class="text-gray-500 text-sm">Cancel</a>
            </div>

        </form>
    </div>
</div>

@endsection