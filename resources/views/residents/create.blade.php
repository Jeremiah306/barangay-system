@extends('layouts.app')
@section('title', 'Add Resident')
@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-2xl font-bold text-blue-800 mb-6">Add Resident to House #{{ $household->house_number }}</h2>

    <form method="POST" action="{{ route('residents.store', $household) }}">
        @csrf
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 font-medium mb-1">First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name') }}"
                    class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name') }}"
                    class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Birthdate</label>
            <input type="date" name="birthdate" value="{{ old('birthdate') }}"
                class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Gender</label>
            <select name="gender" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                <option value="">-- Select --</option>
                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Relationship to Head</label>
            <select name="relationship" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                <option value="">-- Select --</option>
                <option value="Head">Head of Family</option>
                <option value="Spouse">Spouse</option>
                <option value="Child">Child</option>
                <option value="Parent">Parent</option>
                <option value="Sibling">Sibling</option>
                <option value="Relative">Relative</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-1">Contact Number <span class="text-gray-400 text-xs">(optional)</span></label>
            <input type="text" name="contact_number" value="{{ old('contact_number') }}"
                class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
                placeholder="e.g. 09XX-XXX-XXXX">
        </div>
        <button type="submit"
            class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 font-semibold">
            Add Resident
        </button>
    </form>
</div>
@endsection