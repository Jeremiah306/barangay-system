@extends('layouts.app')
@section('title', 'Register Household')
@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-2xl font-bold text-blue-800 mb-6">Register a Household</h2>

    <form method="POST" action="{{ route('households.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">House Number</label>
            <input type="text" name="house_number" value="{{ old('house_number') }}"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="e.g. 123-A" required>
            @error('house_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Street / Sitio</label>
            <input type="text" name="street" value="{{ old('street') }}"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="e.g. Mabini Street" required>
            @error('street') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-1">Purok</label>
            <input type="text" name="purok" value="{{ old('purok') }}"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="e.g. Purok 3" required>
            @error('purok') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <button type="submit"
            class="w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800 font-semibold">
            Register Household
        </button>
    </form>
</div>
@endsection