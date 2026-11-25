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

    {{-- SIDEBAR --}}
    <aside class="w-60 bg-gray-900 text-white flex-shrink-0 flex flex-col">

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

        {{-- Nav --}}
        <nav class="flex-1 p-2.5 flex flex-col gap-0.5 overflow-hidden">

            <a href="{{ route('tl.dashboard') }}"
               class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-medium transition
                      {{ request()->routeIs('tl.dashboard') ? 'bg-orange-500 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <span>📊</span> Dashboard
            </a>

            <div class="border-t border-gray-800 my-1.5"></div>

            <a href="{{ route('tl.employees') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition
                      {{ request()->routeIs('tl.employees') ? 'bg-orange-500 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <span>👷</span> My Team
            </a>

            <a href="{{ route('tl.assign.create') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition
                      {{ request()->routeIs('tl.assign.create') ? 'bg-orange-500 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <span>➕</span> Assign Work
            </a>

            <a href="{{ route('tl.assign.index') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition
                      {{ request()->routeIs('tl.assign.index') ? 'bg-orange-500 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <span>📋</span> All Assignments
            </a>

            <a href="{{ route('tl.work.index') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition
                      {{ request()->routeIs('tl.work.index') ? 'bg-orange-500 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <span>⏱️</span>
                Work Status
                @php
                    $tlEmp   = \App\Models\Employee::where('user_id', auth()->id())->first();
                    $tIds    = \App\Models\Employee::where('team_leader_id', $tlEmp?->id)->pluck('id');
                    $tlLive  = \App\Models\WorkLog::whereIn('employee_id', $tIds)->where('status','started')->count();
                @endphp
                @if($tlLive > 0)
                    <span class="ml-auto bg-green-500 text-white text-xs px-1.5 py-0.5 rounded-full animate-pulse">
                        {{ $tlLive }}
                    </span>
                @endif
            </a>
   <a href="{{ route('tl.profile') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition
                      {{ request()->routeIs('tl.profile') ? 'bg-orange-500 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <span>✏️</span> Edit Profile
            </a>
            <div class="border-t border-gray-800 my-1.5"></div>

            {{-- Reports Dropdown --}}
            <div x-data="{ open: {{ request()->routeIs('tl.reports*') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition w-full
                               {{ request()->routeIs('tl.reports*') ? 'bg-orange-500 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <span>📈</span>
                    <span class="flex-1 text-left">Reports</span>
                    <svg :class="open ? 'rotate-180' : ''"
                         class="w-3 h-3 transition-transform"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-transition
                     class="ml-3 mt-0.5 border-l border-gray-700 pl-3 space-y-0.5">
                    <a href="{{ route('tl.reports.daily') }}"
                       class="flex items-center gap-2 px-3 py-1.5 text-xs transition
                              {{ request()->routeIs('tl.reports.daily') ? 'text-orange-400' : 'text-gray-400 hover:text-white' }}">
                        📅 Daily Report
                    </a>
                    <a href="{{ route('tl.reports.employee') }}"
                       class="flex items-center gap-2 px-3 py-1.5 text-xs transition
                              {{ request()->routeIs('tl.reports.employee') ? 'text-orange-400' : 'text-gray-400 hover:text-white' }}">
                        👷 Employee-wise
                    </a>
                    <a href="{{ route('tl.reports.product') }}"
                       class="flex items-center gap-2 px-3 py-1.5 text-xs transition
                              {{ request()->routeIs('tl.reports.product') ? 'text-orange-400' : 'text-gray-400 hover:text-white' }}">
                        📦 Product-wise
                    </a>
                    <a href="{{ route('tl.reports.productivity') }}"
                       class="flex items-center gap-2 px-3 py-1.5 text-xs transition
                              {{ request()->routeIs('tl.reports.productivity') ? 'text-orange-400' : 'text-gray-400 hover:text-white' }}">
                        📊 Productivity
                    </a>
                    <a href="{{ route('tl.reports.standard-actual') }}"
                       class="flex items-center gap-2 px-3 py-1.5 text-xs transition
                              {{ request()->routeIs('tl.reports.standard-actual') ? 'text-orange-400' : 'text-gray-400 hover:text-white' }}">
                        ⚖️ Std vs Actual
                    </a>
                    <a href="{{ route('tl.reports.pending') }}"
                       class="flex items-center gap-2 px-3 py-1.5 text-xs transition
                              {{ request()->routeIs('tl.reports.pending') ? 'text-orange-400' : 'text-gray-400 hover:text-white' }}">
                        ⏳ Pending Work
                    </a>
                    <a href="{{ route('tl.reports.completed') }}"
                       class="flex items-center gap-2 px-3 py-1.5 text-xs transition
                              {{ request()->routeIs('tl.reports.completed') ? 'text-orange-400' : 'text-gray-400 hover:text-white' }}">
                        ✅ Completed
                    </a>
                </div>
            </div>

        </nav>

        {{-- User --}}
        <div class="p-3 border-t border-gray-700 flex-shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white text-xs font-medium truncate">{{ auth()->user()->name }}</p>
                    <p class="text-gray-400 text-xs">Supervisor</p>
                
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-gray-500 hover:text-red-400 text-xs">Sign Out</button>
                </form>
            </div>
        </div>

    </aside>

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Header --}}
        <header class="bg-white border-b border-gray-200 flex-shrink-0">
            <div class="flex items-center justify-between px-6 py-3.5">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">@yield('title')</h2>
                    <p class="text-xs text-gray-400">@yield('subtitle', '')</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-400">📅 {{ now()->format('d M Y') }}</span>
                    @if(isset($tlLive) && $tlLive > 0)
                        <span class="flex items-center gap-1.5 bg-green-50 text-green-700 text-xs px-3 py-1.5 rounded-full border border-green-200">
                            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                            {{ $tlLive }} Working
                        </span>
                    @endif
                </div>
            </div>
        </header>

        {{-- Alerts --}}
        <div class="px-6 pt-4 flex-shrink-0">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-3 text-sm">
                    ✅ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-3 text-sm">
                    ❌ {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-3">
                    @foreach($errors->all() as $error)
                        <p class="text-red-500 text-xs">• {{ $error }}</p>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Content --}}
        <main class="flex-1 overflow-y-auto px-6 pb-6">
            @yield('content')
        </main>

    </div>
</div>

</body>
</html>