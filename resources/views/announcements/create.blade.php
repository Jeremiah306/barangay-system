@extends('layouts.app')
@section('title', 'Post Announcement')
@section('content')

<div class="max-w-2xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('announcements.index') }}" class="text-blue-600 hover:underline">← Back to Announcements</a>
    </div>

    <div class="bg-white rounded-2xl shadow-md p-8">
        <h2 class="text-2xl font-bold text-blue-800 mb-6">📢 Post New Announcement</h2>

        <form method="POST" action="{{ route('announcements.store') }}">
            @csrf

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">Title</label>
                <input type="text" name="title" value="{{ old('title') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                    placeholder="e.g. Barangay Fiesta 2026" required>
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">Category</label>
                <select name="category"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none" required>
                    <option value="">-- Select Category --</option>
                    <option value="General" {{ old('category') == 'General' ? 'selected' : '' }}>📋 General</option>
                    <option value="Event" {{ old('category') == 'Event' ? 'selected' : '' }}>🎉 Event</option>
                    <option value="Cash Aid" {{ old('category') == 'Cash Aid' ? 'selected' : '' }}>💰 Cash Aid</option>
                    <option value="Emergency" {{ old('category') == 'Emergency' ? 'selected' : '' }}>🚨 Emergency</option>
                    <option value="Health" {{ old('category') == 'Health' ? 'selected' : '' }}>🏥 Health</option>
                    <option value="Others" {{ old('category') == 'Others' ? 'selected' : '' }}>📌 Others</option>
                </select>
                @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">
                    Event Date <span class="text-gray-400 text-xs">(optional)</span>
                </label>
                <input type="date" name="event_date" value="{{ old('event_date') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Content / Details</label>
                <textarea name="content" rows="5"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none resize-none"
                    placeholder="Write the announcement details here..." required>{{ old('content') }}</textarea>
                @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                class="w-full bg-blue-700 text-white py-3 rounded-xl hover:bg-blue-800 font-bold transition-colors">
                📢 Post Announcement
            </button>
        </form>
    </div>
</div>

@endsection