<?php
namespace App\Http\Controllers;

use App\Models\CertificateRequest;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class CertificateRequestController extends Controller
{
    public function index()
    {
        $requests = CertificateRequest::where('user_id', auth()->id())
            ->latest()->get();
        return view('certificates.index', compact('requests'));
    }

    public function create()
    {
        return view('certificates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'certificate_type' => 'required|string',
            'purpose'          => 'required|string|max:255',
        ]);

        CertificateRequest::create([
            'user_id'          => auth()->id(),
            'certificate_type' => $request->certificate_type,
            'purpose'          => $request->purpose,
            'status'           => 'Pending',
        ]);

        ActivityLog::log(
            'Requested',
            'Certificate',
            "Requested {$request->certificate_type} for purpose: \"{$request->purpose}\""
        );

        return redirect()->route('certificates.index')
            ->with('success', 'Certificate request submitted!');
    }

    public function adminIndex()
{
    // Auto-delete rejected requests older than 2 days
    CertificateRequest::where('status', 'Rejected')
        ->where('updated_at', '<=', now()->subDays(2))
        ->delete();

    $requests = CertificateRequest::with('user')
        ->latest()->get();
    return view('certificates.admin', compact('requests'));
}

    public function updateStatus(Request $request, CertificateRequest $certificate)
    {
        $request->validate([
            'status'      => 'required|string',
            'admin_notes' => 'nullable|string',
        ]);

        $certificate->update([
            'status'      => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        ActivityLog::log(
            'Updated',
            'Certificate',
            "Set {$certificate->user->name}'s {$certificate->certificate_type} request to \"{$request->status}\""
        );

        return redirect()->route('certificates.admin')
            ->with('success', 'Request status updated!');
    }
}