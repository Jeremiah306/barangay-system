@extends('layouts.app')
@section('title', 'Manage Concerns')
@section('content')

<h2 class="text-2xl font-bold text-blue-800 mb-6">📝 Concern Reports — Admin View</h2>

@forelse($concerns as $concern)
<div class="bg-white rounded-2xl shadow-md p-6 mb-4 border-l-4
    {{ $concern->status == 'Resolved' ? 'border-green-500' :
       ($concern->status == 'In Progress' ? 'border-yellow-500' : 'border-red-400') }}">

    <div class="flex justify-between items-start mb-3">
        <div>
            <span class="px-3 py-1 rounded-full text-xs font-bold mr-2
    {{ $concern->category == 'Personal Info Change'
        ? 'bg-blue-100 text-blue-800 border border-blue-300'
        : 'bg-gray-100 text-gray-600' }}">
    {{ $concern->category == 'Personal Info Change' ? '👤' : '' }}
    {{ $concern->category }}
</span> 
            <span class="px-3 py-1 rounded-full text-xs font-bold
                {{ $concern->status == 'Resolved' ? 'bg-green-100 text-green-700' :
                   ($concern->status == 'In Progress' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                {{ $concern->status }}
            </span><span class="px-3 py-1 rounded-full text-xs font-bold
    {{ $concern->status == 'Approved'    ? 'bg-green-100 text-green-700' :
       ($concern->status == 'Resolved'   ? 'bg-blue-100 text-blue-700' :
       ($concern->status == 'In Progress'? 'bg-yellow-100 text-yellow-700' :
       ($concern->status == 'Rejected'   ? 'bg-red-100 text-red-700' :
                                           'bg-gray-100 text-gray-600'))) }}">
    {{ $concern->status == 'Pending'     ? '⏳' :
       ($concern->status == 'In Progress'? '🔧' :
       ($concern->status == 'Approved'   ? '✅' :
       ($concern->status == 'Resolved'   ? '🏁' : '❌'))) }}
    {{ $concern->status }}
</span>

            {{-- Countdown for Admin --}}
            @if($concern->status == 'Rejected')
                @php
                    $deleteAt     = $concern->updated_at->addDays(2);
                    $totalSeconds = max(0, now()->diffInSeconds($deleteAt, false));
                    $h = floor($totalSeconds / 3600);
                    $m = floor(($totalSeconds % 3600) / 60);
                    $s = $totalSeconds % 60;
                @endphp
                <div class="mt-2 bg-red-50 border border-red-200 rounded-lg px-3 py-2">
                    <p class="text-red-600 text-xs font-bold mb-1">🗑️ Auto-delete in:</p>
                    <p class="text-red-500 text-sm font-mono font-bold"
                       id="concern-admin-countdown-{{ $concern->id }}"
                       data-seconds="{{ $totalSeconds }}">
                        {{ str_pad($h, 2, '0', STR_PAD_LEFT) }}:{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}:{{ str_pad($s, 2, '0', STR_PAD_LEFT) }}
                    </p>
                </div>
            @endif

            <h3 class="text-lg font-bold text-gray-800 mt-2">{{ $concern->title }}</h3>
            <p class="text-xs text-gray-500">📍 {{ $concern->location }} • 👤 {{ $concern->user->name }}</p>
        </div>
        <p class="text-xs text-gray-400">{{ $concern->created_at->format('M d, Y') }}</p>
    </div>

    <p class="text-gray-600 text-sm mb-4">{{ $concern->description }}</p>

    {{-- Admin Response Form --}}
    <form method="POST" action="{{ route('concerns.respond', $concern) }}">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 items-end">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Update Status</label>
                <select name="status"
    class="w-full border rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
    <option value="Pending" {{ $concern->status == 'Pending' ? 'selected' : '' }}>
        ⏳ Pending
    </option>
    <option value="In Progress" {{ $concern->status == 'In Progress' ? 'selected' : '' }}>
        🔧 In Progress
    </option>
    <option value="Approved" {{ $concern->status == 'Approved' ? 'selected' : '' }}>
        ✅ Approved
    </option>
    <option value="Resolved" {{ $concern->status == 'Resolved' ? 'selected' : '' }}>
        🏁 Resolved / Completed
    </option>
    <option value="Rejected" {{ $concern->status == 'Rejected' ? 'selected' : '' }}>
        ❌ Rejected
    </option>
</select>
            </div>
            <div class="md:col-span-1">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Response / Notes</label>
                <input type="text" name="admin_response"
                    value="{{ $concern->admin_response }}"
                    placeholder="e.g. We will address this next week."
                    class="w-full border rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <button type="submit"
                    class="w-full bg-blue-700 text-white py-2 rounded-xl hover:bg-blue-800 font-semibold text-sm transition-colors">
                    💾 Save Response
                </button>
            </div>
        </div>
    </form>
</div>
@empty
<div class="text-center py-16 bg-white rounded-2xl shadow">
    <p class="text-5xl mb-4">✅</p>
    <p class="text-gray-500">No concerns reported yet.</p>
</div>
@endforelse

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const countdowns = document.querySelectorAll('[id^="concern-admin-countdown-"]');
        countdowns.forEach(function (el) {
            let seconds = parseInt(el.getAttribute('data-seconds'));
            const interval = setInterval(function () {
                if (seconds <= 0) {
                    el.textContent = '🗑️ Deleting soon...';
                    clearInterval(interval);
                    return;
                }
                seconds--;
                const h = Math.floor(seconds / 3600);
                const m = Math.floor((seconds % 3600) / 60);
                const s = seconds % 60;
                el.textContent =
                    String(h).padStart(2, '0') + ':' +
                    String(m).padStart(2, '0') + ':' +
                    String(s).padStart(2, '0');
            }, 1000);
        });
    });
</script>

@endsection