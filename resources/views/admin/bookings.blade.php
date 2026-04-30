@extends('layouts.admin')

@section('title', 'Bookings')
@section('header', 'Transaction Bookings')

@section('content')
<div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">All Bookings</h2>
            <p class="text-slate-400 text-sm mt-1">Manage all passenger transactions</p>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-slate-400 text-sm uppercase tracking-wider border-bottom border-slate-100">
                    <th class="pb-4">Booking Code</th>
                    <th class="pb-4">Customer</th>
                    <th class="pb-4">Total Price</th>
                    <th class="pb-4">Date</th>
                    <th class="pb-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($bookings as $booking)
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-4 font-bold text-slate-700">
                        {{ $booking->booking_code }}
                    </td>
                    <td class="py-4">
                        <div class="font-medium text-slate-700">{{ $booking->user_name }}</div>
                        <div class="text-xs text-slate-400">{{ $booking->user_email }}</div>
                    </td>
                    <td class="py-4 font-medium text-slate-700">
                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                    </td>
                    <td class="py-4 text-slate-500 text-sm">
                        {{ date('d M Y, H:i', strtotime($booking->created_at)) }}
                    </td>
                    <td class="py-4">
                        @if(strtolower($booking->status) == 'paid')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-600 border border-green-200">
                                PAID
                            </span>
                        @elseif(strtolower($booking->status) == 'unpaid')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-200">
                                UNPAID
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-50 text-slate-600 border border-slate-200">
                                {{ strtoupper($booking->status) }}
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-slate-400">
                        No bookings found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $bookings->links() }}
    </div>
</div>
@endsection
