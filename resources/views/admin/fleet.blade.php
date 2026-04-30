@extends('layouts.admin')

@section('title', 'Train Fleet')
@section('header', 'Manage Train Fleet')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Add New Train Form -->
    <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 h-fit">
        <h2 class="text-xl font-bold text-slate-800 mb-6">Add New Train</h2>
        
        @if(session('success'))
            <div class="bg-green-50 text-green-600 p-4 rounded-xl text-sm font-medium mb-6 border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.fleet.store') }}" method="POST">
            @csrf
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-600 mb-2">Train Name</label>
                    <input type="text" name="train_name" required placeholder="e.g. Whoosh VIP" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-swift-red/50 transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-600 mb-2">Train Code</label>
                    <input type="text" name="train_code" required placeholder="e.g. W-VIP-03" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-swift-red/50 transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-600 mb-2">Total Seats</label>
                    <input type="number" name="total_seats" required value="600" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-swift-red/50 transition">
                </div>
                <button type="submit" class="w-full py-3 bg-swift-red text-white font-bold rounded-xl hover:bg-red-700 transition shadow-lg shadow-red-500/30">
                    Save Train
                </button>
            </div>
        </form>
    </div>

    <!-- Train List -->
    <div class="lg:col-span-2 bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
        <h2 class="text-xl font-bold text-slate-800 mb-6">Registered Trains</h2>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-slate-400 text-xs uppercase tracking-wider border-b border-slate-100">
                        <th class="pb-4">Code</th>
                        <th class="pb-4">Name</th>
                        <th class="pb-4">Capacity</th>
                        <th class="pb-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($trains as $train)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-4 font-bold text-slate-700">
                            {{ $train->train_code }}
                        </td>
                        <td class="py-4 font-medium text-slate-600">
                            {{ $train->train_name }}
                        </td>
                        <td class="py-4 text-slate-500">
                            {{ $train->total_seats }} Seats
                        </td>
                        <td class="py-4 text-right">
                            <form action="{{ route('admin.fleet.destroy', $train->train_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this train?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-bold text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-1 rounded-lg transition">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-slate-400">
                            No trains registered yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
