<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Information System - @yield('title', 'Home')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .nav-link.active {
            background-color: #1e40af;
            color: white !important;
            border-radius: 6px;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- NAVBAR -->
    <nav class="bg-blue-800 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-xl font-bold tracking-wide">
                🏘️ Barangay InfoSys
            </a>
            <div class="flex gap-2 items-center">
                <a href="{{ route('home') }}"
                   class="nav-link px-3 py-1 text-sm {{ request()->routeIs('home') ? 'active' : 'hover:bg-blue-700 rounded' }}">
                    Home
                </a>

                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                           class="nav-link px-3 py-1 text-sm {{ request()->routeIs('admin.dashboard') ? 'active' : 'hover:bg-blue-700 rounded' }}">
                            Admin Dashboard
                        </a>
                    @endif

                    <a href="{{ route('households.index') }}"
                       class="nav-link px-3 py-1 text-sm {{ request()->routeIs('households.*') ? 'active' : 'hover:bg-blue-700 rounded' }}">
                        Households
                    </a>
                    <a href="{{ route('households.create') }}"
                       class="nav-link px-3 py-1 text-sm {{ request()->routeIs('households.create') ? 'active' : 'hover:bg-blue-700 rounded' }}">
                        Register Household
                    </a>
                    <a href="{{ route('dashboard') }}"
                       class="nav-link px-3 py-1 text-sm {{ request()->routeIs('dashboard') ? 'active' : 'hover:bg-blue-700 rounded' }}">
                        My Profile
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="px-3 py-1 text-sm bg-red-500 hover:bg-red-600 rounded">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="nav-link px-3 py-1 text-sm {{ request()->routeIs('login') ? 'active' : 'hover:bg-blue-700 rounded' }}">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="nav-link px-3 py-1 text-sm {{ request()->routeIs('register') ? 'active' : 'hover:bg-blue-700 rounded' }}">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- FLASH MESSAGES -->
    <div class="max-w-7xl mx-auto px-4 mt-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- PAGE CONTENT -->
    <main class="max-w-7xl mx-auto px-4 py-6">
        @yield('content')
    </main>

    <footer class="text-center text-gray-500 text-sm py-6 mt-10">
        &copy; {{ date('Y') }} Barangay Information System. All rights reserved.
    </footer>
</body>
</html>