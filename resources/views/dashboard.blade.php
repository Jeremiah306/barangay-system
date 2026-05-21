@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

@if(auth()->user()->isAdmin())
    {{-- ========== ADMIN VIEW ========== --}}

    {{-- Admin Welcome Banner --}}
    <div class="rounded-2xl p-8 mb-6 text-white relative overflow-hidden"
         style="background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 50%, #0369a1 100%);">
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-blue-200 text-sm font-medium mb-1">⚙️ Administrator</p>
                <h2 class="text-4xl font-bold mb-2">Welcome, {{ auth()->user()->name }}! 👋</h2>
                <p class="text-blue-200 text-sm">{{ now()->format('l, F d, Y') }}</p>
                <span class="inline-block mt-3 bg-white bg-opacity-20 border border-white border-opacity-30 text-white text-xs font-bold px-4 py-1 rounded-full uppercase tracking-widest">
                    Admin
                </span>
            </div>
            <div class="hidden md:block text-right">
                <p class="text-8xl opacity-30">🏛️</p>
            </div>
        </div>
        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-20 -mt-20"></div>
        <div class="absolute bottom-0 left-0 w-40 h-40 bg-white opacity-5 rounded-full -ml-10 -mb-10"></div>
    </div>

    {{-- Admin Stats --}}
    @php
        $totalHouseholds = \App\Models\Household::count();
        $totalResidents  = \App\Models\Resident::count();
        $totalUsers      = \App\Models\User::where('role', 'resident')->count();
        $puroks          = \App\Models\Household::select('purok')->distinct()->pluck('purok');
        $pendingCerts    = \App\Models\CertificateRequest::where('status', 'Pending')->count();
        $pendingConcerns = \App\Models\Concern::where('status', 'Pending')->count();
        $allHouseholds   = \App\Models\Household::with(['residents', 'user'])->get();
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
        <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-blue-600 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-1">Total Households</p>
                    <p class="text-5xl font-extrabold text-blue-700">{{ $totalHouseholds }}</p>
                    <p class="text-xs text-gray-400 mt-2">Registered households</p>
                </div>
                <div class="bg-blue-100 rounded-full p-4 text-4xl">🏠</div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-green-500 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-1">Total Residents</p>
                    <p class="text-5xl font-extrabold text-green-600">{{ $totalResidents }}</p>
                    <p class="text-xs text-gray-400 mt-2">Individuals recorded</p>
                </div>
                <div class="bg-green-100 rounded-full p-4 text-4xl">👥</div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-purple-500 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-1">Registered Users</p>
                    <p class="text-5xl font-extrabold text-purple-600">{{ $totalUsers }}</p>
                    <p class="text-xs text-gray-400 mt-2">Active accounts</p>
                </div>
                <div class="bg-purple-100 rounded-full p-4 text-4xl">👤</div>
            </div>
        </div>
    </div>

    {{-- Pending Alerts --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
        <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-yellow-400 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-1">Pending Certificate Requests</p>
                    <p class="text-5xl font-extrabold text-yellow-500">{{ $pendingCerts }}</p>
                    <a href="{{ route('certificates.admin') }}" class="text-xs text-blue-600 hover:underline mt-2 inline-block">View all →</a>
                </div>
                <div class="bg-yellow-100 rounded-full p-4 text-4xl">📄</div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-red-400 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-1">Pending Concern Reports</p>
                    <p class="text-5xl font-extrabold text-red-500">{{ $pendingConcerns }}</p>
                    <a href="{{ route('concerns.admin') }}" class="text-xs text-blue-600 hover:underline mt-2 inline-block">View all →</a>
                </div>
                <div class="bg-red-100 rounded-full p-4 text-4xl">📝</div>
            </div>
        </div>
    </div>

    {{-- Admin Bottom Section --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

        {{-- Puroks --}}
        <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition-all">
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
        <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition-all">
            <h3 class="text-lg font-bold text-gray-700 mb-4">⚡ Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('households.index') }}"
                   class="flex items-center gap-3 p-3 rounded-xl bg-blue-50 hover:bg-blue-100 transition-colors group">
                    <span class="bg-blue-200 rounded-lg p-2 text-xl group-hover:scale-110 transition-transform">🏠</span>
                    <div>
                        <p class="text-sm font-semibold text-blue-800">Manage All Households</p>
                        <p class="text-xs text-gray-500">View, edit, or delete records</p>
                    </div>
                    <span class="ml-auto text-blue-400 font-bold">→</span>
                </a>
                <a href="{{ route('announcements.create') }}"
                   class="flex items-center gap-3 p-3 rounded-xl bg-yellow-50 hover:bg-yellow-100 transition-colors group">
                    <span class="bg-yellow-200 rounded-lg p-2 text-xl group-hover:scale-110 transition-transform">📢</span>
                    <div>
                        <p class="text-sm font-semibold text-yellow-800">Post Announcement</p>
                        <p class="text-xs text-gray-500">Notify residents of events or news</p>
                    </div>
                    <span class="ml-auto text-yellow-400 font-bold">→</span>
                </a>
                <a href="{{ route('certificates.admin') }}"
                   class="flex items-center gap-3 p-3 rounded-xl bg-green-50 hover:bg-green-100 transition-colors group">
                    <span class="bg-green-200 rounded-lg p-2 text-xl group-hover:scale-110 transition-transform">📄</span>
                    <div>
                        <p class="text-sm font-semibold text-green-800">Certificate Requests</p>
                        <p class="text-xs text-gray-500">Approve or reject requests</p>
                    </div>
                    <span class="ml-auto text-green-400 font-bold">→</span>
                </a>
                <a href="{{ route('concerns.admin') }}"
                   class="flex items-center gap-3 p-3 rounded-xl bg-red-50 hover:bg-red-100 transition-colors group">
                    <span class="bg-red-200 rounded-lg p-2 text-xl group-hover:scale-110 transition-transform">📝</span>
                    <div>
                        <p class="text-sm font-semibold text-red-800">Concern Reports</p>
                        <p class="text-xs text-gray-500">Respond to resident concerns</p>
                    </div>
                    <span class="ml-auto text-red-400 font-bold">→</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Summary Bar --}}
    <div class="bg-white rounded-2xl shadow-md p-6 mb-6">
        <h3 class="text-lg font-bold text-gray-700 mb-4">📈 System Summary</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
            <div class="p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl">
                <p class="text-3xl font-extrabold text-blue-700">
                    {{ $totalResidents > 0 && $totalHouseholds > 0
                        ? number_format($totalResidents / $totalHouseholds, 1)
                        : 0 }}
                </p>
                <p class="text-xs text-gray-500 mt-1 font-medium">Avg. Residents per Household</p>
            </div>
            <div class="p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-xl">
                <p class="text-3xl font-extrabold text-green-600">{{ $puroks->count() }}</p>
                <p class="text-xs text-gray-500 mt-1 font-medium">Total Puroks Covered</p>
            </div>
            <div class="p-4 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl">
                <p class="text-3xl font-extrabold text-purple-600">
                    {{ $totalUsers > 0 ? round(($totalHouseholds / $totalUsers) * 100) : 0 }}%
                </p>
                <p class="text-xs text-gray-500 mt-1 font-medium">Household Registration Rate</p>
            </div>
        </div>
    </div>

    {{-- Search Bar Section --}}
    <div class="bg-white rounded-2xl shadow-md p-6 mb-6">
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
            Showing all {{ $allHouseholds->count() }} household(s)
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
                        <td class="px-4 py-3 text-gray-500">{{ $loop->iteration }}</td>
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
            <div id="noResults" class="hidden text-center py-10 text-gray-400">
                <p class="text-4xl mb-2">🔍</p>
                <p class="font-semibold">No records found matching your search.</p>
                <p class="text-xs mt-1">Try searching by house number, street, purok, or resident name.</p>
            </div>
        </div>
    </div>

    <script>
        function searchRecords() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('.search-row');
            const resultCount = document.getElementById('resultCount');
            let visibleCount = 0;
            rows.forEach(row => {
                const data = row.getAttribute('data-search');
                if (data.includes(input)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            const noResults = document.getElementById('noResults');
            if (visibleCount === 0 && input !== '') {
                noResults.classList.remove('hidden');
                resultCount.textContent = 'No results found.';
            } else {
                noResults.classList.add('hidden');
                resultCount.textContent = `Showing ${visibleCount} household(s)`;
            }
        }
        function clearSearch() {
            document.getElementById('searchInput').value = '';
            searchRecords();
        }
    </script>

@else
    {{-- ========== RESIDENT VIEW ========== --}}

    {{-- Resident Welcome Banner --}}
    <div class="rounded-2xl p-8 mb-6 text-white relative overflow-hidden"
         style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);">
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <h2 class="text-4xl font-bold mb-2">Welcome, {{ auth()->user()->name }}! 👋</h2>
                <p class="text-blue-200 text-sm">{{ now()->format('l, F d, Y') }}</p>
                <span class="inline-block mt-3 bg-white bg-opacity-20 border border-white border-opacity-30 text-white text-xs font-bold px-4 py-1 rounded-full uppercase tracking-widest">
                    Resident
                </span>
            </div>
            <div class="hidden md:block text-8xl opacity-20">🏘️</div>
        </div>
        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-20 -mt-20"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

        {{-- Household Card --}}
        <div class="md:col-span-2 bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition-all">
            <h3 class="text-lg font-bold text-gray-700 mb-4">🏠 My Household(s)</h3>

            @if(auth()->user()->households->count() > 0)
                @foreach(auth()->user()->households as $house)
                <div class="border border-gray-200 rounded-xl p-4 mb-4">
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div class="bg-blue-50 rounded-xl p-3">
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">House No.</p>
                            <p class="text-xl font-extrabold text-blue-800">{{ $house->house_number }}</p>
                        </div>
                        <div class="bg-blue-50 rounded-xl p-3">
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Purok</p>
                            <p class="text-xl font-extrabold text-blue-800">{{ $house->purok }}</p>
                        </div>
                        <div class="bg-blue-50 rounded-xl p-3">
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Street</p>
                            <p class="text-base font-bold text-blue-800">{{ $house->street }}</p>
                        </div>
                        <div class="bg-green-50 rounded-xl p-3">
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Residents</p>
                            <p class="text-xl font-extrabold text-green-700">
                                {{ $house->residents->count() }} member(s)
                            </p>
                        </div>
                    </div>

                    {{-- Residency Type Badge --}}
                    <div class="mb-3">
                        <span class="px-3 py-1 rounded-full text-xs font-bold
                            {{ ($house->residency_type ?? 'Permanent') == 'Permanent'
                                ? 'bg-green-100 text-green-700'
                                : 'bg-yellow-100 text-yellow-700' }}">
                            {{ ($house->residency_type ?? 'Permanent') == 'Permanent'
                                ? '🏠 Permanent Resident'
                                : '🏨 Temporary (Boarder/Visitor)' }}
                        </span>
                    </div>

                    {{-- View Only - No Add Resident Button --}}
                    <a href="{{ route('households.show', $house) }}"
                       class="bg-blue-700 text-white px-4 py-2 rounded-xl hover:bg-blue-800 text-xs font-semibold transition-colors inline-block">
                        👁️ View Details
                    </a>
                </div>
                @endforeach

                <a href="{{ route('households.create') }}"
                   class="inline-block mt-2 text-blue-600 hover:underline text-sm">
                    + Register Another Household
                </a>
            @else
                <div class="text-center py-8">
                    <p class="text-6xl mb-4">🏚️</p>
                    <p class="text-gray-500 mb-4">You have not registered a household yet.</p>
                    <a href="{{ route('households.create') }}"
                       class="inline-block bg-green-600 text-white px-6 py-2 rounded-xl hover:bg-green-700 font-semibold transition-colors">
                        + Register Household Now
                    </a>
                </div>
            @endif

            {{-- Info Notice --}}
            <div class="mt-4 bg-blue-50 border border-blue-200 rounded-xl p-3">
                <p class="text-blue-700 text-xs font-semibold">ℹ️ Notice</p>
                <p class="text-blue-600 text-xs mt-1">
                    To add, edit, or remove household members, please coordinate with
                    the Barangay Admin. This ensures accuracy and prevents unauthorized
                    changes to barangay records.
                </p>
            </div>
        </div>

        {{-- Quick Links --}}
        <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition-all">
            <h3 class="text-lg font-bold text-gray-700 mb-4">🔗 Quick Links</h3>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('announcements.index') }}"
                       class="flex items-center gap-3 p-3 rounded-xl hover:bg-yellow-50 transition-colors group">
                        <span class="text-2xl group-hover:scale-110 transition-transform">📢</span>
                        <span class="text-sm font-medium text-gray-700">Announcements</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('certificates.index') }}"
                       class="flex items-center gap-3 p-3 rounded-xl hover:bg-blue-50 transition-colors group">
                        <span class="text-2xl group-hover:scale-110 transition-transform">📄</span>
                        <span class="text-sm font-medium text-gray-700">My Certificate Requests</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('certificates.create') }}"
                       class="flex items-center gap-3 p-3 rounded-xl hover:bg-blue-50 transition-colors group">
                        <span class="text-2xl group-hover:scale-110 transition-transform">➕</span>
                        <span class="text-sm font-medium text-gray-700">Request Certificate</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('concerns.index') }}"
                       class="flex items-center gap-3 p-3 rounded-xl hover:bg-red-50 transition-colors group">
                        <span class="text-2xl group-hover:scale-110 transition-transform">📝</span>
                        <span class="text-sm font-medium text-gray-700">My Concern Reports</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('concerns.create') }}"
                       class="flex items-center gap-3 p-3 rounded-xl hover:bg-red-50 transition-colors group">
                        <span class="text-2xl group-hover:scale-110 transition-transform">🚨</span>
                        <span class="text-sm font-medium text-gray-700">Report a Concern</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    {{-- NO Household Members Table for Residents --}}
    {{-- Members info is Admin-only for security --}}

@endif

@endsection