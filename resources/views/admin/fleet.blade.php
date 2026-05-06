@extends('layouts.admin')

@section('title', 'Train Fleet')
@section('header', 'Manage Train Fleet')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Add New Train Form -->
    <div class="saas-card p-8 h-fit">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-8 h-8 bg-slate-900 rounded-lg flex items-center justify-center text-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            </div>
            <h2 class="text-lg font-bold text-slate-800">Add New Train</h2>
        </div>
        
        @if(session('success'))
            <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl text-xs font-bold mb-6 border border-emerald-100 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.fleet.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Train Name</label>
                    <input type="text" name="train_name" required placeholder="e.g. Whoosh VIP" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-400 transition-all placeholder:text-slate-300">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Train Code</label>
                    <input type="text" name="train_code" required placeholder="e.g. W-VIP-03" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-400 transition-all placeholder:text-slate-300">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Total Seats</label>
                    <input type="number" name="total_seats" required value="600" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-400 transition-all">
                </div>
                <button type="submit" class="w-full py-3.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-all shadow-md shadow-slate-200 active:scale-[0.99] flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    <span>Save Train Information</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Train List -->
    <div class="lg:col-span-2 saas-card p-8">
        <h2 class="text-xl font-bold text-slate-800 mb-6 tracking-tight">Registered Trains</h2>
        
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
