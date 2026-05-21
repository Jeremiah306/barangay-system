@extends('layouts.app')
@section('title', 'Register Household')
@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-md">
    <h2 class="text-2xl font-bold text-blue-800 mb-6">Register a Household</h2>

    <form method="POST" action="{{ route('households.store') }}">
        @csrf

        {{-- House Number --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">House Number</label>
            <select name="house_number"
                class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none" required>
                <option value="">-- Select House Number --</option>
                @for($i = 1; $i <= 300; $i++)
                    @foreach(['A','B','C','D','E','F','G','H'] as $letter)
                        <option value="{{ $i }}-{{ $letter }}"
                            {{ old('house_number') == "$i-$letter" ? 'selected' : '' }}>
                            {{ $i }}-{{ $letter }}
                        </option>
                    @endforeach
                @endfor
            </select>
            @error('house_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Street --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Street / Sitio</label>
            <select name="street"
                class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none" required>
                <option value="">-- Select Street --</option>
                <option value="Mabini Street" {{ old('street') == 'Mabini Street' ? 'selected' : '' }}>Mabini Street</option>
                <option value="Rizal Avenue" {{ old('street') == 'Rizal Avenue' ? 'selected' : '' }}>Rizal Avenue</option>
                <option value="Bonifacio Street" {{ old('street') == 'Bonifacio Street' ? 'selected' : '' }}>Bonifacio Street</option>
                <option value="Quezon Boulevard" {{ old('street') == 'Quezon Boulevard' ? 'selected' : '' }}>Quezon Boulevard</option>
                <option value="Magsaysay Avenue" {{ old('street') == 'Magsaysay Avenue' ? 'selected' : '' }}>Magsaysay Avenue</option>
                <option value="Luna Street" {{ old('street') == 'Luna Street' ? 'selected' : '' }}>Luna Street</option>
                <option value="Del Pilar Street" {{ old('street') == 'Del Pilar Street' ? 'selected' : '' }}>Del Pilar Street</option>
                <option value="Osmena Street" {{ old('street') == 'Osmena Street' ? 'selected' : '' }}>Osmena Street</option>
                <option value="Groove Street" {{ old('street') == 'Groove Street' ? 'selected' : '' }}>Groove Street</option>
                <option value="San Nicolas Street" {{ old('street') == 'San Nicolas Street' ? 'selected' : '' }}>San Nicolas Street</option>
                <option value="Compton Street" {{ old('street') == 'Compton Street' ? 'selected' : '' }}>Compton Street</option>
                <option value="Boulevard Avenue" {{ old('street') == 'Boulevard Avenue' ? 'selected' : '' }}>Boulevard Avenue</option>
            </select>
            @error('street') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Purok --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Purok</label>
            <select name="purok"
                class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none" required>
                <option value="">-- Select Purok --</option>
                <option value="Purok 1" {{ old('purok') == 'Purok 1' ? 'selected' : '' }}>Purok 1</option>
                <option value="Purok 2" {{ old('purok') == 'Purok 2' ? 'selected' : '' }}>Purok 2</option>
                <option value="Purok 3" {{ old('purok') == 'Purok 3' ? 'selected' : '' }}>Purok 3</option>
                <option value="Purok 4" {{ old('purok') == 'Purok 4' ? 'selected' : '' }}>Purok 4</option>
                <option value="Purok 5" {{ old('purok') == 'Purok 5' ? 'selected' : '' }}>Purok 5</option>
                <option value="Purok 6" {{ old('purok') == 'Purok 6' ? 'selected' : '' }}>Purok 6</option>
                <option value="Purok 7" {{ old('purok') == 'Purok 7' ? 'selected' : '' }}>Purok 7</option>
            </select>
            @error('purok') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Residency Type --}}
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-1">Residency Type</label>
            <select name="residency_type"
                class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none" required>
                <option value="">-- Select Type --</option>
                <option value="Permanent" {{ old('residency_type') == 'Permanent' ? 'selected' : '' }}>
                    🏠 Permanent Resident
                </option>
                <option value="Temporary" {{ old('residency_type') == 'Temporary' ? 'selected' : '' }}>
                    🏨 Temporary (Boarder / Visitor)
                </option>
            </select>
            @error('residency_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit"
            class="w-full bg-blue-700 text-white py-2 rounded-xl hover:bg-blue-800 font-semibold">
            Register Household
        </button>
    </form>
</div>
@endsection