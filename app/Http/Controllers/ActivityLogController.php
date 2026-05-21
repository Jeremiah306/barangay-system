<?php
namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::with('user')
            ->latest()
            ->paginate(20);
        return view('activity_logs.index', compact('logs'));
    }

    public function destroy(ActivityLog $log)
    {
        $log->delete();
        return back()->with('success', 'Log deleted.');
    }

    public function destroyAll()
    {
        ActivityLog::truncate();
        return back()->with('success', 'All logs cleared.');
    }
}