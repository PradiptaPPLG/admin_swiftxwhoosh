<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swift Admin | @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            font-family: 'Outfit', sans-serif; 
            background-color: #f1f5f9; /* Darker slate-100 background like reference */
            color: #0f172a; 
            min-height: 100vh;
        }
        .swift-red { color: #E31E24; }
        
        /* Refined SaaS Cards */
        .saas-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            transition: all 0.2s ease-in-out;
        }
        .saas-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-color: #cbd5e1;
        }
        
        .sidebar-light {
            background-color: #ffffff;
            border-right: 1px solid #e2e8f0;
        }

        [x-cloak] { display: none !important; }
        
        /* Subtle entrance */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-fade {
            animation: fadeIn 0.4s ease-out forwards;
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="flex selection:bg-red-100 selection:text-red-900">
    <!-- Sidebar -->
    <aside class="w-64 sidebar-light h-screen fixed text-slate-500 p-5 overflow-y-auto z-50">
        <div class="flex items-center space-x-3 mb-10 px-2 mt-2">
            <div class="text-2xl font-extrabold tracking-tight text-slate-900">Swift<span class="text-red-500">.</span></div>
        </div>
        <nav class="space-y-1">
            <!-- COMMON -->
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-red-50 text-red-600 font-bold' : 'hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="text-sm">Dashboard Overview</span>
            </a>

            <!-- MANAGER SPECIFIC -->
            @if(session('admin_role') === 'MANAGER')
            <div class="pt-6 pb-2 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Analytics</div>
            
            <a href="{{ route('manager.sales') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('manager.sales') ? 'bg-orange-50 text-orange-600 font-bold' : 'hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-sm">Sales Analytics</span>
            </a>
            
            <a href="{{ route('manager.passengers') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('manager.passengers') ? 'bg-blue-50 text-blue-600 font-bold' : 'hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span class="text-sm">Passenger Insights</span>
            </a>
            
            <a href="{{ route('manager.performance') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('manager.performance') ? 'bg-indigo-50 text-indigo-600 font-bold' : 'hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                <span class="text-sm">Fleet Performance</span>
            </a>
            @endif

            <!-- ADMIN SPECIFIC -->
            @if(session('admin_role') === 'ADMIN')
            <div class="pt-6 pb-2 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Management</div>
            
            <a href="{{ route('admin.bookings') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.bookings') ? 'bg-red-50 text-red-600 font-bold' : 'hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <span class="text-sm">Bookings</span>
            </a>
            <a href="{{ route('admin.users') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.users') ? 'bg-red-50 text-red-600 font-bold' : 'hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span class="text-sm">Users</span>
            </a>
            <a href="{{ route('admin.passengers') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.passengers') ? 'bg-red-50 text-red-600 font-bold' : 'hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span class="text-sm">Passengers</span>
            </a>

            <div x-data="{ open: {{ request()->routeIs('admin.schedules') || request()->routeIs('admin.fleet') ? 'true' : 'false' }} }" class="pt-2">
                <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors text-slate-400 hover:bg-slate-800 hover:text-white">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="text-sm">Manage Trains</span>
                    </div>
                    <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open" x-collapse x-cloak>
                    <div class="mt-1 space-y-1 bg-slate-900 rounded-lg p-1">
                        <a href="{{ route('admin.schedules') }}" class="block p-2 pl-11 rounded-md text-xs transition-colors {{ request()->routeIs('admin.schedules') ? 'text-white font-bold bg-slate-800' : 'text-slate-500 hover:text-slate-300' }}">Schedules</a>
                        <a href="{{ route('admin.fleet') }}" class="block p-2 pl-11 rounded-md text-xs transition-colors {{ request()->routeIs('admin.fleet') ? 'text-white font-bold bg-slate-800' : 'text-slate-500 hover:text-slate-300' }}">Train Fleet</a>
                    </div>
                </div>
            </div>

            <div x-data="{ open: {{ request()->routeIs('admin.logs') ? 'true' : 'false' }} }" class="pt-2">
                <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors text-slate-500 hover:bg-slate-50 hover:text-slate-900">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span class="text-sm">System Settings</span>
                    </div>
                    <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open" x-collapse x-cloak>
                    <div class="mt-1 space-y-1 bg-slate-50 rounded-lg p-1">
                        <a href="{{ route('admin.logs') }}" class="block p-2 pl-11 rounded-md text-xs transition-colors {{ request()->routeIs('admin.logs') ? 'text-red-600 font-bold' : 'text-slate-500 hover:text-slate-900' }}">Admin Logs</a>
                        <a href="{{ route('admin.security.intruders') }}" class="block p-2 pl-11 rounded-md text-xs transition-colors {{ request()->routeIs('admin.security.intruders') ? 'text-red-600 font-bold' : 'text-slate-500 hover:text-slate-900' }}">
                            Intruder Alerts 
                            @php $alertCount = DB::table('intruder_alerts')->where('is_resolved', false)->count(); @endphp
                            @if($alertCount > 0)
                                <span class="ml-2 px-1.5 py-0.5 bg-red-600 text-white text-[9px] rounded-full">{{ $alertCount }}</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <a href="{{ route('admin.logout') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-slate-500 hover:bg-red-50 hover:text-red-600 transition-colors mt-8">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span class="text-sm">Logout</span>
            </a>
        </nav>
    </aside>

    <!-- Content Area -->
    <div class="ml-64 flex-1 flex flex-col min-h-screen">
        <!-- Top Bar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 sticky top-0 z-40">
            <div>
                <h1 class="text-lg font-bold text-slate-800 tracking-tight">@yield('header')</h1>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <p class="text-xs font-bold text-slate-900 leading-none">{{ session('admin_name') }}</p>
                    <p class="text-[9px] text-slate-400 uppercase tracking-widest font-extrabold mt-1">{{ session('admin_role') }}</p>
                </div>
                <div class="w-9 h-9 rounded-full border border-slate-200 p-0.5">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(session('admin_name')) }}&background=f1f5f9&color=0f172a" class="w-full h-full rounded-full">
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="p-8 animate-fade">
            @yield('content')
        </main>
    </div>
</body>
</html>
