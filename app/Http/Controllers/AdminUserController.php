<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = DB::table('users')->orderBy('created_at', 'desc');

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'ilike', '%' . $search . '%')
                  ->orWhere('email', 'ilike', '%' . $search . '%')
                  ->orWhere('phone', 'ilike', '%' . $search . '%');
            });
        }

        $users = $query->paginate(10);

        return view('admin.users', compact('users', 'search'));
    }

    public function toggleBan($id)
    {
        $user = DB::table('users')->where('user_id', $id)->first();
        if (!$user) return back()->with('error', 'User not found.');

        $newStatus = ($user->status === 'banned') ? 'active' : 'banned';
        DB::table('users')->where('user_id', $id)->update(['status' => $newStatus]);

        $action = ($newStatus === 'banned') ? 'Banned User' : 'Unbanned User';

        DB::table('admin_logs')->insert([
            'admin_id' => session('admin_id'),
            'admin_name' => session('admin_name'),
            'action' => $action,
            'target' => $user->email,
            'ip_address' => request()->ip(),
            'created_at' => now()
        ]);

        return back()->with('success', "User account has been $newStatus successfully.");
    }

    public function resetPassword($id)
    {
        $user = DB::table('users')->where('user_id', $id)->first();
        if (!$user) return back()->with('error', 'User not found.');

        // Default password Swift@123
        $newPassword = password_hash('Swift@123', PASSWORD_BCRYPT);
        DB::table('users')->where('user_id', $id)->update(['password_hash' => $newPassword]);

        DB::table('admin_logs')->insert([
            'admin_id' => session('admin_id'),
            'admin_name' => session('admin_name'),
            'action' => 'Reset Password',
            'target' => $user->email,
            'ip_address' => request()->ip(),
            'created_at' => now()
        ]);

        return back()->with('success', "Password for {$user->full_name} has been reset to: Swift@123");
    }
}
