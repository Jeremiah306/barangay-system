@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="mb-6">
    <h2 class="text-2xl font-bold text-blue-800">
        Welcome, {{ auth()->user()->name }}! 👋
    </h2>
    <p class="text-gray-500 text-sm mt-1">
        Role: <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold uppercase">
            {{ auth()->user()->role }}
        </span>
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- My Household Card --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-3">🏠 My Household</h3>
        @if(auth()->user()->household)
            <p class="text-gray-600">
                <span class="font-medium">House No:</span>
                {{ auth()->user()->household->house_number }}
            </p>
            <p class="text-gray-600">
                <span class="font-medium">Street:</span>
                {{ auth()->user()->household->street }}
            </p>
            <p class="text-gray-600">
                <span class="font-medium">Purok:</span>
                {{ auth()->user()->household->purok }}
            </p>
            <p class="text-gray-600 mt-2">
                <span class="font-medium">Residents:</span>
                {{ auth()->user()->household->residents->count() }} member(s)
            </p>
            <a href="{{ route('households.show', auth()->user()->household) }}"
               class="inline-block mt-4 bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 text-sm">
                View Household →
            </a>
        @else
            <p class="text-gray-400 mb-4">You have not registered a household yet.</p>
            <a href="{{ route('households.create') }}"
               class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">
                + Register Household
            </a>
        @endif
    </div>

    {{-- Quick Links Card --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-3">🔗 Quick Links</h3>
        <ul class="space-y-2">
            <li>
                <a href="{{ route('households.index') }}"
                   class="block text-blue-600 hover:underline">
                    📋 View My Household Records
                </a>
            </li>
            <li>
                <a href="{{ route('households.create') }}"
                   class="block text-blue-600 hover:underline">
                    ➕ Register a Household
                </a>
            </li>
            @if(auth()->user()->isAdmin())
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="block text-blue-600 hover:underline">
                    ⚙️ Admin Dashboard
                </a>
            </li>
            @endif
        </ul>
    </div>

</div>
@endsection