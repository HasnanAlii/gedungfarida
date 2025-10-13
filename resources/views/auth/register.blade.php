<x-guest-layout>
    <div class="max-w-md mx-auto bg-white shadow-lg rounded-2xl p-6 sm:p-8 mt-10 border-t-4 border-orange-500">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Daftar Akun Baru</h2>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Nama Lengkap')" />
                <x-text-input id="name" class="block w-full mt-1 border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm"
                    type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block w-full mt-1 border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm"
    type="email" name="email"
    value="{{ old('email') }}"
    required autocomplete="username"
    oninput="this.value = this.value.toLowerCase()" />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Address -->
            <div>
                <x-input-label for="address" :value="__('Alamat')" />
                <x-text-input id="address" class="block w-full mt-1 border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm"
                    type="text" name="address" :value="old('address')" autocomplete="street-address" />
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <!-- Phone -->
            <div>
                <x-input-label for="phone" :value="__('Nomor Telepon')" />
                <x-text-input id="phone" class="block w-full mt-1 border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm"
                    type="text" name="phone" :value="old('phone')" autocomplete="tel" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Kata Sandi')" />
                <x-text-input id="password" class="block w-full mt-1 border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm"
                    type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
                <x-text-input id="password_confirmation" class="block w-full mt-1 border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm"
                    type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-between mt-6 space-y-3 sm:space-y-0 sm:space-x-4">
                <a class="underline text-sm text-gray-600 hover:text-orange-600 transition"
                    href="{{ route('login') }}">
                    {{ __('Sudah Punya Akun?') }}
                </a>

                <x-primary-button class="w-full sm:w-auto bg-orange-500 hover:bg-orange-600 focus:ring-orange-500">
                    {{ __('Daftar Sekarang') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
