@extends('layouts.admin')

@section('title', 'Schedules')
@section('header', 'Manage Schedules')

@section('content')
<div class="grid grid-cols-1 gap-8">
    
    <!-- Add New Schedule Card -->
    <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
        <h2 class="text-xl font-bold text-slate-800 mb-6">Create New Schedule</h2>
        
        @if(session('success'))
            <div class="bg-green-50 text-green-600 p-4 rounded-xl text-sm font-medium mb-6 border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.schedules.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-600 mb-2">Train</label>
                    <select name="train_id" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-swift-red/50 transition">
                        <option value="">Select Train</option>
                        @foreach($trains as $train)
                            <option value="{{ $train->train_id }}">{{ $train->train_name }} ({{ $train->train_code }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-600 mb-2">Departure Station</label>
                    <select name="departure_station" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-swift-red/50 transition">
                        <option value="">Select Station</option>
                        @foreach($stations as $station)
                            <option value="{{ $station->station_id }}">{{ $station->station_name }} ({{ $station->city }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-600 mb-2">Arrival Station</label>
                    <select name="arrival_station" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-swift-red/50 transition">
                        <option value="">Select Station</option>
                        @foreach($stations as $station)
                            <option value="{{ $station->station_id }}">{{ $station->station_name }} ({{ $station->city }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-600 mb-2">Departure Time</label>
                    <input type="datetime-local" name="departure_time" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-swift-red/50 transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-600 mb-2">Arrival Time</label>
                    <input type="datetime-local" name="arrival_time" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-swift-red/50 transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-600 mb-2">Price (IDR)</label>
                    <input type="number" name="price" required placeholder="250000" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-swift-red/50 transition">
                </div>
            </div>
            <div class="mt-8">
                <button type="submit" class="px-8 py-3 bg-swift-red text-white font-bold rounded-xl hover:bg-red-700 transition shadow-lg shadow-red-500/30">
                    Publish Schedule
                </button>
            </div>
        </form>
    </div>

    <!-- Schedules List -->
    <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
        <h2 class="text-xl font-bold text-slate-800 mb-6">Active Schedules</h2>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-slate-400 text-xs uppercase tracking-wider border-b border-slate-100">
                        <th class="pb-4">Train</th>
                        <th class="pb-4">Route</th>
                        <th class="pb-4">Departure</th>
                        <th class="pb-4">Arrival</th>
                        <th class="pb-4">Price</th>
                        <th class="pb-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($schedules as $schedule)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-4">
                            <span class="font-bold text-slate-700 block">{{ $schedule->train_name }}</span>
                            <span class="text-xs text-slate-400">#SCH-{{ $schedule->schedule_id }}</span>
                        </td>
                        <td class="py-4">
                            <div class="flex items-center space-x-2">
                                <span class="font-medium text-slate-600">{{ $schedule->dep_station }}</span>
                                <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7-7 7"></path></svg>
                                <span class="font-medium text-slate-600">{{ $schedule->arr_station }}</span>
                            </div>
                        </td>
                        <td class="py-4">
                            <span class="text-slate-600 block font-medium">{{ date('d M Y', strtotime($schedule->departure_time)) }}</span>
                            <span class="text-xs text-slate-400 font-bold">{{ date('H:i', strtotime($schedule->departure_time)) }}</span>
                        </td>
                        <td class="py-4">
                            <span class="text-slate-600 block font-medium">{{ date('d M Y', strtotime($schedule->arrival_time)) }}</span>
                            <span class="text-xs text-slate-400 font-bold">{{ date('H:i', strtotime($schedule->arrival_time)) }}</span>
                        </td>
                        <td class="py-4 font-bold text-slate-700">
                            Rp {{ number_format($schedule->price, 0, ',', '.') }}
                        </td>
                        <td class="py-4 text-right">
                            <form action="{{ route('admin.schedules.destroy', $schedule->schedule_id) }}" method="POST" onsubmit="return confirm('Delete this schedule? This will affect mobile users.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-bold text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-1 rounded-lg transition">
                                    Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-400">
                            No schedules found in the manifest.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
