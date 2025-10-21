<section>
    <header>
        <h2 class="text-lg font-semibold text-gray-900">
            {{ __('Perbarui Kata Sandi') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 leading-relaxed">
            {{ __('Pastikan akun Anda menggunakan kata sandi yang kuat dan unik untuk menjaga keamanan.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <!-- Kata Sandi Saat Ini -->
        <div>
            <x-input-label for="update_password_current_password" value="{{ __('Kata Sandi Saat Ini') }}" />
            <x-text-input
                id="update_password_current_password"
                name="current_password"
                type="password"
                class="mt-1 block w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg shadow-sm"
                autocomplete="current-password"
                placeholder="Masukkan kata sandi lama Anda"
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-red-600 text-sm" />
        </div>

        <!-- Kata Sandi Baru -->
        <div>
            <x-input-label for="update_password_password" value="{{ __('Kata Sandi Baru') }}" />
            <x-text-input
                id="update_password_password"
                name="password"
                type="password"
                class="mt-1 block w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg shadow-sm"
                autocomplete="new-password"
                placeholder="Masukkan kata sandi baru"
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-red-600 text-sm" />
        </div>

        <!-- Konfirmasi Kata Sandi -->
        <div>
            <x-input-label for="update_password_password_confirmation" value="{{ __('Konfirmasi Kata Sandi') }}" />
            <x-text-input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                class="mt-1 block w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg shadow-sm"
                autocomplete="new-password"
                placeholder="Ulangi kata sandi baru"
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-red-600 text-sm" />
        </div>

        <!-- Tombol Simpan -->
        <div class="flex items-center gap-4">
            <x-primary-button class="bg-orange-500 hover:bg-orange-600 focus:ring-orange-400 text-white font-semibold px-5 py-2 rounded-lg transition">
                {{ __('Simpan Perubahan') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="text-sm text-orange-600 font-medium"
                >
                    🔒 Kata sandi berhasil diperbarui.
                </p>
            @endif
        </div>
    </form>
</section>
