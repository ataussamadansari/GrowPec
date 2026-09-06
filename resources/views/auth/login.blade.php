<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - GrowPec</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gradient-to-br from-purple-900 via-purple-800 to-purple-900 min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden">
    <!-- Header -->
    <div class="bg-purple-50 border-b border-purple-200 px-6 py-8 text-center">
        <a href="{{ route('home') }}" class="inline-block">
            <h2 class="text-2xl font-extrabold text-purple-900">
                Grow<span class="text-yellow-500">Pec</span>
            </h2>
        </a>
        <p class="text-gray-600 text-sm mt-1">Admin Management Portal</p>
    </div>

    <div class="px-6 py-6">
        <!-- Flash Alerts -->
        @if(session('error'))
        <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded">
            <i class="bi bi-exclamation-triangle-fill mr-2"></i> {{ session('error') }}
        </div>
        @endif

        @if(session('success'))
        <div class="mb-4 p-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm rounded">
            <i class="bi bi-check-circle-fill mr-2"></i> {{ session('success') }}
        </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Email -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">Email Address</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent transition @error('email') border-red-500 @enderror"
                           placeholder="admin@growpec.com"
                           required
                           autofocus>
                </div>
                @error('email')
                    <small class="text-red-600 text-xs mt-1 block">{{ $message }}</small>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">Password</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password"
                           name="password"
                           id="passwordInput"
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent transition @error('password') border-red-500 @enderror"
                           placeholder="••••••••"
                           required>
                </div>
                @error('password')
                    <small class="text-red-600 text-xs mt-1 block">{{ $message }}</small>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" id="rememberMe" {{ old('remember') ? 'checked' : '' }} class="w-4 h-4 text-purple-600 rounded focus:ring-2 focus:ring-purple-500">
                    <span class="text-sm text-gray-600">Keep me signed in</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-2.5 px-4 rounded-xl transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2 mt-6">
                <i class="bi bi-box-arrow-in-right"></i> Sign In to Dashboard
            </button>
        </form>
    </div>

    <!-- Card Footer -->
    <div class="text-center py-4 bg-gray-50 border-t border-gray-200">
        <a href="{{ route('home') }}" class="text-gray-900 font-semibold text-sm hover:text-purple-900 transition flex items-center justify-center gap-1">
            <i class="bi bi-arrow-left"></i> Back to GrowPec Website
        </a>
    </div>
</div>

</body>
</html>