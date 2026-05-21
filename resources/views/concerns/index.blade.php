@extends('layouts.app')
@section('title', 'My Concern Reports')
@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-blue-800">📝 My Concern Reports</h2>
        <p class="text-gray-500 text-sm mt-1">Track your submitted reports and admin responses</p>
    </div>
    <a href="{{ route('concerns.create') }}"
       class="bg-red-600 text-white px-5 py-2 rounded-xl hover:bg-red-700 font-semibold text-sm">
        + Report a Concern
    </a>
</div>

@forelse($concerns as $concern)
<div class="bg-white rounded-2xl shadow-md p-6 mb-4 hover:shadow-lg transition-all border-l-4
    {{ $concern->status == 'Resolved'    ? 'border-green-500' :
       ($concern->status == 'Approved'   ? 'border-green-400' :
       ($concern->status == 'In Progress'? 'border-yellow-500' :
       ($concern->status == 'Rejected'   ? 'border-red-500' : 'border-gray-300'))) }}">

    <div class="flex justify-between items-start mb-3">
        <div>
            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold mb-2
                {{ $concern->category == 'Personal Info Change'
                    ? 'bg-blue-100 text-blue-800 border border-blue-300'
                    : 'bg-gray-100 text-gray-600' }}">
                {{ $concern->category == 'Personal Info Change' ? '👤' : '' }}
                {{ $concern->category }}
            </span>
            <h3 class="text-lg font-bold text-gray-800">{{ $concern->title }}</h3>
            <p class="text-gray-500 text-xs">📍 {{ $concern->location }}</p>
        </div>

        <span class="px-3 py-1 rounded-full text-xs font-bold
            {{ $concern->status == 'Approved'    ? 'bg-green-100 text-green-700' :
               ($concern->status == 'Resolved'   ? 'bg-blue-100 text-blue-700' :
               ($concern->status == 'In Progress'? 'bg-yellow-100 text-yellow-700' :
               ($concern->status == 'Rejected'   ? 'bg-red-100 text-red-700' :
                                                   'bg-gray-100 text-gray-600'))) }}">
            {{ $concern->status == 'Pending'     ? '⏳' :
              ($concern->status == 'In Progress' ? '🔧' :
              ($concern->status == 'Approved'    ? '✅' :
              ($concern->status == 'Resolved'    ? '🏁' : '❌'))) }}
            {{ $concern->status }}
        </span>
    </div>

    <p class="text-gray-600 text-sm mb-3">{{ $concern->description }}</p>

    {{-- Rejected simple message --}}
    @if($concern->status == 'Rejected')
        <p class="text-red-500 text-xs mb-3">
            ❌ Your report was rejected. You may submit a new one if needed.
        </p>
    @endif

    {{-- Admin Response --}}
    @if($concern->admin_response)
    <div class="mt-3 rounded-xl p-3
        {{ $concern->status == 'Approved'
            ? 'bg-green-50 border border-green-200'
            : 'bg-blue-50 border border-blue-200' }}">
        <p class="text-xs font-bold mb-1
            {{ $concern->status == 'Approved' ? 'text-green-700' : 'text-blue-700' }}">
            💬 Admin Response:
        </p>
        <p class="text-sm
            {{ $concern->status == 'Approved' ? 'text-green-600' : 'text-blue-600' }}">
            {{ $concern->admin_response }}
        </p>
    </div>
    @endif

    {{-- ✅ Approved Notice for Personal Info Change --}}
    {{-- Shows REGARDLESS of whether admin wrote a response --}}
    @if($concern->status == 'Approved' && $concern->category == 'Personal Info Change')
    <div class="mt-3 bg-yellow-50 border border-yellow-300 rounded-xl p-4">
        <p class="text-yellow-700 text-sm font-bold mb-2">
            📋 Next Steps — Action Required:
        </p>
        <ul class="text-yellow-600 text-xs space-y-1 list-disc list-inside">
            <li>Your request has been <strong>approved!</strong></li>
            <li>
                Please visit the <strong>Barangay Hall</strong> in person
                as soon as possible.
            </li>
            <li>
                Bring at least <strong>one (1) valid government-issued ID</strong>
                (e.g., PhilSys ID, Driver's License, Passport, Voter's ID)
                for identity verification purposes.
            </li>
            <li>
                No changes will be applied to your records until you have
                completed the in-person verification at the Barangay Hall.
            </li>
        </ul>
    </div>
    @endif

    {{-- ✅ Approved Notice for other categories --}}
    @if($concern->status == 'Approved' && $concern->category != 'Personal Info Change')
    <div class="mt-3 bg-green-50 border border-green-200 rounded-xl p-4">
        <p class="text-green-700 text-sm font-bold mb-1">
            ✅ Your concern has been approved and is being addressed!
        </p>
        <p class="text-green-600 text-xs">
            The Barangay Admin has noted your concern and will take the
            necessary action. Thank you for reporting!
        </p>
    </div>
    @endif

    <p class="text-xs text-gray-400 mt-3">
        Submitted: {{ $concern->created_at->format('M d, Y') }}
    </p>
</div>

@empty
<div class="text-center py-16 bg-white rounded-2xl shadow">
    <p class="text-5xl mb-4">📭</p>
    <p class="text-gray-500 mb-4">No concerns reported yet.</p>
    <a href="{{ route('concerns.create') }}"
       class="bg-red-600 text-white px-6 py-2 rounded-xl hover:bg-red-700 font-semibold">
        Report a Concern
    </a>
</div>
@endforelse

@endsection