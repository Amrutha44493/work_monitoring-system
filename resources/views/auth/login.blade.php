<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Favicon: orange square with letter L --}}
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='22' fill='%23f97316'/><text x='50' y='72' font-size='64' font-weight='bold' text-anchor='middle' fill='white' font-family='Arial'>L</text></svg>">

    <title>Login | LIRA Kitchen Interiors</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-100 flex items-center justify-center p-5">

<div class="absolute top-0 left-0 w-72 h-72 bg-orange-300 rounded-full blur-3xl opacity-30"></div>
<div class="absolute bottom-0 right-0 w-80 h-80 bg-orange-200 rounded-full blur-3xl opacity-40"></div>


<div class="relative w-full max-w-md">

 {{-- Logo --}}
        <div class="text-center mb-6">
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-[0.25em] pl-[0.25em]">
                LIRA
            </h1>
            <div class="flex items-center justify-center gap-3 mt-1.5">
                <span class="h-px w-8 bg-orange-400"></span>
                <p class="text-xs font-semibold tracking-[0.3em] text-orange-600 uppercase">
                    Kitchen Interiors
                </p>
                <span class="h-px w-8 bg-orange-400"></span>
            </div>
        </div>



    {{-- Login Card --}}
    <div class="bg-white rounded-3xl shadow-xl border border-gray-200 p-8">
        @if(session('status'))

            <div class="mb-5 px-4 py-3 rounded-xl
                        bg-green-50 border border-green-200
                        text-green-700 text-sm">

                {{ session('status') }}

            </div>

        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            {{-- Email --}}
            <div class="mb-5">

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Email 
                </label>


                <div class="relative">

                    <span class="absolute left-4 top-3.5 text-gray-400">
                        📧
                    </span>
                    <input 
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="admin@kitchen.com"
                        autofocus
                        class="w-full pl-11 pr-4 py-3 rounded-xl
                               border border-gray-300
                               focus:ring-2 focus:ring-orange-400
                               focus:border-orange-400
                               outline-none transition
                               @error('email') border-red-400 bg-red-50 @enderror">


                </div>

                @error('email')

                    <p class="text-xs text-red-500 mt-2">
                        ⚠️ {{ $message }}
                    </p>

                @enderror

            </div>

            {{-- Password --}}
            <div class="mb-5">


                <div class="flex justify-between items-center mb-2">

                    <label class="text-sm font-medium text-gray-700">
                        Password
                    </label>
                </div>



                <div class="relative">
                    <span class="absolute left-4 top-3.5 text-gray-400">
                        🔒
                    </span>
                    <input 
                        id="password"
                        type="password"
                        name="password"
                        placeholder="••••••••"
                        class="w-full pl-11 pr-12 py-3 rounded-xl
                               border border-gray-300
                               focus:ring-2 focus:ring-orange-400
                               focus:border-orange-400
                               outline-none transition
                               @error('password') border-red-400 bg-red-50 @enderror">

                    <button type="button"
                            onclick="togglePassword()"
                            class="absolute right-4 top-3.5 text-gray-400">

                        👁️
                    </button>

                </div>

                @error('password')

                    <p class="text-xs text-red-500 mt-2">
                        ⚠️ {{ $message }}
                    </p>

                @enderror


            </div>
            {{-- Remember Me --}}
<div class="flex items-center justify-between mb-6">

    <label class="flex items-center gap-2 cursor-pointer">

        <input type="checkbox"
               name="remember"
               class="w-4 h-4 rounded border-gray-300
                      text-orange-500 focus:ring-orange-400">

        <span class="text-sm text-gray-600">
            Remember me
        </span>

    </label>

</div>

<button type="submit"
        class="w-full py-3 rounded-xl
               bg-gradient-to-r from-orange-500 to-orange-600
               text-white font-semibold
               shadow-lg shadow-orange-200
               hover:from-orange-600 hover:to-orange-700
               active:scale-95 transition">

    Sign In 
</button>


</form>

</div>


{{-- Footer --}}
<p class="text-center text-xs text-gray-400 mt-6">

    Kitchen Work Monitoring System © 2026

</p>
</div>



<script>

function togglePassword()
{
    const password = document.getElementById('password');

    if(password.type === "password")
    {
        password.type = "text";
    }
    else
    {
        password.type = "password";
    }
}

</script>


</body>
</html>