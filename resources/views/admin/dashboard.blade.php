@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')
<h2 class="text-2xl font-bold text-blue-800 mb-6">Admin Dashboard</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-blue-700 text-white rounded-lg p-6 shadow">
        <p class="text-sm uppercase tracking-wide">Total Households</p>
        <p class="text-4xl font-bold mt-2">{{ $totalHouseholds }}</p>
    </div>
    <div class="bg-green-600 text-white rounded-lg p-6 shadow">
        <p class="text-sm uppercase tracking-wide">Total Residents</p>
        <p class="text-4xl font-bold mt-2">{{ $totalResidents }}</p>
    </div>
    <div class="bg-purple-600 text-white rounded-lg p-6 shadow">
        <p class="text-sm uppercase tracking-wide">Registered Users</p>
        <p class="text-4xl font-bold mt-2">{{ $totalUsers }}</p>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-4">Puroks Covered</h3>
    <div class="flex flex-wrap gap-2">
        @foreach($puroks as $purok)
            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">{{ $purok }}</span>
        @endforeach
    </div>
</div>

<div class="mt-6">
    <a href="{{ route('households.index') }}"
       class="bg-blue-700 text-white px-5 py-2 rounded hover:bg-blue-800">
        Manage All Households →
    </a>
</div>
@endsection