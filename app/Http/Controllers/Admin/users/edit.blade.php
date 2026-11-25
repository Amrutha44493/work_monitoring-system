@extends('admin.layouts.app')
@section('title', 'Edit User')
@section('subtitle', 'Update user role and password')

@section('content')

<div class="mb-5 mt-2">
    <a href="{{ route('admin.users.index') }}"
       class="text-gray-500 hover:text-orange-500 text-sm">← Back</a>
</div>

<div class="max-w-xl">
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">

        <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-100">
            <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center font-bold text-lg">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div>
                <h3 class="font-semibold text-gray-900">{{ $user->name }}</h3>
                <p class="text-xs text-gray-400">{{ $user->email }}</p>
            </div>
        </div>

        <form method="POST"
              action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')

            {{-- Role --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Role <span class="text-red-500">*</span>
                </label>
                <select name="role"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}"
                            {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_',' ',$role->name)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Change Password --}}
            <div class="border-t border-gray-100 pt-5 mb-5">
                <p class="text-sm font-medium text-gray-700 mb-3">
                    Change Password
                    <span class="text-gray-400 font-normal">(leave blank to keep current)</span>
                </p>

                <div class="mb-3">
                    <label class="block text-sm text-gray-600 mb-1.5">New Password</label>
                    <input type="password" name="password"
                           placeholder="Min 6 characters"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-1.5">Confirm Password</label>
                    <input type="password" name="password_confirmation"
                           placeholder="Repeat password"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                </div>
            </div>

            <div class="flex gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="bg-orange-500 text-white px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-orange-600 transition">
                    Update 
                </button>
                <a href="{{ route('admin.users.index') }}"
                   class="text-gray-500 text-sm self-center">Cancel</a>
            </div>

        </form>
    </div>
</div>

@endsection