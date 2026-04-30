<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = DB::table('admins')->where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            // Login success
            session([
                'admin_logged_in' => true,
                'admin_id' => $admin->id,
                'admin_name' => $admin->name,
                'admin_username' => $admin->username
            ]);

            // Log activity
            DB::table('admin_logs')->insert([
                'admin_id' => $admin->id,
                'admin_name' => $admin->name,
                'action' => 'Login',
                'target' => 'System',
                'ip_address' => request()->ip(),
                'created_at' => now()
            ]);

            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Invalid username or password.')->withInput($request->only('username'));
    }

    public function logout()
    {
        if (session('admin_logged_in')) {
            DB::table('admin_logs')->insert([
                'admin_id' => session('admin_id'),
                'admin_name' => session('admin_name'),
                'action' => 'Logout',
                'target' => 'System',
                'ip_address' => request()->ip(),
                'created_at' => now()
            ]);
        }

        session()->forget(['admin_logged_in', 'admin_id', 'admin_name', 'admin_username']);
        return redirect()->route('admin.login');
    }
}
