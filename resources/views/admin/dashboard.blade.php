@extends('layouts.admin')

@section('title', 'Dashboard')

@php
    $headerTitle = 'Admin Overview';
    $accentColor = 'swift-red';
    if ($viewMode === 'sales') { $headerTitle = 'Sales & Revenue Analytics'; $accentColor = 'orange-600'; }
    if ($viewMode === 'passengers') { $headerTitle = 'Passenger Insights & Demographics'; $accentColor = 'blue-600'; }
    if ($viewMode === 'performance') { $headerTitle = 'Fleet Performance & Traffic'; $accentColor = 'indigo-600'; }
@endphp

@section('header', $headerTitle)

@section('content')
<!-- Top Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="glass p-6 rounded-3xl shadow-sm border-b-4 border-slate-200">
        <h3 class="text-slate-400 text-sm font-semibold uppercase tracking-wider mb-2">Total Bookings</h3>
        <p class="text-4xl font-bold text-slate-800">{{ $totalBookings }}</p>
    </div>
    
    @if($role === 'MANAGER')
        @if($viewMode === 'passengers')
        <div class="glass p-6 rounded-3xl shadow-sm border-b-4 border-blue-500">
            <h3 class="text-slate-400 text-sm font-semibold uppercase tracking-wider mb-2">Avg Lead Time</h3>
            <p class="text-4xl font-bold text-blue-600">{{ $avgLeadTime }} <span class="text-sm font-normal text-slate-400">Days</span></p>
        </div>
        @elseif($viewMode === 'sales')
        <div class="glass p-6 rounded-3xl shadow-sm border-b-4 border-orange-500">
            <h3 class="text-slate-400 text-sm font-semibold uppercase tracking-wider mb-2">RevPAS</h3>
            <p class="text-4xl font-bold text-orange-600">Rp {{ number_format($revPas, 0, ',', '.') }}</p>
        </div>
        @else
        <div class="glass p-6 rounded-3xl shadow-sm border-b-4 border-indigo-500">
            <h3 class="text-slate-400 text-sm font-semibold uppercase tracking-wider mb-2">Avg Occupancy</h3>
            <p class="text-4xl font-bold text-indigo-600">{{ round($fleetPerformance->avg('occupancy_rate') ?? 0) }}%</p>
        </div>
        @endif
    @else
        <!-- Admin Specific Cards -->
        <div class="glass p-6 rounded-3xl shadow-sm border-b-4 border-amber-500">
            <h3 class="text-slate-400 text-sm font-semibold uppercase tracking-wider mb-2">Active Sessions</h3>
            <div class="flex items-center space-x-2">
                <p class="text-4xl font-bold text-amber-600">{{ $activeSessions }}</p>
                @if($failedBookings > 0)
                <span class="px-2 py-1 bg-red-100 text-red-600 rounded-lg text-xs font-bold">{{ $failedBookings }} FAILED</span>
                @endif
            </div>
        </div>
    @endif

    <div class="glass p-6 rounded-3xl shadow-sm border-b-4 border-{{ $accentColor }}">
        <h3 class="text-slate-400 text-sm font-semibold uppercase tracking-wider mb-2">Total Revenue</h3>
        <p class="text-4xl font-bold text-slate-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>

    <div class="glass p-6 rounded-3xl shadow-sm border-b-4 border-slate-800">
        <h3 class="text-slate-400 text-sm font-semibold uppercase tracking-wider mb-2">Status</h3>
        <p class="text-2xl font-bold text-{{ $accentColor }} truncate">{{ strtoupper($viewMode) }}</p>
    </div>
</div>

<!-- ROLE BASED CONTENT -->
@if($role === 'MANAGER')
    <!-- Manager content (same as before) -->
    @if($viewMode === 'overview' || $viewMode === 'sales')
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        <div class="bg-white p-8 rounded-3xl shadow-sm border-l-8 border-orange-500">
            <div class="flex items-center space-x-3 mb-6"><div class="p-3 bg-orange-50 rounded-2xl text-orange-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div><h3 class="text-xl font-bold text-slate-800">Sales Analytics</h3></div>
            <div class="h-64"><canvas id="salesClassChart"></canvas></div>
        </div>
        <div class="bg-white p-8 rounded-3xl shadow-sm border-l-8 border-orange-400">
            <h3 class="text-xl font-bold text-slate-800 mb-6">Payment Method Analysis</h3>
            <div class="h-64"><canvas id="paymentChart"></canvas></div>
        </div>
    </div>
    @endif
    @if($viewMode === 'overview' || $viewMode === 'passengers')
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        <div class="bg-white p-8 rounded-3xl shadow-sm border-l-8 border-blue-500">
            <div class="flex items-center space-x-3 mb-6"><div class="p-3 bg-blue-50 rounded-2xl text-blue-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg></div><h3 class="text-xl font-bold text-slate-800">Passenger Volume</h3></div>
            <div class="h-64"><canvas id="passengerClassChart"></canvas></div>
        </div>
        <div class="bg-white p-8 rounded-3xl shadow-sm border-l-8 border-blue-400">
            <h3 class="text-xl font-bold text-slate-800 mb-6">Passenger Demographics</h3>
            <div class="h-64"><canvas id="demoChart"></canvas></div>
        </div>
    </div>
    @endif
@else
    <!-- ADMIN SPECIFIC CONTENT -->
    <div class="flex flex-col lg:flex-row gap-8 mb-10">
        <div class="flex-1 bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-slate-800">Live Booking Feed</h3>
                <span class="flex items-center text-xs font-bold text-green-600 bg-green-50 px-3 py-1 rounded-full">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-ping mr-2"></span> LIVE
                </span>
            </div>
            <div class="space-y-4">
                @foreach($recentBookings as $booking)
                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center font-bold text-blue-600 border border-slate-100">{{ substr($booking->full_name, 0, 1) }}</div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">{{ $booking->full_name }}</p>
                            <p class="text-xs text-slate-400">{{ $booking->booking_code }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-slate-800">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        <p class="text-xs {{ $booking->status === 'paid' || $booking->status === 'SUCCESS' ? 'text-green-500' : 'text-amber-500' }} font-bold uppercase">{{ $booking->status }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="w-full lg:w-80 space-y-6">
            <!-- Quick Search -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">Quick User Search</h3>
                <div class="relative">
                    <input type="text" placeholder="Email or Name..." class="w-full pl-4 pr-10 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg class="w-5 h-5 absolute right-3 top-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <!-- System Pulse Card -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-6">System Pulse</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center"><span class="text-xs text-slate-600">Latency</span><span class="text-xs font-bold text-green-600">14ms</span></div>
                    <div class="flex justify-between items-center"><span class="text-xs text-slate-600">DB Load</span><span class="text-xs font-bold text-blue-600">2.4%</span></div>
                    <div class="flex justify-between items-center"><span class="text-xs text-slate-600">Failed</span><span class="text-xs font-bold text-red-600">{{ $failedBookings }}</span></div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        <!-- Registration Trends -->
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
            <h3 class="text-xl font-bold text-slate-800 mb-6">Registration Trends</h3>
            <div class="h-64"><canvas id="registrationChart"></canvas></div>
        </div>

        <!-- Recent System Activities -->
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
            <h3 class="text-xl font-bold text-slate-800 mb-6">Admin Logs</h3>
            <div class="space-y-4">
                @foreach($adminActivities as $log)
                <div class="flex items-start space-x-3 p-3 hover:bg-slate-50 rounded-2xl transition">
                    <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg></div>
                    <div>
                        <p class="text-sm font-bold text-slate-800">{{ $log->action }}</p>
                        <p class="text-xs text-slate-400">{{ $log->admin_name }} • {{ date('H:i', strtotime($log->created_at)) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const commonOptions = { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } };

        @if($role === 'MANAGER')
            // Manager Charts
            @if($viewMode === 'overview' || $viewMode === 'sales')
            new Chart(document.getElementById('salesClassChart').getContext('2d'), {
                type: 'bar',
                data: { labels: {!! json_encode($salesByClass->pluck('seat_class')) !!}, datasets: [{ label: 'Revenue', data: {!! json_encode($salesByClass->pluck('total_sales')) !!}, backgroundColor: '#f97316', borderRadius: 10 }] },
                options: { indexAxis: 'y', ...commonOptions, plugins: { legend: { display: false } } }
            });
            new Chart(document.getElementById('paymentChart').getContext('2d'), {
                type: 'polarArea',
                data: { labels: {!! json_encode($paymentMethods->pluck('payment_method')) !!}, datasets: [{ data: {!! json_encode($paymentMethods->pluck('count')) !!}, backgroundColor: ['rgba(249, 115, 22, 0.7)', 'rgba(59, 130, 246, 0.7)', 'rgba(99, 102, 241, 0.7)'] }] },
                options: { ...commonOptions, scales: { r: { ticks: { display: false } } } }
            });
            @endif
            @if($viewMode === 'overview' || $viewMode === 'passengers')
            new Chart(document.getElementById('passengerClassChart').getContext('2d'), {
                type: 'doughnut',
                data: { labels: {!! json_encode($passengersByClass->pluck('seat_class')) !!}, datasets: [{ data: {!! json_encode($passengersByClass->pluck('count')) !!}, backgroundColor: ['#3b82f6', '#6366f1', '#a855f7'] }] },
                options: { cutout: '70%', ...commonOptions }
            });
            new Chart(document.getElementById('demoChart').getContext('2d'), {
                type: 'pie',
                data: { labels: {!! json_encode($demographics->pluck('passenger_type')) !!}, datasets: [{ data: {!! json_encode($demographics->pluck('count')) !!}, backgroundColor: ['#3b82f6', '#10b981', '#f59e0b'] }] },
                options: commonOptions
            });
            @endif
        @else
            <!-- Admin Specific Charts -->
            new Chart(document.getElementById('registrationChart').getContext('2d'), {
                type: 'line',
                data: { 
                    labels: {!! json_encode($registrationTrends->pluck('date')) !!}, 
                    datasets: [{ 
                        label: 'New Registrations', 
                        data: {!! json_encode($registrationTrends->pluck('count')) !!}, 
                        borderColor: '#3b82f6', 
                        backgroundColor: 'rgba(59, 130, 246, 0.1)', 
                        fill: true,
                        tension: 0.4
                    }] 
                },
                options: commonOptions
            });
        @endif
    });
</script>
@endsection
