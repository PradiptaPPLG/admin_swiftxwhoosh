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

    public function failedTransactions()
    {
        $failedTransactions = DB::table('failed_transactions')
            ->leftJoin('users', 'failed_transactions.user_id', '=', 'users.user_id')
            ->select('failed_transactions.*', 'users.full_name', 'users.email')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.failed_transactions', compact('failedTransactions'));
    }
}
