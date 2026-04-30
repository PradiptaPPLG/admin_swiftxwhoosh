<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminBookingController extends Controller
{
    public function index()
    {
        $bookings = DB::table('bookings')
            ->join('users', 'bookings.user_id', '=', 'users.user_id')
            ->select(
                'bookings.booking_id', 
                'bookings.booking_code', 
                'bookings.total_price', 
                'bookings.status', 
                'bookings.booking_date as created_at',
                'users.full_name as user_name',
                'users.email as user_email'
            )
            ->orderBy('bookings.booking_date', 'desc')
            ->paginate(10);

        return view('admin.bookings', compact('bookings'));
    }
}
