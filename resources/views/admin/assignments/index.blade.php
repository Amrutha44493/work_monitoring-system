@extends('admin.layouts.app')
@section('title', 'Work Assignments')
@section('subtitle', 'All work assignments')

@section('content')

{{-- Filter --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 mb-5 mt-2">
    <form method="GET"
          action="{{ route('admin.assignments.index') }}"
          class="flex items-center gap-3 flex-wrap">

        <select name="project_id"
                class="border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            <option value="">All Projects</option>
            @foreach($projects as $p)
                <option value="{{ $p->id }}"
                    {{ request('project_id') == $p->id ? 'selected' : '' }}>
                    {{ $p ->name ?? '-' }}
                </option>
            @endforeach
        </select>

        <select name="status"
                class="border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            <option value="">All Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
        </select>

        <button type="submit"
                class="bg-gray-800 text-white px-4 py-2 rounded-xl text-sm hover:bg-gray-900 transition">
            Filter
        </button>

        @if(request('project_id') || request('status'))
            <a href="{{ route('admin.assignments.index') }}"
               class="text-gray-400 text-sm">Clear</a>
        @endif


    </form>
</div>

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Employee</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Project</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Product</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Qty</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Std Time</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($assignments as $a)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center font-bold text-xs flex-shrink-0">
                                {{ substr($a->employee->name ?? '-', 0, 1) }}
                            </div>
                            <p class="text-sm font-medium text-gray-900">
                                {{ $a->employee ->name ?? '-' }}
                            </p>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-sm text-gray-600">
                        {{ $a->project->name ?? '—' }}
                    </td>
                    <td class="px-5 py-3.5 text-sm text-gray-600">
                        {{ $a->fittingType ->name ?? '-' }}
                    </td>
                    <td class="px-5 py-3.5 text-sm text-gray-600">
                        {{ $a->quantity }}
                    </td>
                    <td class="px-5 py-3.5 text-sm font-medium text-gray-900">
                        {{ $a->standard_time }} mins
                    </td>
                    <td class="px-5 py-3.5 text-sm text-gray-500">
                        {{ $a->assigned_date->format('d M Y') }}
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium
                            bg-{{ $a->status_color }}-100
                            text-{{ $a->status_color }}-700">
                            {{ ucfirst($a->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5">
                        @if($a->status == 'pending')
                            <form method="POST"
                                  action="{{ route('admin.assignments.destroy', $a) }}"
                                  onsubmit="return confirm('Remove?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-400 hover:text-red-600 text-xs transition">
                                    Remove
                                </button>
                            </form>
                        @else
                            <span class="text-xs text-gray-400">
                                {{ ucfirst($a->status) }}
                            </span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-5 py-12 text-center text-gray-400 text-sm">
                        No assignments yet!
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($assignments->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $assignments->links() }}
        </div>
    @endif
</div>

@endsection