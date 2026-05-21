<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Information System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('{{ asset("images/barangay-bg.jpg") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
        }
        .overlay {
            background: rgba(0, 0, 0, 0.60);
            min-height: 100vh;
        }
        .nav-link.active {
            background-color: #1e40af;
            color: white !important;
            border-radius: 6px;
            padding: 4px 12px;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 16px;
        }
        .announcement-card {
            background: rgba(255, 255, 255, 0.10);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.20);
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        .announcement-card:hover {
            background: rgba(255, 255, 255, 0.18);
            transform: translateY(-2px);
        }
        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-fade-in { animation: fadeInRight 0.6s ease forwards; }
        .animate-fade-in:nth-child(1) { animation-delay: 0.1s; }
        .animate-fade-in:nth-child(2) { animation-delay: 0.2s; }
        .animate-fade-in:nth-child(3) { animation-delay: 0.3s; }
        .badge-event     { background: rgba(234,179,8,0.3); color: #fde68a; border: 1px solid rgba(234,179,8,0.4); }
        .badge-emergency { background: rgba(239,68,68,0.3); color: #fca5a5; border: 1px solid rgba(239,68,68,0.4); }
        .badge-cash      { background: rgba(34,197,94,0.3); color: #86efac; border: 1px solid rgba(34,197,94,0.4); }
        .badge-health    { background: rgba(14,165,233,0.3); color: #7dd3fc; border: 1px solid rgba(14,165,233,0.4); }
        .badge-general   { background: rgba(139,92,246,0.3); color: #c4b5fd; border: 1px solid rgba(139,92,246,0.4); }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="bg-blue-900 bg-opacity-80 backdrop-blur-md text-white shadow-lg relative z-50">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-xl font-bold tracking-wide">
            🏘️ Barangay InfoSys
        </a>
        <div class="flex gap-2 items-center flex-wrap">
            <a href="{{ route('home') }}" class="nav-link active px-3 py-1 text-sm">Home</a>

            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('households.index') }}" class="nav-link px-3 py-1 text-sm hover:bg-blue-700 rounded">Households</a>
                    <a href="{{ route('announcements.index') }}" class="nav-link px-3 py-1 text-sm hover:bg-blue-700 rounded">📢 Announcements</a>
                    <a href="{{ route('certificates.admin') }}" class="nav-link px-3 py-1 text-sm hover:bg-blue-700 rounded">📄 Certificates</a>
                    <a href="{{ route('concerns.admin') }}" class="nav-link px-3 py-1 text-sm hover:bg-blue-700 rounded">📝 Concerns</a>
                    {{-- Records Link --}}
                    <a href="{{ route('logs.index') }}" class="nav-link px-3 py-1 text-sm hover:bg-blue-700 rounded">📋 Records</a>
                    <a href="{{ route('dashboard') }}" class="nav-link px-3 py-1 text-sm hover:bg-blue-700 rounded">⚙️ Admin Dashboard</a>
                @else
                    <a href="{{ route('households.index') }}" class="nav-link px-3 py-1 text-sm hover:bg-blue-700 rounded">Households</a>
                    <a href="{{ route('announcements.index') }}" class="nav-link px-3 py-1 text-sm hover:bg-blue-700 rounded">📢 Announcements</a>
                    <a href="{{ route('certificates.index') }}" class="nav-link px-3 py-1 text-sm hover:bg-blue-700 rounded">📄 Certificates</a>
                    <a href="{{ route('concerns.index') }}" class="nav-link px-3 py-1 text-sm hover:bg-blue-700 rounded">📝 Reports</a>
                    <a href="{{ route('dashboard') }}" class="nav-link px-3 py-1 text-sm hover:bg-blue-700 rounded">My Profile</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-1 text-sm bg-red-500 hover:bg-red-600 rounded">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="nav-link px-3 py-1 text-sm hover:bg-blue-700 rounded">Login</a>
                <a href="{{ route('register') }}" class="nav-link px-3 py-1 text-sm hover:bg-blue-700 rounded">Register</a>
            @endauth
        </div>
    </div>
</nav>

{{-- MAIN CONTENT --}}
<div class="overlay">
    <div class="max-w-7xl mx-auto px-4 py-0 min-h-screen flex items-center">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 w-full py-10">

            {{-- LEFT: HERO SECTION --}}
            <div class="flex flex-col justify-center text-white">
                <div class="inline-block glass-card px-4 py-2 text-sm mb-6 w-fit">
                    🏛️ Official Barangay Digital Record System
                </div>
                <h1 class="text-5xl md:text-6xl font-bold mb-4 leading-tight drop-shadow-lg">
                    Welcome to the <br>
                    <span class="text-blue-300">Barangay Information</span> System
                </h1>
                <p class="text-gray-200 text-lg mb-8 max-w-lg">
                    A digital record of households and residents in our barangay.
                    Register your household and help us serve you better.
                </p>
                <div class="flex gap-8 mb-8">
                    <div class="text-center">
                        <p class="text-3xl font-bold text-blue-300">🏠</p>
                        <p class="text-xs text-gray-300 mt-1">Household Records</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-blue-300">👨‍👩‍👧‍👦</p>
                        <p class="text-xs text-gray-300 mt-1">Family Members</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-blue-300">📋</p>
                        <p class="text-xs text-gray-300 mt-1">Barangay Data</p>
                    </div>
                </div>
                @guest
                    <div class="flex gap-4 flex-wrap">
                        <a href="{{ route('register') }}"
                           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-lg shadow-lg transition-all duration-200">
                            📝 Register Now
                        </a>
                        <a href="{{ route('login') }}"
                           class="glass-card hover:bg-white hover:bg-opacity-20 text-white font-semibold px-8 py-3 rounded-lg shadow-lg transition-all duration-200">
                            🔐 Login
                        </a>
                    </div>
                @else
                    <div class="flex gap-4 flex-wrap">
                        <a href="{{ route('households.index') }}"
                           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-lg shadow-lg transition-all duration-200">
                            🏠 View Households
                        </a>
                        <a href="{{ route('dashboard') }}"
                           class="glass-card hover:bg-white hover:bg-opacity-20 text-white font-semibold px-8 py-3 rounded-lg shadow-lg transition-all duration-200">
                            📊 My Dashboard
                        </a>
                    </div>
                @endguest
            </div>

            {{-- RIGHT PANEL --}}
            @auth
            <div class="flex flex-col justify-center">
                <div class="glass-card p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <span class="text-2xl">📢</span>
                            <div>
                                <h2 class="text-white font-bold text-lg">Barangay Announcements</h2>
                                <p class="text-gray-300 text-xs">Latest news and updates</p>
                            </div>
                        </div>
                        <a href="{{ route('announcements.index') }}"
                           class="text-blue-300 hover:text-white text-xs font-semibold transition-colors">
                            View all →
                        </a>
                    </div>
                    <div class="space-y-3 max-h-96 overflow-y-auto pr-1">
                        @forelse($announcements as $announcement)
                        <div class="announcement-card p-4 animate-fade-in">
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <span class="text-xs font-bold px-2 py-1 rounded-full
                                    {{ $announcement->category == 'Emergency' ? 'badge-emergency' :
                                       ($announcement->category == 'Event' ? 'badge-event' :
                                       ($announcement->category == 'Cash Aid' ? 'badge-cash' :
                                       ($announcement->category == 'Health' ? 'badge-health' : 'badge-general'))) }}">
                                    {{ $announcement->category == 'Emergency' ? '🚨' :
                                       ($announcement->category == 'Event' ? '🎉' :
                                       ($announcement->category == 'Cash Aid' ? '💰' :
                                       ($announcement->category == 'Health' ? '🏥' : '📋'))) }}
                                    {{ $announcement->category }}
                                </span>
                                <span class="text-gray-400 text-xs whitespace-nowrap">
                                    {{ $announcement->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <h3 class="text-white font-bold text-sm mb-1">{{ $announcement->title }}</h3>
                            <p class="text-gray-300 text-xs leading-relaxed line-clamp-2">{{ $announcement->content }}</p>
                            @if($announcement->event_date)
                            <div class="flex items-center gap-1 mt-2">
                                <span class="text-blue-300 text-xs">📅</span>
                                <span class="text-blue-300 text-xs font-semibold">
                                    {{ \Carbon\Carbon::parse($announcement->event_date)->format('F d, Y') }}
                                </span>
                            </div>
                            @endif
                        </div>
                        @empty
                        <div class="text-center py-10">
                            <p class="text-4xl mb-3">📭</p>
                            <p class="text-gray-300 text-sm">No announcements yet.</p>
                            <p class="text-gray-400 text-xs mt-1">Check back later for updates!</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
            @endauth

            {{-- GUEST: Show Login Prompt --}}
            @guest
            <div class="flex flex-col justify-center">
                <div class="glass-card p-8 text-center text-white">
                    <p class="text-6xl mb-4">🔐</p>
                    <h3 class="text-2xl font-bold mb-2">Members Only</h3>
                    <p class="text-gray-300 text-sm mb-6">
                        Login or register to view barangay announcements,
                        request certificates, and report concerns.
                    </p>
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('login') }}"
                           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl transition-all">
                            🔐 Login to Your Account
                        </a>
                        <a href="{{ route('register') }}"
                           class="glass-card hover:bg-white hover:bg-opacity-20 text-white font-semibold px-6 py-3 rounded-xl transition-all">
                            📝 Create an Account
                        </a>
                    </div>
                </div>
            </div>
            @endguest

        </div>
    </div>
</div>

{{-- FOOTER --}}
<footer class="text-center text-gray-400 text-sm py-4 bg-black bg-opacity-40">
    &copy; {{ date('Y') }} Barangay Information System. All rights reserved.
</footer>

</body>
</html>