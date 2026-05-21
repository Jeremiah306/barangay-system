<?php
namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('author')
            ->latest()->get();
        return view('announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('announcements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'content'    => 'required|string',
            'category'   => 'required|string',
            'event_date' => 'nullable|date',
        ]);

        Announcement::create([
            'title'      => $request->title,
            'content'    => $request->content,
            'category'   => $request->category,
            'event_date' => $request->event_date,
            'created_by' => auth()->id(),
        ]);

        ActivityLog::log(
            'Posted',
            'Announcement',
            "Posted announcement: \"{$request->title}\" (Category: {$request->category})"
        );

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement posted!');
    }

    public function destroy(Announcement $announcement)
    {
        ActivityLog::log(
            'Deleted',
            'Announcement',
            "Deleted announcement: \"{$announcement->title}\""
        );

        $announcement->delete();

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement deleted!');
    }
}