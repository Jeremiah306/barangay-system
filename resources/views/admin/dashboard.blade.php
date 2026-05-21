@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')

{{-- Welcome Banner --}}
<div class="rounded-xl p-6 mb-6 text-white"
     style="background: linear-gradient(135deg, #1e3a8a, #1d4ed8, #0369a1);">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-blue-200 text-sm font-medium mb-1">⚙️ Administrator Panel</p>
            <h2 class="text-3xl font-bold mb-1">Admin Dashboard</h2>
            <p class="text-blue-200 text-sm">{{ now()->format('l, F d, Y') }}</p>
        </div>
        <div class="text-right hidden md:block">
            <p class="text-5xl">🏛️</p>
            <p class="text-blue-200 text-xs mt-1">Barangay InfoSys</p>
        </div>
    </div>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-600 hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-1">Total Households</p>
                <p class="text-4xl font-bold text-blue-700">{{ $totalHouseholds }}</p>
                <p class="text-xs text-gray-400 mt-1">Registered in the system</p>
            </div>
            <div class="text-5xl opacity-80">🏠</div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-1">Total Residents</p>
                <p class="text-4xl font-bold text-green-600">{{ $totalResidents }}</p>
                <p class="text-xs text-gray-400 mt-1">Individuals recorded</p>
            </div>
            <div class="text-5xl opacity-80">👥</div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500 hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-1">Registered Users</p>
                <p class="text-4xl font-bold text-purple-600">{{ $totalUsers }}</p>
                <p class="text-xs text-gray-400 mt-1">Active resident accounts</p>
            </div>
            <div class="text-5xl opacity-80">👤</div>
        </div>
    </div>
</div>

{{-- Bottom Section --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    {{-- Puroks Covered --}}
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-lg font-bold text-gray-700 mb-4">📍 Puroks Covered</h3>
        @if($puroks->count() > 0)
            <div class="flex flex-wrap gap-2">
                @foreach($puroks as $purok)
                    <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-semibold">
                        📌 {{ $purok }}
                    </span>
                @endforeach
            </div>
        @else
            <p class="text-gray-400 text-sm">No puroks recorded yet.</p>
        @endif
    </div>

    {{-- Quick Actions --}}
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-lg font-bold text-gray-700 mb-4">⚡ Quick Actions</h3>
        <div class="space-y-3">
            <a href="{{ route('households.index') }}"
               class="flex items-center gap-3 p-3 rounded-lg bg-blue-50 hover:bg-blue-100 transition-colors">
                <span class="text-2xl">🏠</span>
                <div>
                    <p class="text-sm font-semibold text-blue-800">Manage All Households</p>
                    <p class="text-xs text-gray-500">View, edit, or delete household records</p>
                </div>
                <span class="ml-auto text-blue-400">→</span>
            </a>
            <a href="{{ route('households.create') }}"
               class="flex items-center gap-3 p-3 rounded-lg bg-green-50 hover:bg-green-100 transition-colors">
                <span class="text-2xl">➕</span>
                <div>
                    <p class="text-sm font-semibold text-green-800">Add New Household</p>
                    <p class="text-xs text-gray-500">Register a new household record</p>
                </div>
                <span class="ml-auto text-green-400">→</span>
            </a>
            <a href="{{ route('announcements.create') }}"
               class="flex items-center gap-3 p-3 rounded-lg bg-yellow-50 hover:bg-yellow-100 transition-colors">
                <span class="text-2xl">📢</span>
                <div>
                    <p class="text-sm font-semibold text-yellow-800">Post Announcement</p>
                    <p class="text-xs text-gray-500">Notify residents of events or news</p>
                </div>
                <span class="ml-auto text-yellow-400">→</span>
            </a>
            <a href="{{ route('certificates.admin') }}"
               class="flex items-center gap-3 p-3 rounded-lg bg-indigo-50 hover:bg-indigo-100 transition-colors">
                <span class="text-2xl">📄</span>
                <div>
                    <p class="text-sm font-semibold text-indigo-800">Certificate Requests</p>
                    <p class="text-xs text-gray-500">Approve or reject requests</p>
                </div>
                <span class="ml-auto text-indigo-400">→</span>
            </a>
            <a href="{{ route('concerns.admin') }}"
               class="flex items-center gap-3 p-3 rounded-lg bg-red-50 hover:bg-red-100 transition-colors">
                <span class="text-2xl">📝</span>
                <div>
                    <p class="text-sm font-semibold text-red-800">Concern Reports</p>
                    <p class="text-xs text-gray-500">Respond to resident concerns</p>
                </div>
                <span class="ml-auto text-red-400">→</span>
            </a>
        </div>
    </div>
</div>

{{-- Summary Footer --}}
<div class="bg-white rounded-xl shadow-md p-6 mb-6">
    <h3 class="text-lg font-bold text-gray-700 mb-4">📊 System Summary</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
        <div class="p-4 bg-gray-50 rounded-lg">
            <p class="text-2xl font-bold text-blue-700">
                {{ $totalResidents > 0 && $totalHouseholds > 0
                    ? number_format($totalResidents / $totalHouseholds, 1)
                    : 0 }}
            </p>
            <p class="text-xs text-gray-500 mt-1">Avg. Residents per Household</p>
        </div>
        <div class="p-4 bg-gray-50 rounded-lg">
            <p class="text-2xl font-bold text-green-600">{{ $puroks->count() }}</p>
            <p class="text-xs text-gray-500 mt-1">Total Puroks Covered</p>
        </div>
        <div class="p-4 bg-gray-50 rounded-lg">
            <p class="text-2xl font-bold text-purple-600">
                {{ $totalHouseholds > 0 ? round(($totalHouseholds / max($totalUsers, 1)) * 100) : 0 }}%
            </p>
            <p class="text-xs text-gray-500 mt-1">Household Registration Rate</p>
        </div>
    </div>
</div>

{{-- ========== SEARCH BAR SECTION ========== --}}
@php
    $allHouseholds = \App\Models\Household::with(['residents', 'user'])->get();
@endphp

<div class="bg-white rounded-xl shadow-md p-6 mb-6">
    <h3 class="text-lg font-bold text-gray-700 mb-4">🔍 Search Records</h3>

    <div class="flex gap-3 mb-4">
        <input type="text" id="searchInput"
            onkeyup="searchRecords()"
            placeholder="Search by name, house number, street, purok..."
            class="flex-1 border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none text-sm">
        <button onclick="searchRecords()"
            class="bg-blue-700 text-white px-5 py-2 rounded-xl hover:bg-blue-800 font-semibold text-sm">
            🔍 Search
        </button>
        <button onclick="clearSearch()"
            class="bg-gray-200 text-gray-700 px-5 py-2 rounded-xl hover:bg-gray-300 font-semibold text-sm">
            ✖ Clear
        </button>
    </div>

    <p id="resultCount" class="text-xs text-gray-400 mb-3">
        Showing 1–10 of {{ $allHouseholds->count() }} household(s)
    </p>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-blue-800 text-white">
                <tr>
                    <th class="px-4 py-3 rounded-tl-lg">#</th>
                    <th class="px-4 py-3">House No.</th>
                    <th class="px-4 py-3">Street</th>
                    <th class="px-4 py-3">Purok</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Residents</th>
                    <th class="px-4 py-3">Registered By</th>
                    <th class="px-4 py-3 rounded-tr-lg">Actions</th>
                </tr>
            </thead>
            <tbody id="searchBody">
                @foreach($allHouseholds as $house)
                <tr class="border-b hover:bg-gray-50 search-row"
                    data-search="{{ strtolower(
                        $house->house_number . ' ' .
                        $house->street . ' ' .
                        $house->purok . ' ' .
                        $house->user->name . ' ' .
                        $house->residents->pluck('first_name')->join(' ') . ' ' .
                        $house->residents->pluck('last_name')->join(' ')
                    ) }}">
                    <td class="px-4 py-3 text-gray-500" data-index="{{ $loop->index + 1 }}">
                        {{ $loop->iteration }}
                    </td>
                    <td class="px-4 py-3 font-bold text-blue-800">{{ $house->house_number }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $house->street }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $house->purok }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            {{ ($house->residency_type ?? 'Permanent') == 'Permanent'
                                ? 'bg-green-100 text-green-700'
                                : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $house->residency_type ?? 'Permanent' }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold">
                            {{ $house->residents->count() }} member(s)
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $house->user->name }}</td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2">
                            <a href="{{ route('households.show', $house) }}"
                               class="text-blue-600 hover:underline text-xs font-semibold">👁️ View</a>
                            <a href="{{ route('households.edit', $house) }}"
                               class="text-yellow-600 hover:underline text-xs font-semibold">✏️ Edit</a>
                            <form method="POST" action="{{ route('households.destroy', $house) }}"
                                  class="inline" onsubmit="return confirm('Delete this household?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="text-red-600 hover:underline text-xs font-semibold">🗑️ Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- No Results --}}
        <div id="noResults" class="hidden text-center py-10 text-gray-400">
            <p class="text-4xl mb-2">🔍</p>
            <p class="font-semibold">No records found.</p>
            <p class="text-xs mt-1">Try a different search term.</p>
        </div>
    </div>

    {{-- Pagination Controls --}}
    <div id="paginationControls" class="flex justify-center mt-4 flex-wrap gap-1"></div>
</div>

{{-- Search + Pagination Script --}}
<script>
    const ROWS_PER_PAGE = 10;
    let currentPage = 1;
    let filteredRows = [];

    function getAllRows() {
        return Array.from(document.querySelectorAll('.search-row'));
    }

    function searchRecords() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const allRows = getAllRows();

        if (input === '') {
            filteredRows = allRows;
        } else {
            filteredRows = allRows.filter(row => {
                return row.getAttribute('data-search').includes(input);
            });
        }

        currentPage = 1;
        renderPage();
    }

    function renderPage() {
        const allRows = getAllRows();
        const resultCount = document.getElementById('resultCount');
        const noResults = document.getElementById('noResults');
        const start = (currentPage - 1) * ROWS_PER_PAGE;
        const end = start + ROWS_PER_PAGE;

        // Hide all rows first
        allRows.forEach(row => row.style.display = 'none');

        // Show only current page
        const pageRows = filteredRows.slice(start, end);
        pageRows.forEach(row => row.style.display = '');

        // Update count text
        if (filteredRows.length === 0) {
            noResults.classList.remove('hidden');
            resultCount.textContent = 'No results found.';
        } else {
            noResults.classList.add('hidden');
            resultCount.textContent =
                `Showing ${start + 1}–${Math.min(end, filteredRows.length)} of ${filteredRows.length} household(s)`;
        }

        renderPagination();
    }

    function renderPagination() {
        const totalPages = Math.ceil(filteredRows.length / ROWS_PER_PAGE);
        const container = document.getElementById('paginationControls');
        container.innerHTML = '';

        if (totalPages <= 1) return;

        // Prev button
        const prev = document.createElement('button');
        prev.textContent = '← Prev';
        prev.className = `px-4 py-2 rounded-xl text-sm font-semibold mr-1 transition-colors
            ${currentPage === 1
                ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
                : 'bg-blue-700 text-white hover:bg-blue-800'}`;
        prev.disabled = currentPage === 1;
        prev.onclick = () => { currentPage--; renderPage(); };
        container.appendChild(prev);

        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement('button');
            btn.textContent = i;
            btn.className = `px-4 py-2 rounded-xl text-sm font-semibold mx-1 transition-colors
                ${i === currentPage
                    ? 'bg-blue-700 text-white'
                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200'}`;
            btn.onclick = () => { currentPage = i; renderPage(); };
            container.appendChild(btn);
        }

        // Next button
        const next = document.createElement('button');
        next.textContent = 'Next →';
        next.className = `px-4 py-2 rounded-xl text-sm font-semibold ml-1 transition-colors
            ${currentPage === totalPages
                ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
                : 'bg-blue-700 text-white hover:bg-blue-800'}`;
        next.disabled = currentPage === totalPages;
        next.onclick = () => { currentPage++; renderPage(); };
        container.appendChild(next);
    }

    function clearSearch() {
        document.getElementById('searchInput').value = '';
        filteredRows = getAllRows();
        currentPage = 1;
        renderPage();
    }

    // Initialize on load
    window.onload = function() {
        filteredRows = getAllRows();
        renderPage();
    };
</script>

@endsection