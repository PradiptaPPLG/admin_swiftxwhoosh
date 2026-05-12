@extends('layouts.admin')

@section('title', 'User Control Center')
@section('header', 'Manage Users')

@section('content')
<div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-xl font-bold text-slate-800">Registered Passengers</h2>
        
        <form action="{{ route('admin.users') }}" method="GET" class="w-full md:w-1/3">
            <div class="relative">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search name, email, or phone..." 
                       class="w-full pl-10 pr-4 py-2 rounded-xl bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-swift-red/50 transition">
                <svg class="w-5 h-5 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-600 p-4 rounded-xl text-sm font-medium mb-6 border border-green-200">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium mb-6 border border-red-200">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-slate-400 text-xs uppercase tracking-wider border-b border-slate-100">
                    <th class="pb-4">User</th>
                    <th class="pb-4">Contact Info</th>
                    <th class="pb-4">Joined Date</th>
                    <th class="pb-4">Status</th>
                    <th class="pb-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($users as $user)
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold">
                                {{ strtoupper(substr($user->full_name, 0, 1)) }}
                            </div>
                            <div>
                                <span class="font-bold text-slate-700 block">{{ $user->full_name }}</span>
                                <span class="text-xs text-slate-400">ID: {{ $user->user_id }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="py-4">
                        <span class="text-slate-600 block text-sm">{{ $user->email }}</span>
                        <span class="text-slate-400 text-xs">{{ $user->phone }}</span>
                    </td>
                    <td class="py-4 text-slate-500 text-sm">
                        {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}
                    </td>
                    <td class="py-4">
                        @if($user->status === 'banned')
                            <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-bold">Banned</span>
                        @else
                            <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-bold">Active</span>
                        @endif
                    </td>
                    <td class="py-4 text-right space-x-2">
                        <!-- Reset Password -->
                        <form action="{{ route('admin.users.reset', $user->user_id) }}" method="POST" class="inline-block" onsubmit="return confirm('Reset password for {{ $user->full_name }} to Swift@123 ?');">
                            @csrf
                            <button type="submit" class="text-xs font-bold text-blue-500 hover:text-blue-700 hover:bg-blue-50 px-3 py-1 rounded-lg transition" title="Reset Password">
                                Reset
                            </button>
                        </form>
                        
                        <!-- Ban/Unban -->
                        <form action="{{ route('admin.users.ban', $user->user_id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to change ban status for {{ $user->full_name }}?');">
                            @csrf
                            <button type="submit" class="text-xs font-bold {{ $user->status === 'banned' ? 'text-green-500 hover:bg-green-50' : 'text-red-500 hover:bg-red-50' }} px-3 py-1 rounded-lg transition">
                                {{ $user->status === 'banned' ? 'Unban' : 'Ban' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-slate-400">
                        No users found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">
        {{ $users->appends(['search' => $search])->links('pagination::tailwind') }}
    </div>
</div>
@endsection
