<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password — Work Tracker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { background: #0f172a; }</style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-sm">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-500 rounded-2xl text-3xl mb-4 shadow-2xl shadow-orange-500/40">
                🔧
            </div>
            <h1 class="text-2xl font-bold text-white">Work Tracker</h1>
            <p class="text-slate-400 text-sm mt-1">Reset your password</p>
        </div>

        <div class="bg-slate-800/60 backdrop-blur border border-slate-700/50 rounded-3xl p-7 shadow-2xl">

            {{-- Icon --}}
            <div class="w-14 h-14 bg-orange-500/10 border border-orange-500/20 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-5">
                🔐
            </div>

            <h2 class="text-lg font-bold text-white text-center mb-1">
                Forgot Password?
            </h2>
            <p class="text-slate-400 text-xs text-center mb-5 leading-relaxed">
                Enter your email and we'll send you a link to reset your password.
            </p>

            {{-- Success message --}}
            @if(session('status'))
                <div class="bg-green-500/10 border border-green-500/30 rounded-xl p-4 mb-5">
                    <div class="flex items-center gap-2">
                        <span class="text-lg">✅</span>
                        <p class="text-green-400 text-sm">{{ session('status') }}</p>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
            @csrf

                <div class="mb-5">
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">
                        Email Address
                    </label>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="Enter your email"
                           autofocus
                           class="w-full bg-slate-900/80 border border-slate-600 rounded-xl px-4 py-3 text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition
                                  @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-xl font-semibold text-sm transition shadow-lg shadow-orange-500/30 active:scale-95">
                    Send Reset Link →
                </button>

            </form>

            <div class="mt-5 text-center">
                <a href="{{ route('login') }}"
                   class="text-slate-400 hover:text-orange-400 text-sm transition">
                    ← Back to Login
                </a>
            </div>

        </div>

    </div>

</body>
</html>