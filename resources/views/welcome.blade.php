@extends('layouts.app')
@section('title', 'Home')
@section('content')
<div class="text-center py-16">
    <h1 class="text-4xl font-bold text-blue-800 mb-4">Welcome to the Barangay Information System</h1>
    <p class="text-gray-600 text-lg mb-8">A digital record of households and residents in our barangay.</p>
    @guest
        <a href="{{ route('register') }}"
           class="bg-blue-700 text-white px-6 py-3 rounded-lg mr-3 hover:bg-blue-800">
            Register Now
        </a>
        <a href="{{ route('login') }}"
           class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300">
            Login
        </a>
    @else
        <a href="{{ route('households.index') }}"
           class="bg-blue-700 text-white px-6 py-3 rounded-lg hover:bg-blue-800">
            View Households
        </a>
    @endguest
</div>
@endsection