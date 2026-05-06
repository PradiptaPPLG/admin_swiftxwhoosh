@extends('layouts.admin')

@section('title', 'Intruder Alerts — Security')

@section('header', 'System Security Alerts')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-slate-800">Intruder Monitoring</h2>
    <p class="text-slate-500 text-sm">Visual records of unauthorized access attempts (3+ failed logins).</p>
</div>

@if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-8 rounded-r-xl">
        <p class="text-green-700 font-medium text-sm">{{ session('success') }}</p>
    </div>
@endif

<div class="grid grid-cols-1 gap-6">
    @forelse($alerts as $alert)
    <div class="bg-white rounded-2xl shadow-sm border {{ $alert->is_resolved ? 'border-slate-100 opacity-75' : 'border-slate-200' }} overflow-hidden flex flex-col md:flex-row">
        <!-- Photo Side -->
        <div class="w-full md:w-64 h-64 bg-slate-100 flex-shrink-0 relative">
            @if($alert->photo_path)
                <img src="{{ asset('storage/' . $alert->photo_path) }}" class="w-full h-full object-cover" alt="Intruder Photo">
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent flex items-end p-4">
                    <span class="text-white text-[10px] font-mono uppercase tracking-widest opacity-80">Snapshot Captured</span>
                </div>
            @else
                <div class="w-full h-full flex flex-col items-center justify-center text-slate-300">
                    <i class="bi bi-camera-video-off text-4xl mb-2"></i>
                    <span class="text-[10px] uppercase font-bold">No Image</span>
                </div>
            @endif
        </div>

        <!-- Details Side -->
        <div class="flex-1 p-8 flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <span class="px-3 py-1 {{ $alert->is_resolved ? 'bg-slate-100 text-slate-600' : 'bg-red-50 text-red-600' }} rounded-full text-[10px] font-bold uppercase tracking-widest mb-2 inline-block">
                            {{ $alert->is_resolved ? 'RESOLVED' : 'POTENTIAL THREAT' }}
                        </span>
                        <h3 class="text-xl font-bold text-slate-800">Login Attempt: <span class="text-blue-600">{{ $alert->username_attempted }}</span></h3>
                    </div>
                    <div class="text-right">
                        <p class="text-slate-400 text-[11px] font-mono">{{ date('d M Y, H:i:s', strtotime($alert->attempt_time)) }}</p>
                        <p class="text-slate-800 font-bold text-sm">{{ $alert->ip_address }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mt-6">
                    <div class="p-4 bg-slate-50/50 rounded-xl border border-slate-100">
                        <p class="text-[10px] text-slate-400 uppercase font-bold mb-1">Location</p>
                        <p class="text-[11px] font-bold text-slate-700">{{ $alert->location ?? 'Unknown' }}</p>
                    </div>
                    <div class="p-4 bg-slate-50/50 rounded-xl border border-slate-100">
                        <p class="text-[10px] text-slate-400 uppercase font-bold mb-1">Device/Browser</p>
                        <p class="text-[11px] font-bold text-slate-700 truncate" title="{{ $alert->browser }}">{{ Str::limit($alert->browser, 30) }}</p>
                    </div>
                    <div class="p-4 bg-slate-50/50 rounded-xl border border-slate-100">
                        <p class="text-[10px] text-slate-400 uppercase font-bold mb-1">Status</p>
                        <p class="text-[11px] font-bold {{ $alert->is_resolved ? 'text-green-600' : 'text-red-600' }}">
                            {{ $alert->is_resolved ? 'Safe' : 'Flagged' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-8">
                @if(!$alert->is_resolved)
                <form action="{{ route('admin.security.resolve', $alert->id) }}" method="POST">
                    @csrf
                    <button class="px-5 py-2 bg-slate-800 text-white text-[11px] font-bold rounded-lg hover:bg-slate-900 transition">Mark as Resolved</button>
                </form>
                @endif
                
                <form action="{{ route('admin.security.delete', $alert->id) }}" method="POST" onsubmit="return confirm('Delete this record permanently?')">
                    @csrf
                    @method('DELETE')
                    <button class="px-5 py-2 bg-white text-red-600 text-[11px] font-bold rounded-lg hover:bg-red-50 transition border border-red-100">Delete</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white p-20 rounded-2xl shadow-sm border border-slate-100 text-center">
        <div class="w-16 h-16 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="bi bi-shield-check text-3xl"></i>
        </div>
        <h3 class="text-xl font-bold text-slate-800">No Security Threats</h3>
        <p class="text-slate-500 text-sm mt-1">All systems are normal.</p>
    </div>
    @endforelse
</div>
@endsection
