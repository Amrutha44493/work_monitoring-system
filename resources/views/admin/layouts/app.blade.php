<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='22' fill='%23f97316'/><text x='50' y='72' font-size='64' font-weight='bold' text-anchor='middle' fill='white' font-family='Arial'>L</text></svg>">
<title>@yield('title', 'Dashboard') | LIRA Kitchen Interiors</title>    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">

<div class="flex h-screen overflow-hidden">
<aside class="w-60 bg-gray-900 text-white flex-shrink-0 flex flex-col"
       style="z-index: 50;">
      {{-- Logo --}}
<div class="px-4 py-5 border-b border-gray-800 text-center flex-shrink-0">
    <h1 class="text-3xl font-extrabold text-white tracking-[0.25em] pl-[0.25em]">
        LIRA
    </h1>
    <div class="flex items-center justify-center gap-2 mt-1">
        <span class="h-px w-4 bg-orange-400"></span>
        <p class="text-[10px] font-semibold tracking-[0.2em] text-orange-400 uppercase">
            Kitchen Interiors
        </p>
        <span class="h-px w-4 bg-orange-400"></span>
    </div>
</div>

   <nav class="flex-1 p-2 flex flex-col gap-0.5 overflow-y-auto">

    {{-- Dashboard --}}
    <a href="{{ route('admin.dashboard') }}"
       class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition
              {{ request()->routeIs('admin.dashboard') ? 'bg-orange-500 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
        <span>📊</span> Dashboard
    </a>
    {{-- MASTERS SUBMENU --}}
    <div x-data="{ open: {{ request()->routeIs('admin.categories*','admin.fitting-types*','admin.customers*','admin.team-leaders*','admin.employees*','admin.projects*','admin.users*') ? 'true' : 'false' }} }">
        <button @click="open = !open"
                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition w-full
                       {{ request()->routeIs('admin.categories*','admin.fitting-types*','admin.customers*','admin.team-leaders*','admin.employees*','admin.projects*','admin.users*') ? 'bg-orange-500 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <span>🗂️</span>
            <span class="flex-1 text-left">Masters</span>
            <svg :class="open ? 'rotate-180' : ''"
                 class="w-3 h-3 transition-transform flex-shrink-0"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <div x-show="open" x-transition
             class="ml-2 mt-0.5 border-l border-gray-700 pl-2 space-y-0.5">
            <a href="{{ route('admin.categories.index') }}"
               class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs transition
                      {{ request()->routeIs('admin.categories*') ? 'text-orange-400 bg-gray-800' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <span>📁</span> Categories
            </a>
            <a href="{{ route('admin.fitting-types.index') }}"
               class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs transition
                      {{ request()->routeIs('admin.fitting-types*') ? 'text-orange-400 bg-gray-800' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <span>⚙️</span> Products
            </a>
            <a href="{{ route('admin.team-leaders.index') }}"
               class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs transition
                      {{ request()->routeIs('admin.team-leaders*') ? 'text-orange-400 bg-gray-800' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <span>👑</span> Supervisors
            </a>
            <a href="{{ route('admin.employees.index') }}"
               class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs transition
                      {{ request()->routeIs('admin.employees*') ? 'text-orange-400 bg-gray-800' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <span>👷</span> Employees
            </a>
            <a href="{{ route('admin.customers.index') }}"
               class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs transition
                      {{ request()->routeIs('admin.customers*') ? 'text-orange-400 bg-gray-800' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <span>👤</span> Customers
            </a>
            <a href="{{ route('admin.projects.index') }}"
               class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs transition
                      {{ request()->routeIs('admin.projects*') ? 'text-orange-400 bg-gray-800' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <span>🏗️</span> Projects
            </a>
            <a href="{{ route('admin.users.index') }}"
               class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs transition
                      {{ request()->routeIs('admin.users*') ? 'text-orange-400 bg-gray-800' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <span>🔐</span> Users
            </a>
        </div>
    </div>

    {{-- WORK SUBMENU --}}
    <div x-data="{ open: {{ request()->routeIs('admin.work-logs*','admin.assignments*') ? 'true' : 'false' }} }">
        <button @click="open = !open"
                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition w-full
                       {{ request()->routeIs('admin.work-logs*','admin.assignments*') ? 'bg-orange-500 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <span>⚡</span>
            <span class="flex-1 text-left">Work</span>
            @php $activeCount = \App\Models\WorkLog::where('status','started')->count(); @endphp
            @if($activeCount > 0)
                <span class="bg-green-500 text-white text-xs px-1.5 py-0.5 rounded-full animate-pulse mr-1">
                    {{ $activeCount }}
                </span>
            @endif
            <svg :class="open ? 'rotate-180' : ''"
                 class="w-3 h-3 transition-transform flex-shrink-0"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <div x-show="open" x-transition
             class="ml-2 mt-0.5 border-l border-gray-700 pl-2 space-y-0.5">
            <a href="{{ route('admin.work-logs.index') }}"
               class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs transition
                      {{ request()->routeIs('admin.work-logs*') ? 'text-orange-400 bg-gray-800' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <span>⏱️</span> Work Status
            </a>
            <a href="{{ route('admin.assignments.index') }}"
               class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs transition
                      {{ request()->routeIs('admin.assignments*') ? 'text-orange-400 bg-gray-800' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <span>📋</span> Work Assignment
            </a>
        </div>
    </div>

    {{-- REPORTS SUBMENU --}}
    <div x-data="{ open: {{ request()->routeIs('admin.reports*') ? 'true' : 'false' }} }">
        <button @click="open = !open"
                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition w-full
                       {{ request()->routeIs('admin.reports*') ? 'bg-orange-500 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <span>📈</span>
            <span class="flex-1 text-left">Reports</span>
            <svg :class="open ? 'rotate-180' : ''"
                 class="w-3 h-3 transition-transform flex-shrink-0"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <div x-show="open" x-transition
             class="ml-2 mt-0.5 border-l border-gray-700 pl-2 space-y-0.5">
            <a href="{{ route('admin.reports.daily') }}"
               class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs transition
                      {{ request()->routeIs('admin.reports.daily') ? 'text-orange-400 bg-gray-800' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <span>📅</span> Daily
            </a>
            <a href="{{ route('admin.reports.employee') }}"
               class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs transition
                      {{ request()->routeIs('admin.reports.employee') ? 'text-orange-400 bg-gray-800' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <span>👷</span> Employee
            </a>
            <a href="{{ route('admin.reports.productivity') }}"
               class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs transition
                      {{ request()->routeIs('admin.reports.productivity') ? 'text-orange-400 bg-gray-800' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <span>📊</span> Productivity
            </a>
            <a href="{{ route('admin.reports.standard-vs-actual') }}"
               class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs transition
                      {{ request()->routeIs('admin.reports.standard-vs-actual') ? 'text-orange-400 bg-gray-800' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <span>⚖️</span> Std vs Actual
            </a>
            <a href="{{ route('admin.reports.pending') }}"
               class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs transition
                      {{ request()->routeIs('admin.reports.pending') ? 'text-orange-400 bg-gray-800' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <span>⏳</span> Pending
            </a>
            <a href="{{ route('admin.reports.completed') }}"
               class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs transition
                      {{ request()->routeIs('admin.reports.completed') ? 'text-orange-400 bg-gray-800' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <span>✅</span> Completed
            </a>
            <a href="{{ route('admin.reports.product-wise') }}"
               class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs transition
                      {{ request()->routeIs('admin.reports.product-wise') ? 'text-orange-400 bg-gray-800' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <span>📦</span> Product-wise
            </a>
        </div>
    </div>

    <div class="h-4"></div>
</nav>
        {{-- User Info --}}
     <div class="p-3 border-t border-gray-700 flex-shrink-0 bg-gray-900"
         style="position: relative; z-index: 60;">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-white text-xs font-medium truncate">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-gray-400 text-xs">Administrator</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="text-gray-400 hover:text-red-400 text-xs transition px-2 py-1 rounded hover:bg-gray-800">
                    Log Out
                </button>
            </form>
        </div>
    </div>

    </aside>

    {{-- ── MAIN CONTENT ── --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Top Header --}}
        <header class="bg-white border-b border-gray-200 shadow-sm">
            <div class="flex items-center justify-between px-6 py-3.5">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">
                        @yield('title', 'Dashboard')
                    </h2>
                    <p class="text-xs text-gray-400 mt-0.5">
                        @yield('subtitle', 'Welcome back!')
                    </p>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-500">
                        📅 {{ now()->format('d M Y, D') }}
                    </span>
                    @php
    $headerActive = \App\Models\WorkLog::where('status','started')->count();
@endphp
@if($headerActive > 0)
    <span class="flex items-center gap-1.5 bg-green-50 text-green-700 text-xs px-3 py-1.5 rounded-full border border-green-200">
        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
        {{ $headerActive }} Working Now
    </span>
@endif
                </div>
            </div>
        </header>

        {{-- Flash Messages --}}
        <div class="px-6 pt-4">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 flex items-center gap-2">
                    <span>✅</span> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 flex items-center gap-2">
                    <span>❌</span> {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4">
                    <p class="text-red-600 font-medium text-sm mb-1">Please fix these errors:</p>
                    @foreach($errors->all() as $error)
                        <p class="text-red-500 text-sm">• {{ $error }}</p>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto px-6 pb-6">
            @yield('content')
        </main>

    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const activeLink = document.querySelector('nav a.bg-orange-500');
    if(activeLink) {
        activeLink.scrollIntoView({
            block: 'center',
            behavior: 'smooth'
        });
    }
});
</script>
</body>
</html>