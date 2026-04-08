@extends('layouts.app')
@section('title', 'Edit Resident')
@section('content')

<div class="mb-4">
    <a href="{{ route('households.show', $resident->household_id) }}" 
       class="text-blue-600 hover:underline">← Back to Household</a>
</div>

<div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-2xl font-bold text-blue-800 mb-6">Edit Resident</h2>

    <form method="POST" action="{{ route('residents.update', $resident) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 font-medium mb-1">First Name</label>
                <input type="text" name="first_name" value="{{ $resident->first_name }}"
                    class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Last Name</label>
                <input type="text" name="last_name" value="{{ $resident->last_name }}"
                    class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Birthdate</label>
            <input type="date" name="birthdate" value="{{ $resident->birthdate }}"
                class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
            @error('birthdate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Gender</label>
            <select name="gender" 
                class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                <option value="">-- Select --</option>
                <option value="Male" {{ $resident->gender == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ $resident->gender == 'Female' ? 'selected' : '' }}>Female</option>
            </select>
            @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Relationship to Head</label>
            <select name="relationship" 
                class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                <option value="">-- Select --</option>
                <option value="Head" {{ $resident->relationship == 'Head' ? 'selected' : '' }}>Head of Family</option>
                <option value="Spouse" {{ $resident->relationship == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                <option value="Child" {{ $resident->relationship == 'Child' ? 'selected' : '' }}>Child</option>
                <option value="Parent" {{ $resident->relationship == 'Parent' ? 'selected' : '' }}>Parent</option>
                <option value="Sibling" {{ $resident->relationship == 'Sibling' ? 'selected' : '' }}>Sibling</option>
                <option value="Relative" {{ $resident->relationship == 'Relative' ? 'selected' : '' }}>Relative</option>
                <option value="Other" {{ $resident->relationship == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('relationship') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-1">
                Contact Number 
                <span class="text-gray-400 text-xs">(optional)</span>
            </label>
            <input type="text" name="contact_number" value="{{ $resident->contact_number }}"
                class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
                placeholder="e.g. 09XX-XXX-XXXX">
        </div>

        <div class="flex gap-3">
            <button type="submit"
                class="w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800 font-semibold">
                Update Resident
            </button>
            <a href="{{ route('households.show', $resident->household_id) }}"
               class="w-full text-center bg-gray-200 text-gray-700 py-2 rounded hover:bg-gray-300 font-semibold">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection