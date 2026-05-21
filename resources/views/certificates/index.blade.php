@extends('layouts.app')
@section('title', 'My Certificate Requests')
@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-blue-800">📄 My Certificate Requests</h2>
        <p class="text-gray-500 text-sm mt-1">Track the status of your certificate requests</p>
    </div>
    <a href="{{ route('certificates.create') }}"
       class="bg-blue-700 text-white px-5 py-2 rounded-xl hover:bg-blue-800 font-semibold text-sm">
        + New Request
    </a>
</div>

<div class="bg-white rounded-2xl shadow-md overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-blue-800 text-white">
            <tr>
                <th class="px-4 py-3">#</th>
                <th class="px-4 py-3">Certificate Type</th>
                <th class="px-4 py-3">Purpose</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Admin Notes</th>
                <th class="px-4 py-3">Date Requested</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $req)
            <tr class="border-b hover:bg-gray-50 transition-colors">
                <td class="px-4 py-3 text-gray-500">{{ $loop->iteration }}</td>
                <td class="px-4 py-3 font-semibold text-gray-800">{{ $req->certificate_type }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $req->purpose }}</td>

                {{-- Status Column --}}
                <td class="px-4 py-3">
                    <span class="px-3 py-1 rounded-full text-xs font-bold
                        {{ $req->status == 'Approved' || $req->status == 'Ready'
                            ? 'bg-green-100 text-green-700' :
                           ($req->status == 'Rejected'
                            ? 'bg-red-100 text-red-700'
                            : 'bg-yellow-100 text-yellow-700') }}">
                        {{ $req->status == 'Pending'  ? '⏳' :
                          ($req->status == 'Approved' ? '✅' :
                          ($req->status == 'Ready'    ? '📬' : '❌')) }}
                        {{ $req->status }}
                    </span>

                    {{-- Rejected simple message (no countdown) --}}
                    @if($req->status == 'Rejected')
                        <p class="text-red-500 text-xs mt-1">
                            ❌ Your request was rejected. You may submit a new one.
                        </p>
                    @endif

                    {{-- Approved Notice --}}
                    @if($req->status == 'Approved')
                        <div class="mt-2 bg-yellow-50 border border-yellow-200 rounded-lg px-3 py-2">
                            <p class="text-yellow-700 text-xs font-bold">📋 Action Required:</p>
                            <p class="text-yellow-600 text-xs mt-1">
                                Please visit the <strong>Barangay Hall</strong> and bring
                                a valid government-issued ID to claim your certificate.
                            </p>
                        </div>
                    @endif
                </td>

                <td class="px-4 py-3 text-gray-500 text-xs">{{ $req->admin_notes ?? '—' }}</td>
                <td class="px-4 py-3 text-gray-400 text-xs">{{ $req->created_at->format('M d, Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-10 text-center text-gray-400">
                    <p class="text-3xl mb-2">📭</p>
                    <p>No requests yet.</p>
                    <a href="{{ route('certificates.create') }}"
                       class="text-blue-600 hover:underline text-sm">Request one now.</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection