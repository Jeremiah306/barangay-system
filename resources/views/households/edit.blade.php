@extends('layouts.app')
@section('title', 'Edit Household')
@section('content')

<div class="mb-4">
    <a href="{{ route('households.index') }}" class="text-blue-600 hover:underline">← Back to Households</a>
</div>

<div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-md">
    <h2 class="text-2xl font-bold text-blue-800 mb-6">Edit Household</h2>

    <form method="POST" action="{{ route('households.update', $household) }}">
        @csrf
        @method('PUT')

        {{-- House Number --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">House Number</label>
            <select name="house_number"
                class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none" required>
                <option value="">-- Select House Number --</option>
                @for($i = 1; $i <= 300; $i++)
                    @foreach(['A','B','C','D','E','F','G','H'] as $letter)
                        <option value="{{ $i }}-{{ $letter }}"
                            {{ $household->house_number == "$i-$letter" ? 'selected' : '' }}>
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
                @foreach([
                    'Mabini Street', 'Rizal Avenue', 'Bonifacio Street',
                    'Quezon Boulevard', 'Magsaysay Avenue', 'Luna Street',
                    'Del Pilar Street', 'Osmena Street', 'Groove Street',
                    'San Nicolas Street', 'Compton Street', 'Boulevard Avenue'
                ] as $street)
                    <option value="{{ $street }}"
                        {{ $household->street == $street ? 'selected' : '' }}>
                        {{ $street }}
                    </option>
                @endforeach
            </select>
            @error('street') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Purok --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Purok</label>
            <select name="purok"
                class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none" required>
                <option value="">-- Select Purok --</option>
                @foreach(['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'] as $purok)
                    <option value="{{ $purok }}"
                        {{ $household->purok == $purok ? 'selected' : '' }}>
                        {{ $purok }}
                    </option>
                @endforeach
            </select>
            @error('purok') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Residency Type --}}
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-1">Residency Type</label>
            <select name="residency_type"
                class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none" required>
                <option value="Permanent"
                    {{ ($household->residency_type ?? 'Permanent') == 'Permanent' ? 'selected' : '' }}>
                    🏠 Permanent Resident
                </option>
                <option value="Temporary"
                    {{ ($household->residency_type ?? '') == 'Temporary' ? 'selected' : '' }}>
                    🏨 Temporary (Boarder / Visitor)
                </option>
            </select>
            @error('residency_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-3">
            <button type="submit"
                class="w-full bg-blue-700 text-white py-2 rounded-xl hover:bg-blue-800 font-semibold">
                Update Household
            </button>
            <a href="{{ route('households.index') }}"
               class="w-full text-center bg-gray-200 text-gray-700 py-2 rounded-xl hover:bg-gray-300 font-semibold">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection