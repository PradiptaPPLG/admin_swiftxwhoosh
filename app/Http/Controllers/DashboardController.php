<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data statistik dari tabel yang ada sesuai file SQL
        $totalBookings = DB::table('bookings')->count();
        $totalUsers = DB::table('users')->count();
        $totalRevenue = DB::table('bookings')->sum('total_price');
        $recentUsers = DB::table('users')
                            ->select('full_name', 'email', 'role', 'created_at')
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();

        return view('admin.dashboard', compact('totalBookings', 'totalUsers', 'totalRevenue', 'recentUsers'));
    }
}
