@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', 'System Overview')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
    <div class="glass p-6 rounded-3xl border border-white shadow-sm hover:shadow-md transition">
        <h3 class="text-slate-400 text-sm font-semibold uppercase tracking-wider mb-2">Total Booked Seats</h3>
        <p class="text-4xl font-bold text-slate-800">{{ $totalBookings }}</p>
        <p class="text-green-500 text-sm mt-2">↑ Live from database</p>
    </div>
    
    <div class="glass p-6 rounded-3xl border border-white shadow-sm hover:shadow-md transition">
        <h3 class="text-slate-400 text-sm font-semibold uppercase tracking-wider mb-2">Registered Users</h3>
        <p class="text-4xl font-bold text-slate-800">{{ $totalUsers }}</p>
        <p class="text-green-500 text-sm mt-2">↑ Active accounts</p>
    </div>

    <div class="glass p-6 rounded-3xl border border-white shadow-sm hover:shadow-md transition">
        <h3 class="text-slate-400 text-sm font-semibold uppercase tracking-wider mb-2">Total Revenue</h3>
        <p class="text-4xl font-bold text-slate-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        <p class="text-green-500 text-sm mt-2">↑ From all paid bookings</p>
    </div>

    <div class="glass p-6 rounded-3xl border border-white shadow-sm hover:shadow-md transition">
        <h3 class="text-slate-400 text-sm font-semibold uppercase tracking-wider mb-2">System Status</h3>
        <p class="text-4xl font-bold text-blue-500">Online</p>
        <p class="text-slate-400 text-sm mt-2">API Connected</p>
    </div>
</div>

<div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-bold text-slate-800">Recent Users</h2>
        <a href="{{ route('admin.users') }}" class="text-swift-red font-semibold hover:underline">View All</a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-slate-400 text-sm uppercase tracking-wider border-bottom border-slate-100">
                    <th class="pb-4">Name</th>
                    <th class="pb-4">Email</th>
                    <th class="pb-4">Role</th>
                    <th class="pb-4">Joined At</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($recentUsers as $user)
                <tr>
                    <td class="py-4 font-medium text-slate-700">{{ $user->full_name }}</td>
                    <td class="py-4 text-slate-500">{{ $user->email }}</td>
                    <td class="py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600">
                            {{ strtoupper($user->role ?? 'USER') }}
                        </span>
                    </td>
                    <td class="py-4 text-slate-400 text-sm">{{ date('d M Y', strtotime($user->created_at)) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
