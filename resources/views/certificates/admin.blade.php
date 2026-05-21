@extends('layouts.app')
@section('title', 'Manage Certificate Requests')
@section('content')

<h2 class="text-2xl font-bold text-blue-800 mb-6">📄 Certificate Requests — Admin View</h2>

<div class="bg-white rounded-2xl shadow-md overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-blue-800 text-white">
            <tr>
                <th class="px-4 py-3">#</th>
                <th class="px-4 py-3">Resident</th>
                <th class="px-4 py-3">Certificate</th>
                <th class="px-4 py-3">Purpose</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $req)
            <tr class="border-b hover:bg-gray-50 transition-colors">
                <td class="px-4 py-3 text-gray-500">{{ $loop->iteration }}</td>
                <td class="px-4 py-3 font-semibold text-gray-800">{{ $req->user->name }}</td>
                <td class="px-4 py-3 text-gray-700">{{ $req->certificate_type }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $req->purpose }}</td>

                {{-- Status + Countdown --}}
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded-full text-xs font-bold
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

                    {{-- Countdown for Admin --}}
                    @if($req->status == 'Rejected')
                        @php
                            $deleteAt     = $req->updated_at->addDays(2);
                            $totalSeconds = max(0, now()->diffInSeconds($deleteAt, false));
                            $h = floor($totalSeconds / 3600);
                            $m = floor(($totalSeconds % 3600) / 60);
                            $s = $totalSeconds % 60;
                        @endphp
                        <div class="mt-2 bg-red-50 border border-red-200 rounded-lg px-3 py-2">
                            <p class="text-red-600 text-xs font-bold mb-1">
                                🗑️ Auto-delete in:
                            </p>
                            <p class="text-red-500 text-sm font-mono font-bold"
                               id="cert-admin-countdown-{{ $req->id }}"
                               data-seconds="{{ $totalSeconds }}">
                                {{ str_pad($h, 2, '0', STR_PAD_LEFT) }}:{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}:{{ str_pad($s, 2, '0', STR_PAD_LEFT) }}
                            </p>
                        </div>
                    @endif
                </td>

                {{-- Action --}}
                <td class="px-4 py-3">
                    <form method="POST" action="{{ route('certificates.updateStatus', $req) }}">
                        @csrf @method('PUT')
                        <div class="flex gap-2 items-center flex-wrap">
                            <select name="status"
                                class="border rounded-lg px-2 py-1 text-xs focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="Pending"  {{ $req->status == 'Pending'  ? 'selected' : '' }}>⏳ Pending</option>
                                <option value="Approved" {{ $req->status == 'Approved' ? 'selected' : '' }}>✅ Approved</option>
                                <option value="Ready"    {{ $req->status == 'Ready'    ? 'selected' : '' }}>📬 Ready for Pickup</option>
                                <option value="Rejected" {{ $req->status == 'Rejected' ? 'selected' : '' }}>❌ Rejected</option>
                            </select>
                            <input type="text" name="admin_notes"
                                value="{{ $req->admin_notes }}"
                                placeholder="Notes (optional)"
                                class="border rounded-lg px-2 py-1 text-xs focus:ring-2 focus:ring-blue-500 outline-none w-32">
                            <button type="submit"
                                class="bg-blue-700 text-white px-3 py-1 rounded-lg text-xs hover:bg-blue-800 font-semibold">
                                Update
                            </button>
                        </div>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-10 text-center text-gray-400">
                    <p class="text-3xl mb-2">📭</p>
                    <p>No certificate requests yet.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Live Countdown Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const countdowns = document.querySelectorAll('[id^="cert-admin-countdown-"]');

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