@extends('layouts.app')
@section('title', 'Request Certificate')
@section('content')

<div class="max-w-2xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('certificates.index') }}" class="text-blue-600 hover:underline">← Back to My Requests</a>
    </div>

    <div class="bg-white rounded-2xl shadow-md p-8">
        <h2 class="text-2xl font-bold text-blue-800 mb-2">📄 Request a Certificate</h2>
        <p class="text-gray-500 text-sm mb-6">Fill out the form below. The admin will process your request.</p>

        <form method="POST" action="{{ route('certificates.store') }}">
            @csrf

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">Certificate Type</label>
                <select name="certificate_type"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none" required>
                    <option value="">-- Select Certificate --</option>
                    <option value="Barangay Certificate" {{ old('certificate_type') == 'Barangay Certificate' ? 'selected' : '' }}>
                        📋 Barangay Certificate
                    </option>
                    <option value="Barangay Clearance" {{ old('certificate_type') == 'Barangay Clearance' ? 'selected' : '' }}>
                        ✅ Barangay Clearance
                    </option>
                    <option value="Certificate of Indigency" {{ old('certificate_type') == 'Certificate of Indigency' ? 'selected' : '' }}>
                        📝 Certificate of Indigency
                    </option>
                    <option value="Cedula" {{ old('certificate_type') == 'Cedula' ? 'selected' : '' }}>
                        🪪 Cedula (Community Tax Certificate)
                    </option>
                    <option value="Certificate of Residency" {{ old('certificate_type') == 'Certificate of Residency' ? 'selected' : '' }}>
                        🏠 Certificate of Residency
                    </option>
                </select>
                @error('certificate_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Purpose</label>
                <input type="text" name="purpose" value="{{ old('purpose') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                    placeholder="e.g. For employment, For school requirements, etc." required>
                @error('purpose') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6">
                <p class="text-yellow-700 text-sm font-semibold">⚠️ Note:</p>
                <p class="text-yellow-600 text-sm">Your request will be reviewed by the Admin. Please wait for approval. You will see the status update in your requests list.</p>
            </div>

            <button type="submit"
                class="w-full bg-blue-700 text-white py-3 rounded-xl hover:bg-blue-800 font-bold transition-colors">
                📨 Submit Request
            </button>
        </form>
    </div>
</div>

@endsection