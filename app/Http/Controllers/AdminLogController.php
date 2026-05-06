<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminLogController extends Controller
{
    public function index()
    {
        $logs = DB::table('admin_logs')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.logs', compact('logs'));
    }
}
