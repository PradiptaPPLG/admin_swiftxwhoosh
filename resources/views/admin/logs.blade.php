@extends('layouts.admin')

@section('title', 'Admin Logs')
@section('header', 'System Activity Logs')

@section('content')
<div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Admin Activity</h2>
            <p class="text-slate-400 text-sm mt-1">Tracking all administrative actions</p>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-slate-400 text-sm uppercase tracking-wider border-bottom border-slate-100">
                    <th class="pb-4">Admin Name</th>
                    <th class="pb-4">Action</th>
                    <th class="pb-4">Target</th>
                    <th class="pb-4">IP Address</th>
                    <th class="pb-4">Time</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($logs as $log)
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-4 font-bold text-slate-700">
                        {{ $log->admin_name }}
                    </td>
                    <td class="py-4">
                        @if(strtolower($log->action) == 'login')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-600 border border-green-200">
                                LOGIN
                            </span>
                        @elseif(strtolower($log->action) == 'logout')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-200">
                                LOGOUT
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600 border border-blue-200">
                                {{ strtoupper($log->action) }}
                            </span>
                        @endif
                    </td>
                    <td class="py-4 text-slate-600">
                        {{ $log->target }}
                    </td>
                    <td class="py-4 text-slate-400 text-sm">
                        {{ $log->ip_address }}
                    </td>
                    <td class="py-4 text-slate-500 text-sm font-medium">
                        {{ date('d M Y, H:i:s', strtotime($log->created_at)) }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-slate-400">
                        No activity logs found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-8 pt-8 border-t border-slate-50 flex justify-between items-center">
        <p class="text-slate-400 text-sm italic">
            Showing {{ $logs->firstItem() }} to {{ $logs->lastItem() }} of {{ $logs->total() }} records
        </p>
        <div class="pagination-custom">
            {{ $logs->links() }}
        </div>
    </div>
</div>

<style>
    /* Styling for Laravel Tailwind Pagination to look cleaner */
    .pagination-custom nav div:first-child { display: none; }
    .pagination-custom nav div:last-child { box-shadow: none !important; }
    .pagination-custom span[aria-current="page"] span { background-color: #E31E24 !important; border-color: #E31E24 !important; color: white !important; border-radius: 8px; }
    .pagination-custom a, .pagination-custom span { border-radius: 8px; margin: 0 2px; border-color: #f1f5f9 !important; font-size: 13px !important; font-weight: 600; }
</style>
@endsection
