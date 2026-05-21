@extends('layouts.app')
@section('title', 'Activity Records')
@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-blue-800">📋 Activity Records</h2>
        <p class="text-gray-500 text-sm mt-1">All system activities by admin and residents</p>
    </div>
    <form method="POST" action="{{ route('logs.destroyAll') }}"
          onsubmit="return confirm('Clear ALL activity logs? This cannot be undone.')">
        @csrf @method('DELETE')
        <button type="submit"
            class="bg-red-600 text-white px-4 py-2 rounded-xl hover:bg-red-700 text-sm font-semibold">
            🗑️ Clear All Logs
        </button>
    </form>
</div>

{{-- Stats --}}
@php
    $totalLogs    = \App\Models\ActivityLog::count();
    $adminLogs    = \App\Models\ActivityLog::where('role', 'admin')->count();
    $residentLogs = \App\Models\ActivityLog::where('role', 'resident')->count();
@endphp

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-2xl shadow p-4 border-l-4 border-blue-500">
        <p class="text-xs text-gray-400 uppercase font-semibold">Total Activities</p>
        <p class="text-3xl font-extrabold text-blue-700">{{ $totalLogs }}</p>
    </div>
    <div class="bg-white rounded-2xl shadow p-4 border-l-4 border-purple-500">
        <p class="text-xs text-gray-400 uppercase font-semibold">Admin Activities</p>
        <p class="text-3xl font-extrabold text-purple-700">{{ $adminLogs }}</p>
    </div>
    <div class="bg-white rounded-2xl shadow p-4 border-l-4 border-green-500">
        <p class="text-xs text-gray-400 uppercase font-semibold">Resident Activities</p>
        <p class="text-3xl font-extrabold text-green-700">{{ $residentLogs }}</p>
    </div>
</div>

{{-- Logs Table --}}
<div class="bg-white rounded-2xl shadow-md overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-blue-800 text-white">
            <tr>
                <th class="px-4 py-3">#</th>
                <th class="px-4 py-3">User</th>
                <th class="px-4 py-3">Role</th>
                <th class="px-4 py-3">Action</th>
                <th class="px-4 py-3">Module</th>
                <th class="px-4 py-3">Description</th>
                <th class="px-4 py-3">Date & Time</th>
                <th class="px-4 py-3">Delete</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
            <tr class="border-b hover:bg-gray-50 transition-colors">

                {{-- # --}}
                <td class="px-4 py-3 text-gray-400 text-xs">
                    {{ ($logs->currentPage() - 1) * $logs->perPage() + $loop->iteration }}
                </td>

                {{-- User --}}
                <td class="px-4 py-3 font-semibold text-gray-800">
                    {{ $log->user_name }}
                </td>

                {{-- Role Badge --}}
                <td class="px-4 py-3">
                    @if($log->role == 'admin')
                        <span class="px-2 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700">
                            Admin
                        </span>
                    @else
                        <span class="px-2 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                            Resident
                        </span>
                    @endif
                </td>

                {{-- Action Badge --}}
                <td class="px-4 py-3">
                    @php
                        $actionColor = 'bg-yellow-100 text-yellow-700';
                        if ($log->action == 'Deleted') {
                            $actionColor = 'bg-red-100 text-red-700';
                        } elseif (in_array($log->action, ['Created','Added','Posted','Requested','Submitted'])) {
                            $actionColor = 'bg-green-100 text-green-700';
                        }
                    @endphp
                    <span class="px-2 py-1 rounded-full text-xs font-bold {{ $actionColor }}">
                        {{ $log->action }}
                    </span>
                </td>

                {{-- Module Badge --}}
                <td class="px-4 py-3">
                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold">
                        {{ $log->module }}
                    </span>
                </td>

                {{-- Description --}}
                <td class="px-4 py-3 text-gray-600 text-xs">
                    {{ $log->description ?? '—' }}
                </td>

                {{-- Date & Time --}}
                <td class="px-4 py-3 text-gray-400 text-xs whitespace-nowrap">
                    {{ $log->created_at->format('M d, Y') }}<br>
                    {{ $log->created_at->format('h:i A') }}
                </td>

                {{-- Delete --}}
                <td class="px-4 py-3">
                    <form method="POST" action="{{ route('logs.destroy', $log) }}"
                          onsubmit="return confirm('Delete this log?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="text-red-500 hover:text-red-700 text-xs font-semibold bg-red-50 px-2 py-1 rounded-lg hover:bg-red-100 transition-colors">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-4 py-12 text-center text-gray-400">
                    <p class="text-4xl mb-3">📋</p>
                    <p class="font-semibold">No activity logs yet.</p>
                    <p class="text-xs mt-1">
                        Activities will appear here as users interact with the system.
                    </p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($logs->hasPages())
<div class="mt-6 flex flex-col items-center gap-2">
    <p class="text-sm text-gray-500">
        Showing {{ $logs->firstItem() }}–{{ $logs->lastItem() }}
        of {{ $logs->total() }} records
    </p>
    <div class="flex gap-2 flex-wrap justify-center">
        @if($logs->onFirstPage())
            <span class="px-4 py-2 rounded-xl bg-gray-100 text-gray-400 text-sm cursor-not-allowed">
                Prev
            </span>
        @else
            <a href="{{ $logs->previousPageUrl() }}"
               class="px-4 py-2 rounded-xl bg-blue-700 text-white text-sm hover:bg-blue-800">
                Prev
            </a>
        @endif

        @foreach($logs->getUrlRange(1, $logs->lastPage()) as $page => $url)
            @if($page == $logs->currentPage())
                <span class="px-4 py-2 rounded-xl bg-blue-700 text-white text-sm font-bold">
                    {{ $page }}
                </span>
            @else
                <a href="{{ $url }}"
                   class="px-4 py-2 rounded-xl bg-gray-100 text-gray-700 text-sm hover:bg-gray-200">
                    {{ $page }}
                </a>
            @endif
        @endforeach

        @if($logs->hasMorePages())
            <a href="{{ $logs->nextPageUrl() }}"
               class="px-4 py-2 rounded-xl bg-blue-700 text-white text-sm hover:bg-blue-800">
                Next
            </a>
        @else
            <span class="px-4 py-2 rounded-xl bg-gray-100 text-gray-400 text-sm cursor-not-allowed">
                Next
            </span>
        @endif
    </div>
</div>
@endif

@endsection