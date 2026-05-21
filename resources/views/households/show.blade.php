    @extends('layouts.app')
    @section('title', 'Household Details')
    @section('content')

    <div class="mb-4">
        <a href="{{ route('households.index') }}" class="text-blue-600 hover:underline">← Back to Households</a>
    </div>

    {{-- Household Info Card --}}
    <div class="bg-white rounded-2xl shadow-md p-6 mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-2xl font-bold text-blue-800 mb-1">
                    House #{{ $household->house_number }} — {{ $household->street }}, {{ $household->purok }}
                </h2>
                <p class="text-gray-500 text-sm mb-2">Registered by: {{ $household->user->name }}</p>
                <span class="px-3 py-1 rounded-full text-xs font-bold
                    {{ ($household->residency_type ?? 'Permanent') == 'Permanent'
                        ? 'bg-green-100 text-green-700'
                        : 'bg-yellow-100 text-yellow-700' }}">
                    {{ ($household->residency_type ?? 'Permanent') == 'Permanent'
                        ? '🏠 Permanent Resident'
                        : '🏨 Temporary (Boarder/Visitor)' }}
                </span>
            </div>
            {{-- Only Admin can Edit household --}}
            @if(auth()->user()->isAdmin())
            <a href="{{ route('households.edit', $household) }}"
            class="bg-yellow-500 text-white px-4 py-2 rounded-xl hover:bg-yellow-600 text-sm font-semibold">
                ✏️ Edit Household
            </a>
            @endif
        </div>
    </div>

    {{-- Residents Section --}}
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-semibold text-gray-700">
            👨‍👩‍👧‍👦 Residents ({{ $household->residents->count() }})
        </h3>
        {{-- Only Admin can Add Resident --}}
        @if(auth()->user()->isAdmin())
            <a href="{{ route('residents.create', $household) }}"
            class="bg-green-600 text-white px-4 py-2 rounded-xl hover:bg-green-700 text-sm font-semibold">
                + Add Resident
            </a>
        @endif
    </div>

    <div class="overflow-x-auto bg-white rounded-2xl shadow-md">
        <table class="w-full text-sm text-left">
            <thead class="bg-blue-800 text-white">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Full Name</th>
                    <th class="px-4 py-3">Birthdate</th>
                    <th class="px-4 py-3">Gender</th>
                    <th class="px-4 py-3">Relationship</th>
                    <th class="px-4 py-3">Contact</th>
                    {{-- Only show Actions column to Admin --}}
                    @if(auth()->user()->isAdmin())
                    <th class="px-4 py-3">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($household->residents as $resident)
                <tr class="border-b hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 text-gray-500">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 font-semibold text-gray-800">
                        {{ $resident->first_name }} {{ $resident->last_name }}
                    </td>
                    <td class="px-4 py-3 text-gray-600">
                        {{ \Carbon\Carbon::parse($resident->birthdate)->format('M d, Y') }}
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $resident->gender }}</td>
                    <td class="px-4 py-3">
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold">
                            {{ $resident->relationship }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $resident->contact_number ?? '—' }}</td>

                    {{-- Actions: Admin Only --}}
                    @if(auth()->user()->isAdmin())
                    <td class="px-4 py-3">
                        <div class="flex gap-2">
                            <a href="{{ route('residents.edit', $resident) }}"
                            class="text-yellow-600 hover:underline text-xs font-semibold">✏️ Edit</a>
                            <form method="POST" action="{{ route('residents.destroy', $resident) }}"
                                onsubmit="return confirm('Remove this resident?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="text-red-600 hover:underline text-xs font-semibold">🗑️ Delete</button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ auth()->user()->isAdmin() ? 7 : 6 }}"
                        class="px-4 py-8 text-center text-gray-400">
                        <p class="text-3xl mb-2">👥</p>
                        <p>No residents added yet.</p>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('residents.create', $household) }}"
                            class="text-blue-600 hover:underline text-sm mt-2 inline-block">
                                + Add the first resident
                            </a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Notice for non-admin residents --}}
    @if(!auth()->user()->isAdmin())
    <div class="mt-4 bg-blue-50 border border-blue-200 rounded-2xl p-5">
        <div class="flex items-start gap-3">
            <span class="text-2xl">ℹ️</span>
            <div class="flex-1">
                <p class="text-blue-800 text-sm font-bold mb-1">
                    Want to add, edit, or remove a household member?
                </p>
                <p class="text-blue-600 text-xs mb-3">
                    Resident information is managed by the Barangay Admin only
                    to ensure accuracy and prevent unauthorized changes.
                    You can send a request to the Admin through our
                    <strong>Concern/Request</strong> form and they will
                    process your request as soon as possible.
                </p>
                <a href="{{ route('concerns.create') }}?category=Personal+Info+Change"
                class="inline-flex items-center gap-2 bg-blue-700 text-white px-4 py-2 rounded-xl hover:bg-blue-800 text-xs font-semibold transition-colors">
                    📝 Send Request to Admin
                </a>
            </div>
        </div>
    </div>
    @endif

    @endsection