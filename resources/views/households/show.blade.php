@extends('layouts.app')
@section('title', 'Household Details')
@section('content')
<div class="mb-4">
    <a href="{{ route('households.index') }}" class="text-blue-600 hover:underline">← Back to Households</a>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-2xl font-bold text-blue-800 mb-2">
        House #{{ $household->house_number }} — {{ $household->street }}, {{ $household->purok }}
    </h2>
    <p class="text-gray-500 text-sm">Registered by: {{ $household->user->name }}</p>
</div>

<div class="flex justify-between items-center mb-4">
    <h3 class="text-xl font-semibold text-gray-700">Residents ({{ $household->residents->count() }})</h3>
    <a href="{{ route('residents.create', $household) }}"
       class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">
        + Add Resident
    </a>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="px-4 py-3">#</th>
                <th class="px-4 py-3">Full Name</th>
                <th class="px-4 py-3">Birthdate</th>
                <th class="px-4 py-3">Gender</th>
                <th class="px-4 py-3">Relationship</th>
                <th class="px-4 py-3">Contact</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($household->residents as $resident)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                <td class="px-4 py-3">{{ $resident->first_name }} {{ $resident->last_name }}</td>
                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($resident->birthdate)->format('M d, Y') }}</td>
                <td class="px-4 py-3">{{ $resident->gender }}</td>
                <td class="px-4 py-3">{{ $resident->relationship }}</td>
                <td class="px-4 py-3">{{ $resident->contact_number ?? '—' }}</td>
                <td class="px-4 py-3 flex gap-2">
                    <a href="{{ route('residents.edit', $resident) }}"
                       class="text-yellow-600 hover:underline">Edit</a>
                    @if(auth()->user()->isAdmin())
                    <form method="POST" action="{{ route('residents.destroy', $resident) }}"
                          onsubmit="return confirm('Remove this resident?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-4 py-6 text-center text-gray-400">No residents added yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection