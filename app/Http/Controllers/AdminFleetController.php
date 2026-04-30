<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminFleetController extends Controller
{
    public function index()
    {
        $trains = DB::table('trains')->orderBy('train_id', 'desc')->get();
        return view('admin.fleet', compact('trains'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'train_name' => 'required|string|max:100',
            'train_code' => 'required|string|max:20',
            'total_seats' => 'required|integer|min:1'
        ]);

        DB::table('trains')->insert([
            'train_name' => $request->train_name,
            'train_code' => $request->train_code,
            'total_seats' => $request->total_seats
        ]);

        return redirect()->route('admin.fleet')->with('success', 'New train added successfully!');
    }

    public function destroy($id)
    {
        DB::table('trains')->where('train_id', $id)->delete();
        return redirect()->route('admin.fleet')->with('success', 'Train deleted successfully!');
    }
}
