<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminScheduleController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'today');

        $query = DB::table('schedules')
            ->join('trains', 'schedules.train_id', '=', 'trains.train_id')
            ->join('stations as dep_st', 'schedules.departure_station', '=', 'dep_st.station_id')
            ->join('stations as arr_st', 'schedules.arrival_station', '=', 'arr_st.station_id')
            ->select(
                'schedules.*',
                'trains.train_name',
                'dep_st.station_name as dep_station',
                'arr_st.station_name as arr_station'
            );

        if ($tab === 'past') {
            $query->whereDate('schedules.departure_time', '<', now()->toDateString())
                  ->orderBy('schedules.departure_time', 'desc');
        } elseif ($tab === 'upcoming') {
            $query->whereDate('schedules.departure_time', '>', now()->toDateString())
                  ->orderBy('schedules.departure_time', 'asc');
        } else {
            // Default to 'today'
            $query->whereDate('schedules.departure_time', '=', now()->toDateString())
                  ->orderBy('schedules.departure_time', 'asc');
        }

        $schedules = $query->paginate(10);

        $trains = DB::table('trains')->get();
        $stations = DB::table('stations')->get();

        return view('admin.schedules', compact('schedules', 'trains', 'stations', 'tab'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'train_id' => 'required',
            'departure_station' => 'required',
            'arrival_station' => 'required',
            'departure_time' => 'required',
            'arrival_time' => 'required',
            'price' => 'required|numeric'
        ]);

        DB::table('schedules')->insert([
            'train_id' => $request->train_id,
            'departure_station' => $request->departure_station,
            'arrival_station' => $request->arrival_station,
            'departure_time' => $request->departure_time,
            'arrival_time' => $request->arrival_time,
            'price' => $request->price
        ]);

        // Log activity
        DB::table('admin_logs')->insert([
            'admin_id' => session('admin_id'),
            'admin_name' => session('admin_name'),
            'action' => 'Create Schedule',
            'target' => 'Route ' . $request->departure_station . ' to ' . $request->arrival_station,
            'ip_address' => request()->ip(),
            'created_at' => now()
        ]);

        return redirect()->route('admin.schedules')->with('success', 'Schedule added successfully!');
    }

    public function destroy($id)
    {
        DB::table('schedules')->where('schedule_id', $id)->delete();
        return redirect()->route('admin.schedules')->with('success', 'Schedule deleted successfully!');
    }
}
