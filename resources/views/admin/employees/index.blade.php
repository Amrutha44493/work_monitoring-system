@extends('admin.layouts.app')

@section('title', 'Employees')
@section('subtitle', 'Manage employees ')

@section('content')

{{-- Filter + Add --}}
<div class="flex items-center gap-3 mb-5 mt-2 flex-wrap">
    <form method="GET"
          action="{{ route('admin.employees.index') }}"
          class="flex gap-3 flex-1">
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Search by name, code or phone..."
               class="flex-1 min-w-48 border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
        <select name="role"
                class="border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            <option value="">All Roles</option>
            <option value="employee" {{ request('role') == 'employee' ? 'selected' : '' }}>
                Employee
            </option>
            <option value="team_leader" {{ request('role') == 'team_leader' ? 'selected' : '' }}>
                Supervisor
            </option>
        </select>
        <button type="submit"
                class="bg-gray-800 text-white px-4 py-2.5 rounded-xl text-sm hover:bg-gray-900 transition">
            Filter
        </button>
        @if(request('search') || request('role'))
            <a href="{{ route('admin.employees.index') }}"
               class="text-gray-400 text-sm self-center">Clear</a>
        @endif
    </form>
    <a href="{{ route('admin.employees.create') }}"
       class="bg-orange-500 text-white px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-orange-600 transition flex-shrink-0">
        + Add Employee
    </a>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Employee</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Code</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Phone</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Role</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Supervisor</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($employees as $emp)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-sm flex-shrink-0
                                {{ $emp->role == 'team_leader'
                                   ? 'bg-purple-100 text-purple-600'
                                   : 'bg-blue-100 text-blue-600' }}">
                                {{ substr($emp->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $emp->name }}
                                </p>
                                @if($emp->email)
                                    <p class="text-xs text-gray-400">{{ $emp->email }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        <span class="font-mono text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-lg">
                            {{ $emp->employee_code }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-600">
                        {{ $emp->phone }}
                    </td>
                    <td class="px-5 py-4">
                        @if($emp->role == 'team_leader')
                            <span class="bg-purple-50 text-purple-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                👑 Supervisor
                            </span>
                        @else
                            <span class="bg-blue-50 text-blue-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                👷 Employee
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-500">
                        {{ $emp->teamLeader->name ?? '—' }}
                    </td>
                    <td class="px-5 py-4">
                        @if($emp->is_active)
                            <span class="bg-green-50 text-green-700 text-xs px-2.5 py-1 rounded-full">Active</span>
                        @else
                            <span class="bg-red-50 text-red-700 text-xs px-2.5 py-1 rounded-full">Inactive</span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.employees.edit', $emp) }}"
                               class="bg-gray-100 text-gray-600 hover:bg-orange-100 hover:text-orange-600 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                ✏️ Edit
                            </a>
                            <form method="POST"
                                  action="{{ route('admin.employees.destroy', $emp) }}"
                                  onsubmit="return confirm('Delete {{ $emp->name }}?')">
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
                        <p class="text-4xl mb-3">👷</p>
                        <p class="text-gray-500 font-medium">No employees yet!</p>
                        <a href="{{ route('admin.employees.create') }}"
                           class="text-orange-500 text-sm hover:underline mt-1 inline-block">
                            Add first employee →
                        </a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($employees->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $employees->links() }}
        </div>
    @endif
</div>

@endsection