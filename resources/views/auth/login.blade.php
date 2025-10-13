<x-guest-layout>
    <div class="max-w-md mx-auto bg-white rounded-2xl shadow-lg p-8 sm:p-10 mt-16 border-t-4 border-orange-500">
        <!-- Judul -->
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">
            Masuk ke Akun Anda
        </h2>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                <input id="email" type="email" name="email"
                    value="{{ old('email') }}"
                    required autofocus autocomplete="username"
                    class="w-full border border-gray-300 rounded-lg p-3 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-gray-700 font-medium mb-2">Kata Sandi</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full border border-gray-300 rounded-lg p-3 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition">
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
            </div>

            <!-- Remember Me + Forgot Password -->
            <div class="flex items-center justify-between mt-2">
                <label for="remember_me" class="inline-flex items-center text-gray-700">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-orange-600 shadow-sm focus:ring-orange-500"
                        name="remember">
                    <span class="ms-2 text-sm">Ingat Saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="text-sm text-orange-600 hover:text-orange-700 font-medium transition">
                        Lupa Kata Sandi?
                    </a>
                @endif
            </div>

            <!-- Tombol -->
            <div class="flex flex-col sm:flex-row items-center justify-between mt-6 space-y-3 sm:space-y-0 sm:space-x-4">
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="underline text-sm text-gray-600 hover:text-orange-600 transition">
                        Belum Punya Akun? Daftar
                    </a>
                @endif

                <button type="submit"
                    class="w-full sm:w-auto bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-semibold shadow-md transition">
                    Masuk
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
