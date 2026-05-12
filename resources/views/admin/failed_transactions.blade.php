@extends('layouts.admin')

@section('title', 'Failed Transactions')
@section('header', 'Failed Transaction Tracker')

@section('content')
<div class="saas-card bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-200 flex justify-between items-center">
        <div>
            <h2 class="text-lg font-bold text-slate-800">Failed Bookings Log</h2>
            <p class="text-xs text-slate-500 mt-1">Monitor and troubleshoot API errors during booking processes.</p>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-[10px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200">
                    <th class="px-6 py-4">Time</th>
                    <th class="px-6 py-4">User</th>
                    <th class="px-6 py-4">Reason</th>
                    <th class="px-6 py-4">IP Address</th>
                    <th class="px-6 py-4">Payload</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($failedTransactions as $ft)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 text-xs font-semibold text-slate-600 whitespace-nowrap">
                        {{ date('d M Y, H:i:s', strtotime($ft->created_at)) }}
                    </td>
                    <td class="px-6 py-4">
                        @if($ft->user_id)
                            <p class="font-semibold text-slate-800">{{ $ft->full_name }}</p>
                            <p class="text-xs text-slate-500">{{ $ft->email }}</p>
                        @else
                            <span class="text-slate-400 italic">Guest / Unknown</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-bold rounded">
                            {{ $ft->error_reason }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-xs text-slate-500">
                        {{ $ft->ip_address }}
                    </td>
                    <td class="px-6 py-4">
                        <div x-data="{ open: false }">
                            <button @click="open = !open" class="text-xs font-bold text-blue-600 hover:text-blue-800">View Payload</button>
                            <div x-show="open" class="fixed inset-0 bg-slate-900/50 z-50 flex items-center justify-center" x-cloak>
                                <div @click.away="open = false" class="bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[80vh] overflow-hidden flex flex-col">
                                    <div class="p-4 border-b flex justify-between items-center bg-slate-50">
                                        <h3 class="font-bold text-slate-800">Request Payload</h3>
                                        <button @click="open = false" class="text-slate-400 hover:text-slate-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                    <div class="p-4 overflow-y-auto bg-slate-900">
                                        <pre class="text-xs text-green-400 font-mono whitespace-pre-wrap">{{ json_encode(json_decode($ft->payload), JSON_PRETTY_PRINT) }}</pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                        <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="font-medium text-slate-600">No failed transactions recorded.</p>
                        <p class="text-xs text-slate-400 mt-1">System is running smoothly.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-4 border-t border-slate-200">
        {{ $failedTransactions->links('pagination::tailwind') }}
    </div>
</div>
@endsection
