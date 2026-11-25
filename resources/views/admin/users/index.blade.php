@extends('admin.layouts.app')
@section('title', 'Users & Permissions')
@section('subtitle', 'Manage users and roles')

@section('content')

<div class="flex items-center justify-between mb-5 mt-2">
    <p class="text-sm text-gray-500">
        {{ $users->total() }} users total
    </p>
</div>

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">#</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Name</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Email</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Role</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Created</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($users as $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-4 text-sm text-gray-400">
                        {{ $loop->iteration }}
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-sm
                                {{ $user->hasRole('admin') ? 'bg-red-100 text-red-600' : ($user->hasRole('team_leader') ? 'bg-purple-100 text-purple-600' : 'bg-blue-100 text-blue-600') }}">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ $user->name }}
                                @if($user->id === auth()->id())
                                    <span class="text-xs text-orange-500">(You)</span>
                                @endif
                            </p>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-500">
                        {{ $user->email }}
                    </td>
                    <td class="px-5 py-4">
                       {{-- Role Badge --}}
@foreach($user->roles as $role)
    @php
        $roleName = match($role->name) {
            'admin'       => 'Admin',
            'team_leader' => 'Supervisor', // ← Fix here!
            'employee'    => 'Employee',
            default       => ucfirst($role->name),
        };
        $roleColor = match($role->name) {
            'admin'       => 'red',
            'team_leader' => 'purple',
            'employee'    => 'blue',
            default       => 'gray',
        };
    @endphp
    <span class="text-xs px-2.5 py-1 rounded-full font-medium
        bg-{{ $roleColor }}-100 text-{{ $roleColor }}-700">
        {{ $roleName }}
    </span>
@endforeach
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-500">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="bg-gray-100 text-gray-600 hover:bg-orange-100 hover:text-orange-600 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                ✏️ Edit
                            </a>
                            @if($user->id !== auth()->id())
                                <form method="POST"
                                      action="{{ route('admin.users.destroy', $user) }}"
                                      onsubmit="return confirm('Delete {{ $user->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-gray-100 text-gray-600 hover:bg-red-100 hover:text-red-600 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                        🗑️ Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-5 py-16 text-center text-gray-400">
                        No users found!
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($users->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    @endif
</div>

@endsection