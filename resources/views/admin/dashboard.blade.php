@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('subtitle', 'Work Monitoring Overview')

@section('content')

{{-- Stats Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6 mt-2">

    {{-- Active Projects --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-xl">🏗️</div>
            <span class="text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded-full">Active</span>
        </div>
        <h3 class="text-2xl font-bold text-gray-900">{{ $stats['active_projects'] }}</h3>
        <p class="text-gray-500 text-xs mt-1">Active Projects</p>
    </div>

    {{-- Workers  --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center text-xl">👷</div>
            <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full font-medium animate-pulse">Live</span>
        </div>
        <h3 class="text-2xl font-bold text-gray-900">{{ $stats['working_now'] }}</h3>
        <p class="text-gray-500 text-xs mt-1">Working Right Now</p>
    </div>

    {{-- Completed Today --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center text-xl">✅</div>
            <span class="text-xs text-orange-600 bg-orange-50 px-2 py-1 rounded-full">Today</span>
        </div>
        <h3 class="text-2xl font-bold text-gray-900">{{ $stats['completed_today'] }}</h3>
        <p class="text-gray-500 text-xs mt-1">Tasks Completed Today</p>
    </div>

 <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm">
    <div class="flex items-center justify-between mb-3">
        <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center text-lg">
            ⏳
        </div>
        <span class="text-xs text-gray-400">Today</span>
    </div>
    <h3 class="text-2xl font-bold text-gray-900">
        {{ \App\Models\WorkAssignment::where('status','pending')->count() }}
    </h3>
    <p class="text-gray-500 text-sm mt-0.5">Pending Tasks</p>
</div>

</div>

{{-- Second Row --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm">
        <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center text-xl mb-3">⏳</div>
        <h3 class="text-2xl font-bold text-gray-900">{{ $stats['pending_assignments'] }}</h3>
        <p class="text-gray-500 text-xs mt-1">Pending Assignments</p>
    </div>

    <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm">
        <div class="w-10 h-10 bg-teal-100 rounded-xl flex items-center justify-center text-xl mb-3">👥</div>
        <h3 class="text-2xl font-bold text-gray-900">{{ $stats['total_employees'] }}</h3>
        <p class="text-gray-500 text-xs mt-1">Total Employees</p>
    </div>

    <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm">
        <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center text-xl mb-3">🏢</div>
        <h3 class="text-2xl font-bold text-gray-900">{{ $stats['total_customers'] }}</h3>
        <p class="text-gray-500 text-xs mt-1">Total Customers</p>
    </div>

    <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm">
        <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center text-xl mb-3">⚙️</div>
        <h3 class="text-2xl font-bold text-gray-900">{{ $stats['total_fitting_types'] }}</h3>
        <p class="text-gray-500 text-xs mt-1">Products</p>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Currently Working --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 bg-orange-500 rounded-full animate-pulse"></span>
                <h3 class="font-semibold text-gray-900">Currently Working</h3>
            </div>
            <a href="{{ route('admin.work-logs.index') }}" class="text-orange-500 text-sm hover:underline">
                View All →
            </a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($currentlyWorking as $log)
                <div class="flex items-center gap-4 p-4 hover:bg-gray-50 transition">
                    <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                        {{ substr($log->employee->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-900 text-sm">{{ $log->employee->name }}</p>
                        <p class="text-gray-400 text-xs truncate">{{ $log->fittingType->name }}</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="text-xs text-gray-500">Started</p>
                        <p class="text-sm font-medium text-green-600">
                            {{ $log->start_time->format('h:i A') }}
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="bg-green-100 text-green-700 text-xs px-2.5 py-1 rounded-full">
                            {{ $log->start_time->diffForHumans() }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <p class="text-4xl mb-3">😴</p>
                    <p class="text-gray-500 text-sm">No one is working right now!</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Right Column --}}
    <div class="space-y-6">

        {{-- Today's Summary --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
            <h3 class="font-semibold text-gray-900 mb-4">📊 Today's Summary</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">Total Work Time</span>
                    <span class="font-bold text-gray-900">{{ $todaySummary['total_actual_time'] }} mins</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">Standard Time</span>
                    <span class="font-bold text-gray-900">{{ $todaySummary['total_standard_time'] }} mins</span>
                </div>
                <div class="border-t border-gray-100 pt-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Time Difference</span>
                        <span class="font-bold {{ $todaySummary['variance'] <= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $todaySummary['variance'] > 0 ? '+' : '' }}{{ $todaySummary['variance'] }} mins
                        </span>
                    </div>
                </div>
                {{-- Efficiency Bar --}}
                <div class="pt-2">
                 
                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-500
                            {{ $stats['avg_efficiency'] >= 100 ? 'bg-orange-500' : 'bg-orange-500' }}"
                            style="width: {{ min($stats['avg_efficiency'], 100) }}%">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Projects --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">🏗️ Recent Projects</h3>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentProjects as $project)
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $project->name }}
                                </p>
                                <p class="text-xs text-gray-400 mt-0.5">
                               {{ $project->customer->name ?? '-' }}                                </p>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full
                                bg-{{ $project->status_color }}-100
                                text-{{ $project->status_color }}-700">
                                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-400 text-sm">
                        No projects yet!
                    </div>
                @endforelse
            </div>
            <div class="p-3 border-t border-gray-100">
                <a href="{{ route('admin.projects.index') }}"
                   class="text-orange-500 text-xs hover:underline">
                    View All Projects →
                </a>
            </div>
        </div>

    </div>
</div>

@endsection