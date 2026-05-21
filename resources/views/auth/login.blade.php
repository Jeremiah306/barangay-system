<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Barangay Information System</title>
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

    /* Fix autofill background color */
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:active {
        -webkit-box-shadow: 0 0 0 30px rgba(0, 0, 0, 0) inset !important;
        box-shadow: 0 0 0 30px rgba(0, 0, 0, 0) inset !important;
        -webkit-text-fill-color: white !important;
        background-color: transparent !important;
        transition: background-color 5000s ease-in-out 0s;
    }

    input {
        background-color: transparent !important;
        color: white !important;
    }

    input::placeholder {
        color: rgba(255, 255, 255, 0.5) !important;
    }
</style>
</head>
<body>
<div class="overlay flex items-center justify-end pr-0 md:pr-24">
    <div class="glass-card w-full max-w-md mx-6 md:mx-0 p-10 text-white">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-1">Welcome back</h1>
            <p class="text-gray-300 text-sm">Please enter your details.</p>
        </div>

        {{-- Session Error --}}
        @if(session('status'))
            <div class="bg-green-500 bg-opacity-20 border border-green-400 text-green-200 px-4 py-2 rounded mb-4 text-sm">
                {{ session('status') }}
            </div>
        @endif

        {{-- Login Form --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2 text-gray-200">E-mail</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter your e-mail"
                    required autofocus
                    class="w-full bg-transparent border-b border-gray-400 focus:border-white outline-none py-2 text-white placeholder-gray-400 text-sm transition-colors duration-200"
                >
                @error('email')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2 text-gray-200">Password</label>
                <input
                    type="password"
                    name="password"
                    placeholder="••••••••"
                    required
                    class="w-full bg-transparent border-b border-gray-400 focus:border-white outline-none py-2 text-white placeholder-gray-400 text-sm transition-colors duration-200"
                >
                @error('password')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember Me & Forgot Password --}}
            <div class="flex items-center justify-between mb-8">
                <label class="flex items-center gap-2 text-sm text-gray-300 cursor-pointer">
                    <input type="checkbox" name="remember"
                        class="w-4 h-4 rounded border-gray-400 bg-transparent">
                    Remember me
                </label>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-sm text-gray-300 hover:text-white transition-colors">
                        Forgot your password?
                    </a>
                @endif
            </div>

            {{-- Login Button --}}
            <button type="submit"
                class="w-full bg-white text-gray-900 font-bold py-3 rounded-lg hover:bg-gray-100 transition-colors duration-200 text-sm tracking-wide">
                Log in
            </button>

            {{-- Register Link --}}
            <p class="text-center text-sm text-gray-400 mt-6">
                Don't have an account?
                <a href="{{ route('register') }}"
                   class="text-white font-semibold hover:underline">
                    Register here
                </a>
            </p>
        </form>

    </div>
</div>
</body>
</html>