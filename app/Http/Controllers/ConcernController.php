<?php
namespace App\Http\Controllers;

use App\Models\Concern;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ConcernController extends Controller
{
    public function index()
    {
        $concerns = Concern::where('user_id', auth()->id())
            ->latest()->get();
        return view('concerns.index', compact('concerns'));
    }

    public function create()
    {
        return view('concerns.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category'    => 'required|string',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'location'    => 'required|string|max:255',
        ]);

        Concern::create([
            'user_id'     => auth()->id(),
            'category'    => $request->category,
            'title'       => $request->title,
            'description' => $request->description,
            'location'    => $request->location,
            'status'      => 'Pending',
        ]);

        ActivityLog::log(
            'Submitted',
            'Concern',
            "Submitted concern: \"{$request->title}\" (Category: {$request->category}) at {$request->location}"
        );

        return redirect()->route('concerns.index')
            ->with('success', 'Concern submitted successfully!');
    }

    public function adminIndex()
{
    // Auto-delete rejected concerns older than 2 days
    Concern::where('status', 'Rejected')
        ->where('updated_at', '<=', now()->subDays(2))
        ->delete();

    $concerns = Concern::with('user')->latest()->get();
    return view('concerns.admin', compact('concerns'));
}

    public function respond(Request $request, Concern $concern)
    {
        $request->validate([
            'status'         => 'required|string',
            'admin_response' => 'nullable|string',
        ]);

        $concern->update([
            'status'         => $request->status,
            'admin_response' => $request->admin_response,
        ]);

        ActivityLog::log(
            'Responded',
            'Concern',
            "Updated concern \"{$concern->title}\" status to \"{$request->status}\""
        );

        return redirect()->route('concerns.admin')
            ->with('success', 'Response submitted!');
    }
}