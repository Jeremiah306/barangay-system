<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Barangay Information System</title>
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
            background: rgba(0, 0, 0, 0.55);
            min-height: 100vh;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
        }
    </style>
</head>
<body>
<div class="overlay flex items-center justify-end pr-0 md:pr-24">
    <div class="glass-card w-full max-w-md mx-6 md:mx-0 p-10 text-white my-10">

        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-1">Create Account</h1>
            <p class="text-gray-300 text-sm">Register to access the Barangay System.</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Name --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2 text-gray-200">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    placeholder="Enter your full name" required
                    class="w-full bg-transparent border-b border-gray-400 focus:border-white outline-none py-2 text-white placeholder-gray-400 text-sm">
                @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Email --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2 text-gray-200">E-mail</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    placeholder="Enter your e-mail" required
                    class="w-full bg-transparent border-b border-gray-400 focus:border-white outline-none py-2 text-white placeholder-gray-400 text-sm">
                @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Password --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2 text-gray-200">Password</label>
                <input type="password" name="password"
                    placeholder="••••••••" required
                    class="w-full bg-transparent border-b border-gray-400 focus:border-white outline-none py-2 text-white placeholder-gray-400 text-sm">
                @error('password') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="mb-8">
                <label class="block text-sm font-semibold mb-2 text-gray-200">Confirm Password</label>
                <input type="password" name="password_confirmation"
                    placeholder="••••••••" required
                    class="w-full bg-transparent border-b border-gray-400 focus:border-white outline-none py-2 text-white placeholder-gray-400 text-sm">
            </div>

            {{-- Register Button --}}
            <button type="submit"
                class="w-full bg-white text-gray-900 font-bold py-3 rounded-lg hover:bg-gray-100 transition-colors duration-200 text-sm tracking-wide">
                Create Account
            </button>

            <p class="text-center text-sm text-gray-400 mt-6">
                Already have an account?
                <a href="{{ route('login') }}" class="text-white font-semibold hover:underline">
                    Log in here
                </a>
            </p>
        </form>
    </div>
</div>
</body>
</html>