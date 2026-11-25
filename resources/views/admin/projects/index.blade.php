@extends('admin.layouts.app')

@section('title', 'Projects')
@section('subtitle', 'Manage all projects')

@section('content')

{{-- Filter Bar --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 mb-5 mt-2">
    <form method="GET"
          action="{{ route('admin.projects.index') }}"
          class="flex items-center gap-3 flex-wrap">

        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Search project name or code..."
               class="flex-1 min-w-48 border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">

        <select name="customer_id"
                class="border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            <option value="">All Customers</option>
            @foreach($customers as $c)
                <option value="{{ $c->id }}"
                    {{ request('customer_id') == $c->id ? 'selected' : '' }}>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>

        <select name="status"
                class="border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            <option value="">All Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="on_hold" {{ request('status') == 'on_hold' ? 'selected' : '' }}>On Hold</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>

        <button type="submit"
                class="bg-gray-800 text-white px-4 py-2 rounded-xl text-sm hover:bg-gray-900 transition">
            Filter
        </button>

        @if(request()->hasAny(['search','status','customer_id']))
            <a href="{{ route('admin.projects.index') }}"
               class="text-gray-400 text-sm hover:text-gray-600">
                Clear
            </a>
        @endif

        <a href="{{ route('admin.projects.create') }}"
           class="ml-auto bg-orange-500 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-orange-600 transition flex-shrink-0">
            + New Project
        </a>

    </form>
</div>

{{-- Stats Row --}}
<div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-5">
    @foreach([
        ['label' => 'Total', 'status' => null, 'color' => 'gray'],
        ['label' => 'Pending', 'status' => 'pending', 'color' => 'yellow'],
        ['label' => 'In Progress', 'status' => 'in_progress', 'color' => 'blue'],
        ['label' => 'Completed', 'status' => 'completed', 'color' => 'green'],
        ['label' => 'On Hold', 'status' => 'on_hold', 'color' => 'orange'],
    ] as $stat)
        <div class="bg-white rounded-xl border border-gray-200 p-3 text-center">
            <p class="text-xl font-bold text-gray-900">
                {{ $stat['status']
                    ? \App\Models\Project::where('status', $stat['status'])->count()
                    : \App\Models\Project::count() }}
            </p>
            <p class="text-xs text-gray-400 mt-0.5">{{ $stat['label'] }}</p>
        </div>
    @endforeach
</div>

{{-- Projects Table --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Project</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Customer</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase"> Supervisor</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Location</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Items</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Timeline</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($projects as $project)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-4">
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $project->name }}
                        </p>
                        <p class="text-xs font-mono text-gray-400 mt-0.5">
                            {{ $project->project_code }}
                        </p>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 font-bold text-xs flex-shrink-0">
                               {{ substr($project->customer->name ?? '-', 0, 1) }}
                            </div>
                            <span class="text-sm text-gray-700">
{{ $project->customer->name ?? 'No customer' }}
                            </span>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-500">
    {{ $project->teamLeader->name ?? '—' }}
</td>
                    <td class="px-5 py-4 text-sm text-gray-500">
                        {{ $project->site_city ?? '—' }}
                    </td>
                    <td class="px-5 py-4">
                        <span class="bg-orange-50 text-orange-700 text-xs px-2.5 py-1 rounded-full font-medium">
                            {{ $project->fittingItems()->count() }} items
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        @if($project->start_date)
                            <p class="text-xs text-gray-500">
                                Start: {{ $project->start_date->format('d M Y') }}
                            </p>
                        @endif
                        @if($project->expected_end_date)
                            <p class="text-xs text-gray-400">
                                End: {{ $project->expected_end_date->format('d M Y') }}
                            </p>
                        @endif
                        @if(!$project->start_date && !$project->expected_end_date)
                            <span class="text-gray-400 text-xs">—</span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium
                            bg-{{ $project->status_color }}-100
                            text-{{ $project->status_color }}-700">
                            {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.projects.show', $project) }}"
                               class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                👁️ View
                            </a>
                            <a href="{{ route('admin.projects.edit', $project) }}"
                               class="bg-gray-100 text-gray-600 hover:bg-orange-100 hover:text-orange-600 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                ✏️ Edit
                            </a>
                            <form method="POST"
                                  action="{{ route('admin.projects.destroy', $project) }}"
                                  onsubmit="return confirm('Delete {{ $project->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-gray-100 text-gray-600 hover:bg-red-100 hover:text-red-600 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-5 py-16 text-center">
                        <p class="text-4xl mb-3">🏗️</p>
                        <p class="text-gray-500 font-medium">No projects yet!</p>
                        <a href="{{ route('admin.projects.create') }}"
                           class="text-orange-500 text-sm hover:underline mt-1 inline-block">
                            Create first project →
                        </a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($projects->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $projects->links() }}
        </div>
    @endif
</div>

@endsection