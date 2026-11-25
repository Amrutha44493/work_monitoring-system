@extends('admin.layouts.app')
@section('title', 'Supervisors')
@section('subtitle', 'Manage Supervisors')

@section('content')

<div class="flex items-center justify-between mb-5 mt-2">
    <p class="text-sm text-gray-500">{{ $teamLeaders->total() }} Supervisors</p>
    <a href="{{ route('admin.team-leaders.create') }}"
       class="bg-orange-500 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-orange-600 transition">
        + Add Supervisor
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Supervisor</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Code</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Phone</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Email</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Team Size</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($teamLeaders as $tl)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600 font-bold text-sm">
                                {{ substr($tl->name, 0, 1) }}
                            </div>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ $tl->name }}
                            </p>
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        <span class="font-mono text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-lg">
                            {{ $tl->employee_code }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-600">{{ $tl->phone }}</td>
                    <td class="px-5 py-4 text-sm text-gray-500">{{ $tl->email ?? '—' }}</td>
                    <td class="px-5 py-4">
                        <span class="bg-blue-50 text-blue-700 text-xs px-2.5 py-1 rounded-full font-medium">
                            {{ $tl->team_members_count }} employees
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        @if($tl->is_active)
                            <span class="bg-green-50 text-green-700 text-xs px-2.5 py-1 rounded-full">Active</span>
                        @else
                            <span class="bg-red-50 text-red-700 text-xs px-2.5 py-1 rounded-full">Inactive</span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.team-leaders.edit', $tl) }}"
                               class="bg-gray-100 text-gray-600 hover:bg-orange-100 hover:text-orange-600 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                ✏️ Edit
                            </a>
                            <form method="POST"
                                  action="{{ route('admin.team-leaders.destroy', $tl) }}"
                                  onsubmit="return confirm('Delete {{ $tl->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-gray-100 text-gray-600 hover:bg-red-100 hover:text-red-600 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                    🗑️ Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-5 py-16 text-center">
                        <p class="text-4xl mb-3">👑</p>
                        <p class="text-gray-500">No Supervisors yet!</p>
                        <a href="{{ route('admin.team-leaders.create') }}"
                           class="text-orange-500 text-sm hover:underline mt-1 inline-block">
                            Add first Supervisor →
                        </a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @if($teamLeaders->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $teamLeaders->links() }}
        </div>
    @endif
</div>

@endsection