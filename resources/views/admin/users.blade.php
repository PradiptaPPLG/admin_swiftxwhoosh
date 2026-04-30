@extends('layouts.admin')

@section('title', 'Registered Users')
@section('header', 'User Management')

@section('content')
<div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">All Registered Users</h2>
            <p class="text-slate-400 text-sm mt-1">Manage all customer accounts</p>
        </div>
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
                @forelse($users as $user)
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-4 font-bold text-slate-700">
                        {{ $user->full_name }}
                    </td>
                    <td class="py-4 text-slate-600">
                        {{ $user->email }}
                    </td>
                    <td class="py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600">
                            {{ strtoupper($user->role ?? 'CUSTOMER') }}
                        </span>
                    </td>
                    <td class="py-4 text-slate-400 text-sm">
                        {{ date('d M Y', strtotime($user->created_at)) }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-8 text-center text-slate-400">
                        No users found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection
