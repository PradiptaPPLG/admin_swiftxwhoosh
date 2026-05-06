<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $role = session('admin_role', 'ADMIN');
        $viewMode = 'overview';
        
        if ($request->routeIs('manager.sales')) $viewMode = 'sales';
        if ($request->routeIs('manager.passengers')) $viewMode = 'passengers';
        if ($request->routeIs('manager.performance')) $viewMode = 'performance';

        // Common stats
        $totalBookings = DB::table('bookings')->count();
        $totalUsers = DB::table('users')->count();
        $totalRevenue = DB::table('bookings')->whereIn('status', ['SUCCESS', 'paid'])->sum('total_price');
        
        // Admin specific stats
        $activeSessions = rand(120, 150);
        $failedBookings = DB::table('bookings')->where('status', 'failed')->count();
        
        $registrationTrends = DB::table('users')
            ->select(DB::raw("DATE(created_at) as date"), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->limit(7)
            ->get();

        // NEW: Real-time Booking Feed
        $recentBookings = DB::table('bookings')
            ->join('users', 'bookings.user_id', '=', 'users.user_id')
            ->select('bookings.*', 'users.full_name')
            ->orderBy('bookings.booking_date', 'desc')
            ->limit(5)
            ->get();

        // Chart: Revenue Trends
        $revenueData = DB::table('bookings')
            ->select(DB::raw("DATE_TRUNC('month', booking_date) as month"), DB::raw('SUM(total_price) as total'))
            ->whereIn('status', ['SUCCESS', 'paid'])
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->limit(6)
            ->get();

        // Manager Specific Data
        $salesByClass = collect([]); $passengersByClass = collect([]); $fleetPerformance = collect([]); $peakHours = collect([]); 
        $routeProfitability = collect([]); $paymentMethods = collect([]); $demographics = collect([]); $stationTraffic = collect([]);
        $avgLeadTime = 0; $revPas = 0;

        if ($role === 'MANAGER') {
            $salesByClass = DB::table('booking_passengers')->join('bookings', 'booking_passengers.booking_id', '=', 'bookings.booking_id')->select('booking_passengers.seat_class', DB::raw('SUM(bookings.total_price / (SELECT count(*) FROM booking_passengers bp WHERE bp.booking_id = bookings.booking_id)) as total_sales'))->whereIn('bookings.status', ['SUCCESS', 'paid'])->groupBy('booking_passengers.seat_class')->get();
            $passengersByClass = DB::table('booking_passengers')->select('seat_class', DB::raw('count(*) as count'))->groupBy('seat_class')->get();
            $fleetPerformance = DB::table('trains')->leftJoin('schedules', 'trains.train_id', '=', 'schedules.train_id')->leftJoin('bookings', 'schedules.schedule_id', '=', 'bookings.schedule_id')->select('trains.train_name', 'trains.total_seats', DB::raw('count(bookings.booking_id) as booked_count'), DB::raw('ROUND((count(bookings.booking_id)::float / NULLIF(trains.total_seats, 0)::float) * 100) as occupancy_rate'))->groupBy('trains.train_id', 'trains.train_name', 'trains.total_seats')->orderBy('occupancy_rate', 'desc')->get();
            $peakHours = DB::table('bookings')->join('schedules', 'bookings.schedule_id', '=', 'schedules.schedule_id')->select(DB::raw("TO_CHAR(schedules.departure_time, 'HH24') as hour"), DB::raw('count(*) as count'))->groupBy('hour')->orderBy('hour', 'asc')->get();
            $routeProfitability = DB::table('bookings')->join('schedules', 'bookings.schedule_id', '=', 'schedules.schedule_id')->join('stations as dep_st', 'schedules.departure_station', '=', 'dep_st.station_id')->join('stations as arr_st', 'schedules.arrival_station', '=', 'arr_st.station_id')->select(DB::raw("dep_st.station_name || ' - ' || arr_st.station_name as route"), DB::raw('SUM(bookings.total_price) as revenue'))->whereIn('bookings.status', ['SUCCESS', 'paid'])->groupBy('route')->orderBy('revenue', 'desc')->limit(5)->get();
            $paymentMethods = DB::table('bookings')->select('payment_method', DB::raw('count(*) as count'), DB::raw('SUM(total_price) as revenue'))->whereIn('status', ['SUCCESS', 'paid'])->groupBy('payment_method')->get();
            $demographics = DB::table('booking_passengers')->select('passenger_type', DB::raw('count(*) as count'))->groupBy('passenger_type')->get();
            $leadTimeData = DB::table('bookings')->join('schedules', 'bookings.schedule_id', '=', 'schedules.schedule_id')->select(DB::raw('AVG(EXTRACT(DAY FROM schedules.departure_time - bookings.booking_date)) as avg_days'))->first();
            $avgLeadTime = round($leadTimeData->avg_days ?? 0, 1);
            $stationTraffic = DB::table('bookings')->join('schedules', 'bookings.schedule_id', '=', 'schedules.schedule_id')->join('stations', 'schedules.departure_station', '=', 'stations.station_id')->select('stations.station_name', DB::raw('count(*) as count'))->groupBy('stations.station_name')->orderBy('count', 'desc')->limit(5)->get();
            $totalCapacity = DB::table('trains')->join('schedules', 'trains.train_id', '=', 'schedules.train_id')->sum('trains.total_seats');
            $revPas = $totalCapacity > 0 ? $totalRevenue / $totalCapacity : 0;
        }

        // Admin Specific Data
        $adminActivities = []; $loginHistory = [];
        if ($role === 'ADMIN') {
            $adminActivities = DB::table('admin_logs')->orderBy('created_at', 'desc')->limit(10)->get();
            $loginHistory = DB::table('admin_logs')->where('action', 'LIKE', '%login%')->orderBy('created_at', 'desc')->limit(5)->get();
        }

        $statusData = DB::table('bookings')->select('status', DB::raw('count(*) as count'))->groupBy('status')->get();

        return view('admin.dashboard', compact(
            'totalBookings', 'totalUsers', 'totalRevenue', 'revenueData', 'statusData', 
            'role', 'viewMode', 'salesByClass', 'passengersByClass', 'fleetPerformance', 
            'adminActivities', 'peakHours', 'routeProfitability', 'paymentMethods', 
            'revPas', 'demographics', 'avgLeadTime', 'stationTraffic', 'activeSessions', 
            'registrationTrends', 'recentBookings', 'failedBookings', 'loginHistory'
        ));
    }
}
