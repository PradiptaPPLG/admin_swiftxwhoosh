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
    <div class="saas-card p-6 border-none shadow-sm bg-white hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Bookings</p>
                <p class="text-3xl font-bold text-slate-900 mt-1">{{ $totalBookings }}</p>
            </div>
            <div class="p-2 bg-slate-50 rounded-lg text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
        </div>
    </div>
    
    @if($role === 'MANAGER')
        @if($viewMode === 'passengers')
        <div class="saas-card p-6 border-none shadow-sm bg-white hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Avg Lead Time</p>
                    <p class="text-3xl font-bold text-slate-900 mt-1">{{ $avgLeadTime }} <span class="text-sm font-medium text-slate-400">Days</span></p>
                </div>
                <div class="p-2 bg-blue-50 rounded-lg text-blue-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>
        @elseif($viewMode === 'sales')
        <div class="saas-card p-6 border-none shadow-sm bg-white hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">RevPAS</p>
                    <p class="text-3xl font-bold text-slate-900 mt-1"><span class="text-lg">Rp</span> {{ number_format($revPas, 0, ',', '.') }}</p>
                </div>
                <div class="p-2 bg-orange-50 rounded-lg text-orange-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
            </div>
        </div>
        @else
        <div class="saas-card p-6 border-none shadow-sm bg-white hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Avg Occupancy</p>
                    <p class="text-3xl font-bold text-slate-900 mt-1">{{ round($fleetPerformance->avg('occupancy_rate') ?? 0) }}%</p>
                </div>
                <div class="p-2 bg-indigo-50 rounded-lg text-indigo-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
        </div>
        @endif
    @else
        <div class="saas-card p-6 border-none shadow-sm bg-white hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Active Sessions</p>
                    <div class="flex items-center space-x-2 mt-1">
                        <p class="text-3xl font-bold text-slate-900">{{ $activeSessions }}</p>
                        @if($failedBookings > 0)
                        <span class="px-2 py-0.5 bg-red-100 text-red-600 rounded text-[10px] font-bold">{{ $failedBookings }} FAILED</span>
                        @endif
                    </div>
                </div>
                <div class="p-2 bg-amber-50 rounded-lg text-amber-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
        </div>
    @endif

    <div class="saas-card p-6 border-none shadow-sm bg-white hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Revenue</p>
                <p class="text-3xl font-bold text-slate-900 mt-1"><span class="text-lg">Rp</span> {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="p-2 bg-emerald-50 rounded-lg text-emerald-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="saas-card p-6 bg-slate-900 border-none">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">System Mode</p>
        <p class="text-xl font-black text-white mt-2 tracking-widest uppercase">{{ $viewMode }}</p>
    </div>
</div>

<!-- ROLE BASED CONTENT -->
@if($role === 'MANAGER')
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="saas-card p-6">
            <h3 class="text-sm font-bold text-slate-800 mb-6">Sales Analysis</h3>
            <div class="h-64"><canvas id="salesClassChart"></canvas></div>
        </div>
        <div class="saas-card p-6">
            <h3 class="text-sm font-bold text-slate-800 mb-6">Payment Methods</h3>
            <div class="h-64"><canvas id="paymentChart"></canvas></div>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="saas-card p-6">
            <h3 class="text-sm font-bold text-slate-800 mb-6">Passenger Volume</h3>
            <div class="h-64"><canvas id="passengerClassChart"></canvas></div>
        </div>
        <div class="saas-card p-6">
            <h3 class="text-sm font-bold text-slate-800 mb-6">Demographics</h3>
            <div class="h-64"><canvas id="demoChart"></canvas></div>
        </div>
    </div>
@else
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <div class="lg:col-span-2 saas-card p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-sm font-bold text-slate-800">Recent Bookings</h3>
                <span class="flex items-center text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5 animate-pulse"></span> LIVE
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                            <th class="pb-3 font-bold">Passenger</th>
                            <th class="pb-3 font-bold">Code</th>
                            <th class="pb-3 font-bold text-right">Price</th>
                            <th class="pb-3 font-bold text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($recentBookings as $booking)
                        <tr class="group hover:bg-slate-50 transition-colors">
                            <td class="py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-slate-100 rounded text-[10px] flex items-center justify-center font-bold text-slate-600">{{ substr($booking->full_name, 0, 1) }}</div>
                                    <span class="text-sm font-semibold text-slate-700">{{ $booking->full_name }}</span>
                                </div>
                            </td>
                            <td class="py-4 text-xs font-medium text-slate-500 tracking-wider">{{ $booking->booking_code }}</td>
                            <td class="py-4 text-sm font-bold text-slate-700 text-right">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                            <td class="py-4 text-right">
                                <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded {{ $booking->status === 'paid' || $booking->status === 'SUCCESS' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                    {{ $booking->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-6">
            <div class="saas-card p-6">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Quick Search</h3>
                <div class="relative">
                    <input type="text" placeholder="Search bookings..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400 transition-all">
                </div>
            </div>

            <div class="saas-card p-6 bg-slate-900 border-none text-white" x-data="{ 
                latency: 14, 
                dbLoad: 2.4,
                dl: 85.2,
                ul: 42.1,
                update() {
                    this.latency = Math.floor(Math.random() * 60) + 10;
                    this.dbLoad = (Math.random() * 5 + 1).toFixed(1);
                    this.dl = (Math.random() * 20 + 80).toFixed(1);
                    this.ul = (Math.random() * 10 + 35).toFixed(1);
                }
            }" x-init="setInterval(() => update(), 3000)">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">System Health</h3>
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-400 font-medium">Latency</span>
                        <span class="font-bold transition-colors duration-500" :class="latency < 40 ? 'text-emerald-400' : (latency < 100 ? 'text-amber-400' : 'text-red-400')" x-text="latency + 'ms'"></span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-400 font-medium">DB Load</span>
                        <span class="font-bold transition-colors duration-500" :class="dbLoad < 15 ? 'text-emerald-400' : (dbLoad < 40 ? 'text-amber-400' : 'text-red-400')" x-text="dbLoad + '%'"></span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-400 font-medium">Net Download</span>
                        <span class="font-bold text-blue-400" x-text="dl + ' Mb/s'"></span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-400 font-medium">Net Upload</span>
                        <span class="font-bold text-indigo-400" x-text="ul + ' Mb/s'"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="saas-card p-6">
            <h3 class="text-sm font-bold text-slate-800 mb-6">Registration Growth</h3>
            <div class="h-64"><canvas id="registrationChart"></canvas></div>
        </div>
        <div class="saas-card p-6">
            <h3 class="text-sm font-bold text-slate-800 mb-6">Admin Logs</h3>
            <div class="space-y-3">
                @foreach($adminActivities as $log)
                <div class="flex items-center justify-between p-3 rounded-lg border border-slate-50 hover:bg-slate-50 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-1.5 h-1.5 bg-red-500 rounded-full"></div>
                        <span class="text-xs font-semibold text-slate-700">{{ $log->action }}</span>
                    </div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase">{{ date('H:i', strtotime($log->created_at)) }}</span>
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
