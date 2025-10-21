<section>
    <header>
        <h2 class="text-lg font-semibold text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 leading-relaxed">
            {{ __('Perbarui informasi akun Anda dan alamat email yang terdaftar.') }}
        </p>
    </header>

    <!-- Form Kirim Verifikasi Email -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Form Update Profil -->
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Nama -->
        <div>
            <x-input-label for="name" value="{{ __('Nama Lengkap') }}" />
            <x-text-input
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg shadow-sm"
                value="{{ old('name', $user->name) }}"
                required
                autofocus
                autocomplete="name"
                placeholder="Masukkan nama lengkap Anda"
            />
            <x-input-error class="mt-2 text-red-600 text-sm" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" value="{{ __('Alamat Email') }}" />
            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg shadow-sm"
                value="{{ old('email', $user->email) }}"
                required
                autocomplete="username"
                placeholder="Masukkan alamat email Anda"
            />
            <x-input-error class="mt-2 text-red-600 text-sm" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-3 bg-orange-50 border border-orange-200 rounded-lg text-sm">
                    <p class="text-gray-800">
                        📧 Alamat email Anda belum diverifikasi.
                        <button
                            form="send-verification"
                            class="ml-1 underline text-orange-600 hover:text-orange-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
                        >
                            Klik di sini untuk mengirim ulang tautan verifikasi.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            ✅ Tautan verifikasi baru telah dikirim ke email Anda.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Tombol Simpan -->
        <div class="flex items-center gap-4">
            <x-primary-button class="bg-orange-500 hover:bg-orange-600 focus:ring-orange-400 text-white font-semibold px-5 py-2 rounded-lg transition">
                {{ __('Simpan Perubahan') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="text-sm text-orange-600 font-medium"
                >
                    ✨ Profil berhasil diperbarui.
                </p>
            @endif
        </div>
    </form>
</section>
