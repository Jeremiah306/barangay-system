@extends('layouts.app')
@section('title', 'Announcements')
@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-blue-800">📢 Announcements</h2>
        <p class="text-gray-500 text-sm mt-1">Latest news and updates from the Barangay</p>
    </div>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('announcements.create') }}"
           class="bg-blue-700 text-white px-5 py-2 rounded-xl hover:bg-blue-800 font-semibold text-sm">
            + Post Announcement
        </a>
    @endif
</div>

@forelse($announcements as $announcement)
<div class="bg-white rounded-2xl shadow-md p-6 mb-4 hover:shadow-lg transition-all border-l-4
    {{ $announcement->category == 'Emergency' ? 'border-red-500' :
       ($announcement->category == 'Event' ? 'border-yellow-500' :
       ($announcement->category == 'Cash Aid' ? 'border-green-500' : 'border-blue-500')) }}">

    <div class="flex justify-between items-start">
        <div class="flex-1">
            {{-- Category Badge --}}
            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold mb-2
                {{ $announcement->category == 'Emergency' ? 'bg-red-100 text-red-700' :
                   ($announcement->category == 'Event' ? 'bg-yellow-100 text-yellow-700' :
                   ($announcement->category == 'Cash Aid' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700')) }}">
                {{ $announcement->category }}
            </span>

            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $announcement->title }}</h3>
            <p class="text-gray-600 text-sm mb-3">{{ $announcement->content }}</p>

            <div class="flex gap-4 text-xs text-gray-400">
                @if($announcement->event_date)
                    <span>📅 {{ \Carbon\Carbon::parse($announcement->event_date)->format('F d, Y') }}</span>
                @endif
                <span>👤 Posted by {{ $announcement->author->name }}</span>
                <span>🕐 {{ $announcement->created_at->diffForHumans() }}</span>
            </div>
        </div>

        @if(auth()->user()->isAdmin())
        <form method="POST" action="{{ route('announcements.destroy', $announcement) }}"
              onsubmit="return confirm('Delete this announcement?')" class="ml-4">
            @csrf @method('DELETE')
            <button type="submit"
                class="text-red-500 hover:text-red-700 text-sm font-semibold">
                🗑️ Delete
            </button>
        </form>
        @endif
    </div>
</div>
@empty
<div class="text-center py-16 bg-white rounded-2xl shadow">
    <p class="text-5xl mb-4">📭</p>
    <p class="text-gray-500">No announcements yet.</p>
</div>
@endforelse

@endsection