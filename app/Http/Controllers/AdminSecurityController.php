<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminSecurityController extends Controller
{
    public function index()
    {
        // Auto-cleanup: Delete alerts older than 30 days
        $oldAlerts = DB::table('intruder_alerts')
            ->where('attempt_time', '<', now()->subDays(30))
            ->get();

        foreach ($oldAlerts as $alert) {
            if ($alert->photo_path) {
                Storage::disk('public')->delete($alert->photo_path);
            }
            DB::table('intruder_alerts')->where('id', $alert->id)->delete();
        }

        $alerts = DB::table('intruder_alerts')
            ->orderBy('attempt_time', 'desc')
            ->get();

        return view('admin.security.intruders', compact('alerts'));
    }

    public function resolve($id)
    {
        DB::table('intruder_alerts')->where('id', $id)->update(['is_resolved' => true]);
        return back()->with('success', 'Alert marked as resolved.');
    }

    public function delete($id)
    {
        $alert = DB::table('intruder_alerts')->where('id', $id)->first();
        if ($alert) {
            if ($alert->photo_path) {
                Storage::disk('public')->delete($alert->photo_path);
            }
            DB::table('intruder_alerts')->where('id', $id)->delete();
        }
        return back()->with('success', 'Alert and photo deleted successfully.');
    }
}
