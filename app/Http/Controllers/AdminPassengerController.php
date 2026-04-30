<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPassengerController extends Controller
{
    public function index()
    {
        $passengers = DB::table('booking_passengers')
            ->join('bookings', 'booking_passengers.booking_id', '=', 'bookings.booking_id')
            ->join('schedules', 'bookings.schedule_id', '=', 'schedules.schedule_id')
            ->join('trains', 'schedules.train_id', '=', 'trains.train_id')
            ->select(
                'booking_passengers.passenger_id',
                'booking_passengers.full_name as passenger_name',
                'bookings.booking_code',
                'bookings.booking_date',
                'trains.train_name',
                'schedules.departure_time'
            )
            ->orderBy('bookings.booking_date', 'desc')
            ->paginate(10);

        return view('admin.passengers', compact('passengers'));
    }
}
