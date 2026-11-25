@extends('admin.layouts.app')

@section('title', 'New Project')
@section('subtitle', 'Create a new project')

@section('content')

<div class="mb-5 mt-2">
    <a href="{{ route('admin.projects.index') }}"
       class="text-gray-500 hover:text-orange-500 text-sm transition">
        ← Back to Projects
    </a>
</div>

<form method="POST"
      action="{{ route('admin.projects.store') }}"
      x-data="projectForm()">
@csrf

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <div class="lg:col-span-2 space-y-5">

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <span class="w-6 h-6 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center text-xs">1</span>
                Project Details
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- Customer --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Customer <span class="text-red-500">*</span>
                    </label>
                    <select name="customer_id"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('customer_id') border-red-400 @enderror">
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}"
                                {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} — {{ $customer->phone }}
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

<div class="md:col-span-2">
    <label class="block text-sm font-medium text-gray-700 mb-1.5">
        Assign Supervisor
    </label>
    <select name="team_leader_id"
            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
        <option value="">Select Supervisor</option>
        @foreach(\App\Models\Employee::teamLeaders()->active()->get() as $tl)
            <option value="{{ $tl->id }}"
                {{ old('team_leader_id') == $tl->id ? 'selected' : '' }}>
                {{ $tl->name }} — {{ $tl->employee_code }}
            </option>
        @endforeach
    </select>
</div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Project Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           placeholder="e.g. Kitchen Fitting — PP House"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('name') border-red-400 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Site Address --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Site Address
                    </label>
                    <textarea name="site_address"
                              rows="2"
                              placeholder="Location..."
                              class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">{{ old('site_address') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Site City
                    </label>
                    <input type="text"
                           name="site_city"
                           value="{{ old('site_city') }}"
                           placeholder="Calicut"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                        <option value="pending" {{ old('status','pending') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>🔄 In Progress</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>✅ Completed</option>
                        <option value="on_hold" {{ old('status') == 'on_hold' ? 'selected' : '' }}>⏸️ On Hold</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Start Date
                    </label>
                    <input type="date"
                           name="start_date"
                           value="{{ old('start_date') }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Expected End Date
                    </label>
                    <input type="date"
                           name="expected_end_date"
                           value="{{ old('expected_end_date') }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                </div>

                {{-- Notes --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Notes
                    </label>
                    <textarea name="notes"
                              rows="2"
                              placeholder="Notes..."
                              class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">{{ old('notes') }}</textarea>
                </div>

            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <span class="w-6 h-6 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center text-xs">2</span>
                Products
                <span class="text-gray-400 font-normal text-xs">(add products to be fitted)</span>
            </h3>

            {{-- Category Filter --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Filter by Category
                </label>
                <select x-model="selectedCategory"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-2 mb-4">
                <template x-for="(item, index) in items" :key="index">
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-200">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900" x-text="item.name"></p>
                            <p class="text-xs text-gray-400">
                                Std time: <span x-text="item.standard_time"></span> mins/unit
                            </p>
                        </div>
        <div class="flex items-center gap-2">
                            <input type="number"
                                   :name="'items[' + index + '][fitting_type_id]'"
                                   :value="item.id"
                                   class="hidden">
                            <input type="number"
                                   :name="'items[' + index + '][quantity]'"
                                   x-model="item.quantity"
                                   min="1"
                                   placeholder="Qty"
                                   class="w-20 border border-gray-300 rounded-lg px-3 py-1.5 text-sm text-center focus:outline-none focus:ring-2 focus:ring-orange-400">
                            <span class="text-xs text-gray-400">
                                = <span x-text="(item.standard_time * item.quantity) + ' mins'"></span>
                            </span>
            </div>
                        <button type="button"
                                @click="removeItem(index)"
                                class="text-red-400 hover:text-red-600 transition text-lg leading-none">
                            ×
                        </button>
                    </div>
                </template>

                <div x-show="items.length === 0"
                     class="text-center py-8 text-gray-400 text-sm border-2 border-dashed border-gray-200 rounded-xl">
                    No items added yet. Select products below to add!
                </div>
            </div>

            <div x-show="items.length > 0"
                 class="bg-orange-50 border border-orange-200 rounded-xl p-3 mb-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-orange-700 font-medium">
                        Total Standard Time
                    </span>
                    <span class="font-bold text-orange-700">
                        <span x-text="totalTime"></span> mins
                        (<span x-text="Math.floor(totalTime/60)"></span>h
                        <span x-text="totalTime%60"></span>m)
                    </span>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-4">
                <p class="text-xs font-semibold text-gray-500 uppercase mb-3">
                    Click to Add Products:
                </p>
                @foreach($categories as $category)
                    <div x-show="selectedCategory === '' || selectedCategory === '{{ $category->id }}'">
                        <p class="text-xs font-semibold text-gray-400 uppercase mb-2 mt-3">
                            {{ $category->name }}
                        </p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($category->fittingTypes as $type)
                                <button type="button"
                                        @click="addItem({{ $type->id }}, '{{ $type->name }}', {{ $type->standard_time }})"
                                        class="text-xs px-3 py-1.5 bg-gray-100 hover:bg-orange-100 hover:text-orange-700 text-gray-600 rounded-lg transition border border-gray-200 hover:border-orange-300">
                                    + {{ $type->name }}
                                    <span class="text-gray-400">({{ $type->standard_time }}m)</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

    </div>

    <div class="space-y-5">

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">
                📋 Project Summary
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Total Items</span>
                    <span class="font-bold text-gray-900" x-text="items.length"></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Standard Time</span>
                    <span class="font-bold text-gray-900">
                        <span x-text="totalTime"></span> mins
                    </span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">In Hours</span>
                    <span class="font-bold text-orange-600">
                        <span x-text="Math.floor(totalTime/60)"></span>h
                        <span x-text="totalTime%60"></span>m
                    </span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Work Days (8h)</span>
                    <span class="font-bold text-gray-900">
                        ~<span x-text="Math.ceil(totalTime/480)"></span> days
                    </span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
            <button type="submit"
                    class="w-full bg-orange-500 text-white py-3 rounded-xl font-semibold text-sm hover:bg-orange-600 transition mb-3">
                 Create 
            </button>
            <a href="{{ route('admin.projects.index') }}"
               class="block text-center text-gray-400 text-sm hover:text-gray-600">
                Cancel
            </a>
        </div>

    </div>

</div>

</form>

{{-- Alpine.js Script --}}
<script>
function projectForm() {
    return {
        items: [],
        selectedCategory: '',

        get totalTime() {
            return this.items.reduce((sum, item) => {
                return sum + (item.standard_time * (item.quantity || 1));
            }, 0);
        },

        addItem(id, name, standardTime) {
            const exists = this.items.find(i => i.id === id);
            if(exists) {
                exists.quantity++;
                return;
            }
            this.items.push({
                id: id,
                name: name,
                standard_time: standardTime,
                quantity: 1
            });
        },

        removeItem(index) {
            this.items.splice(index, 1);
        }
    }
}
</script>

@endsection