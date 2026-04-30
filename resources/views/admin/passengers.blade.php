@extends('layouts.admin')

@section('title', 'Passengers')
@section('header', 'Passenger Manifest')

@section('content')
<div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">All Passengers</h2>
            <p class="text-slate-400 text-sm mt-1">Passenger list from all bookings</p>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-slate-400 text-sm uppercase tracking-wider border-bottom border-slate-100">
                    <th class="pb-4">Passenger Name</th>
                    <th class="pb-4">Booking Code</th>
                    <th class="pb-4">Train</th>
                    <th class="pb-4">Departure Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($passengers as $passenger)
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-4 font-bold text-slate-700">
                        {{ $passenger->passenger_name }}
                    </td>
                    <td class="py-4 font-medium text-blue-600">
                        {{ $passenger->booking_code }}
                    </td>
                    <td class="py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                            {{ $passenger->train_name }}
                        </span>
                    </td>
                    <td class="py-4 text-slate-500 text-sm">
                        {{ date('d M Y, H:i', strtotime($passenger->departure_time)) }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-8 text-center text-slate-400">
                        No passengers found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $passengers->links() }}
    </div>
</div>
@endsection
