@extends('layouts.app')
@section('title', 'Report a Concern')
@section('content')

<div class="max-w-2xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('concerns.index') }}" class="text-blue-600 hover:underline">← Back to My Reports</a>
    </div>

    <div class="bg-white rounded-2xl shadow-md p-8">
        <h2 class="text-2xl font-bold text-blue-800 mb-2">📝 Report a Concern</h2>
        <p class="text-gray-500 text-sm mb-6">Report any issues or problems in your barangay.</p>

        <form method="POST" action="{{ route('concerns.store') }}">
            @csrf

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">Category</label>
                <select name="category"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none" required>
                    <option value="">-- Select Category --</option>
                    <option value="Personal Info Change"
                        {{ old('category', request('category')) == 'Personal Info Change' ? 'selected' : '' }}>
                        👤 Personal Info Change (Add/Edit/Remove Member)
                    </option>
                    <option value="Road"
                        {{ old('category') == 'Road' ? 'selected' : '' }}>
                        🛣️ Road / Infrastructure
                    </option>
                    <option value="Electricity"
                        {{ old('category') == 'Electricity' ? 'selected' : '' }}>
                        ⚡ Electricity
                    </option>
                    <option value="Water"
                        {{ old('category') == 'Water' ? 'selected' : '' }}>
                        💧 Water Supply
                    </option>
                    <option value="Noise"
                        {{ old('category') == 'Noise' ? 'selected' : '' }}>
                        🔊 Noise Complaint
                    </option>
                    <option value="Garbage"
                        {{ old('category') == 'Garbage' ? 'selected' : '' }}>
                        🗑️ Garbage / Sanitation
                    </option>
                    <option value="Safety"
                        {{ old('category') == 'Safety' ? 'selected' : '' }}>
                        🚨 Safety / Security
                    </option>
                    <option value="Others"
                        {{ old('category') == 'Others' ? 'selected' : '' }}>
                        📌 Others
                    </option>
                </select>
                @error('category')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">Title / Subject</label>
                <input type="text" name="title" value="{{ old('title') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                    placeholder="e.g. Damaged road near Purok 3" required>
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">Location</label>
                <input type="text" name="location" value="{{ old('location') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                    placeholder="e.g. Near the basketball court, Purok 2" required>
                @error('location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">Description</label>
                <textarea name="description" rows="5"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none resize-none"
                    placeholder="Describe the issue in detail..." required>{{ old('description') }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Important Notice --}}
            <div id="noticeBox" class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6">
                <p class="text-yellow-700 text-sm font-bold mb-2">⚠️ Important Notice:</p>
                <ul class="text-yellow-600 text-sm space-y-2 list-disc list-inside" id="generalNotice">
                    <li>Your request or report will be reviewed by the Barangay Admin.</li>
                    <li>Please wait for the Admin's response before taking any further action.</li>
                    <li>
                        You may track the status of your request anytime in the
                        <strong>Reports &amp; Requests</strong> section.
                    </li>
                </ul>

                {{-- Extra notice shown ONLY for Personal Info Change --}}
                <div id="personalInfoNotice" class="hidden mt-3 pt-3 border-t border-yellow-300">
                    <p class="text-yellow-800 text-sm font-bold mb-1">
                        📋 Additional Requirement for Personal Info Change:
                    </p>
                    <ul class="text-yellow-700 text-sm space-y-1 list-disc list-inside">
                        <li>
                            This notice applies <strong>only</strong> if you are requesting
                            to add, edit, or remove a household member.
                        </li>
                        <li>
                            Once your request is <strong>approved</strong> by the Admin,
                            you are required to visit the <strong>Barangay Hall</strong>
                            in person.
                        </li>
                        <li>
                            Please bring at least <strong>one (1) valid government-issued ID</strong>
                            (e.g., PhilSys ID, Driver's License, Passport, Voter's ID)
                            for identity verification purposes.
                        </li>
                        <li>
                            No changes will be applied to your records until you
                            have completed the in-person verification at the Barangay Hall.
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Script to show/hide personal info notice --}}
            <script>
                const categorySelect = document.querySelector('select[name="category"]');
                const personalInfoNotice = document.getElementById('personalInfoNotice');

                function toggleNotice() {
                    if (categorySelect.value === 'Personal Info Change') {
                        personalInfoNotice.classList.remove('hidden');
                    } else {
                        personalInfoNotice.classList.add('hidden');
                    }
                }

                // Run on page load (in case of old() value or URL param)
                toggleNotice();

                // Run on change
                categorySelect.addEventListener('change', toggleNotice);
            </script>

            <button type="submit"
                class="w-full bg-blue-700 text-white py-3 rounded-xl hover:bg-blue-800 font-bold transition-colors">
                📨 Submit Report
            </button>
        </form>
    </div>
</div>

@endsection