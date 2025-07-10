<x-guest-layout>
    <div class="w-full max-w-sm p-8 space-y-6 bg-white/70 dark:bg-gray-900/70 backdrop-blur-xl rounded-2xl shadow-2xl animate-on-load transition-all duration-500 ease-out starting-hidden">

        <div class="flex justify-center animate-on-load delay-150 transition-all duration-500 ease-out starting-hidden">
            <a href="/" class="flex items-center space-x-2">
                <svg class="w-10 h-auto text-blue-600 dark:text-yellow-400" viewBox="0 0 80 85" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M55 15 L35 50 L60 50 L40 85 L80 40 L55 40 L75 15 Z" fill="currentColor"/>
                </svg>
                <span class="text-2xl font-bold text-gray-800 dark:text-white">PLN Prediction</span>
            </a>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-8 animate-on-load delay-450 transition-all duration-500 ease-out starting-hidden">
            @csrf

            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400 peer-focus:text-blue-600 dark:peer-focus:text-yellow-400 transition-colors duration-300">
                    <i class="fa-solid fa-envelope"></i>
                </span>
                <input id="email" name="email" type="email" required value="{{ old('email') }}" autocomplete="username" placeholder=" " spellcheck="false"
                       class="peer block w-full pl-10 pr-3 py-2 bg-transparent text-gray-900 dark:text-gray-200 border-0 border-b-2 border-gray-300 dark:border-gray-600 placeholder-transparent focus:outline-none focus:ring-0 focus:border-blue-500 dark:focus:border-yellow-400 transition-colors duration-300" />
                <label for="email" class="absolute left-10 -top-3.5 text-gray-600 dark:text-gray-400 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-blue-600 dark:peer-focus:text-yellow-400 peer-focus:text-sm pointer-events-none">
                    Email
                </label>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400 peer-focus:text-blue-600 dark:peer-focus:text-yellow-400 transition-colors duration-300">
                    <i class="fa-solid fa-lock"></i>
                </span>
                <input id="password" name="password" type="password" required autocomplete="current-password" placeholder=" "
                       class="peer block w-full pl-10 pr-3 py-2 bg-transparent text-gray-900 dark:text-gray-200 border-0 border-b-2 border-gray-300 dark:border-gray-600 placeholder-transparent focus:outline-none focus:ring-0 focus:border-blue-500 dark:focus:border-yellow-400 transition-colors duration-300" />
                <label for="password" class="absolute left-10 -top-3.5 text-gray-600 dark:text-gray-400 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-blue-600 dark:peer-focus:text-yellow-400 peer-focus:text-sm pointer-events-none">
                    Password
                </label>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between text-sm">
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-yellow-500 dark:focus:ring-yellow-600">
                    <label for="remember_me" class="ml-2 block text-gray-900 dark:text-gray-300">Ingat saya</label>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-bold text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 hover:-translate-y-0.5 transform transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>

        <p class="text-center text-sm text-gray-600 dark:text-gray-400 animate-on-load delay-500 transition-all duration-500 ease-out starting-hidden">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-500 dark:text-yellow-400 dark:hover:text-yellow-300 underline transition-colors duration-300">
                Daftar di sini
            </a>
        </p>

    </div>
</x-guest-layout>