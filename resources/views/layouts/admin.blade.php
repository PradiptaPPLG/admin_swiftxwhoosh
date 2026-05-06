<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swift Admin | @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; color: #1e293b; }
        .swift-red { color: #E31E24; }
        .bg-swift-red { background-color: #E31E24; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.5); }
        [x-cloak] { display: none !important; }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="flex">
    <!-- Sidebar -->
    <aside class="w-72 bg-slate-900 h-screen fixed text-white p-6 overflow-y-auto">
        <div class="text-3xl font-extrabold italic swift-red mb-12">Swift!</div>
        <nav class="space-y-2">
            <!-- COMMON -->
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 p-4 rounded-xl transition {{ request()->routeIs('dashboard') ? 'bg-swift-red text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <span>Dashboard Overview</span>
            </a>

            <!-- MANAGER SPECIFIC -->
            @if(session('admin_role') === 'MANAGER')
            <div class="pt-6 pb-2 px-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Analytics</div>
            
            <a href="{{ route('manager.sales') }}" class="flex items-center space-x-3 p-4 rounded-xl transition {{ request()->routeIs('manager.sales') ? 'bg-orange-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <span>Sales Analytics</span>
            </a>
            
            <a href="{{ route('manager.passengers') }}" class="flex items-center space-x-3 p-4 rounded-xl transition {{ request()->routeIs('manager.passengers') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <span>Passenger Insights</span>
            </a>
            
            <a href="{{ route('manager.performance') }}" class="flex items-center space-x-3 p-4 rounded-xl transition {{ request()->routeIs('manager.performance') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <span>Fleet Performance</span>
            </a>
            @endif

            <!-- ADMIN SPECIFIC -->
            @if(session('admin_role') === 'ADMIN')
            <div class="pt-6 pb-2 px-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Management</div>
            <a href="{{ route('admin.bookings') }}" class="flex items-center space-x-3 p-4 rounded-xl transition {{ request()->routeIs('admin.bookings') ? 'bg-swift-red text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <span>Bookings</span>
            </a>
            <a href="{{ route('admin.users') }}" class="flex items-center space-x-3 p-4 rounded-xl transition {{ request()->routeIs('admin.users') ? 'bg-swift-red text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <span>Users</span>
            </a>
            <a href="{{ route('admin.passengers') }}" class="flex items-center space-x-3 p-4 rounded-xl transition {{ request()->routeIs('admin.passengers') ? 'bg-swift-red text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <span>Passengers</span>
            </a>

            <div x-data="{ open: {{ request()->routeIs('admin.schedules') || request()->routeIs('admin.fleet') ? 'true' : 'false' }} }" class="pt-2">
                <button @click="open = !open" class="w-full flex items-center justify-between p-4 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                    <div class="flex items-center space-x-3"><span>Manage Trains</span></div>
                    <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open" x-collapse x-cloak>
                    <div class="mt-1 space-y-1 bg-slate-950/50 rounded-xl p-2 border border-slate-800/50">
                        <a href="{{ route('admin.schedules') }}" class="block p-3 pl-11 rounded-lg text-sm transition {{ request()->routeIs('admin.schedules') ? 'text-white font-bold bg-slate-800/80' : 'text-slate-500 hover:bg-slate-800/50 hover:text-slate-300' }}">Schedules</a>
                        <a href="{{ route('admin.fleet') }}" class="block p-3 pl-11 rounded-lg text-sm transition {{ request()->routeIs('admin.fleet') ? 'text-white font-bold bg-slate-800/80' : 'text-slate-500 hover:bg-slate-800/50 hover:text-slate-300' }}">Train Fleet</a>
                    </div>
                </div>
            </div>

            <div x-data="{ open: {{ request()->routeIs('admin.logs') ? 'true' : 'false' }} }" class="pt-2">
                <button @click="open = !open" class="w-full flex items-center justify-between p-4 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                    <div class="flex items-center space-x-3"><span>System Settings</span></div>
                    <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open" x-collapse x-cloak>
                    <div class="mt-1 space-y-1 bg-slate-950/50 rounded-xl p-2 border border-slate-800/50">
                        <a href="{{ route('admin.logs') }}" class="block p-3 pl-11 rounded-lg text-sm transition {{ request()->routeIs('admin.logs') ? 'text-white font-bold bg-slate-800/80' : 'text-slate-500 hover:bg-slate-800/50 hover:text-slate-300' }}">Admin Logs</a>
                        <a href="{{ route('admin.security.intruders') }}" class="block p-3 pl-11 rounded-lg text-sm transition {{ request()->routeIs('admin.security.intruders') ? 'text-white font-bold bg-slate-800/80' : 'text-slate-500 hover:bg-slate-800/50 hover:text-slate-300' }}">
                            Intruder Alerts 
                            @php $alertCount = DB::table('intruder_alerts')->where('is_resolved', false)->count(); @endphp
                            @if($alertCount > 0)
                                <span class="ml-2 px-2 py-0.5 bg-red-600 text-white text-[10px] rounded-full animate-pulse">{{ $alertCount }}</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <a href="{{ route('admin.logout') }}" class="flex items-center space-x-3 p-4 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-red-400 transition mt-10">
                <span>Logout</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="ml-72 flex-1 p-10">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">@yield('header')</h1>
                <p class="text-slate-500">Monitoring Swift Express System</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <p class="font-semibold text-slate-800">{{ session('admin_name') }}</p>
                    <p class="text-xs text-slate-400 uppercase tracking-widest font-bold">{{ session('admin_role') }}</p>
                </div>
                <img src="https://ui-avatars.com/api/?name={{ urlencode(session('admin_name')) }}&background=E31E24&color=fff" class="w-12 h-12 rounded-full border-2 border-white shadow-lg">
            </div>
        </header>

        @yield('content')
    </main>
</body>
</html>
