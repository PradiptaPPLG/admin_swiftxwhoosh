<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
                'admin_username' => $admin->username,
                'admin_role' => $admin->role ?? 'ADMIN'
            ]);

            // Reset failed attempts
            session()->forget('failed_login_count');

            // Log activity
            DB::table('admin_logs')->insert([
                'admin_id' => $admin->id,
                'admin_name' => $admin->name,
                'action' => 'Login',
                'target' => 'System',
                'ip_address' => request()->ip(),
                'created_at' => now()
            ]);

            session()->save();

            return redirect()->route('dashboard');
        }

        // Login failed logic
        $failedCount = session('failed_login_count', 0) + 1;
        session(['failed_login_count' => $failedCount]);

        if ($failedCount >= 3) {
            $photoPath = null;
            if ($request->intruder_photo) {
                $imageData = $request->intruder_photo;
                $image = str_replace('data:image/png;base64,', '', $imageData);
                $image = str_replace(' ', '+', $image);
                $imageName = 'intruder_' . time() . '_' . Str::random(5) . '.png';
                
                Storage::disk('public')->put('intruders/' . $imageName, base64_decode($image));
                $photoPath = 'intruders/' . $imageName;
            }

            DB::table('intruder_alerts')->insert([
                'ip_address' => $request->ip(),
                'username_attempted' => $request->username,
                'photo_path' => $photoPath,
                'location' => $request->intruder_location,
                'browser' => $request->header('User-Agent'),
                'attempt_time' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return back()->with('error', 'Invalid username or password. Attempt: ' . $failedCount)->withInput($request->only('username'));
    }

    public function logout(Request $request)
    {
        if (session()->has('admin_id')) {
            DB::table('admin_logs')->insert([
                'admin_id' => session('admin_id'),
                'admin_name' => session('admin_name', 'Unknown'),
                'action' => 'Logout',
                'target' => 'System',
                'ip_address' => $request->ip(),
                'created_at' => now()
            ]);
        }

        $request->session()->forget(['admin_logged_in', 'admin_id', 'admin_name', 'admin_username', 'admin_role']);
        $request->session()->save();

        return redirect()->route('admin.login');
    }
}
