<section class="space-y-6">
    <header>
        <h2 class="text-lg font-semibold text-gray-900">
            {{ __('Hapus Akun') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 leading-relaxed">
            {{ __('Setelah akun Anda dihapus, semua data dan sumber daya yang terkait akan dihapus secara permanen. Pastikan Anda sudah mencadangkan data penting sebelum melanjutkan.') }}
        </p>
    </header>

    <!-- Tombol Hapus Akun -->
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'konfirmasi-hapus-akun')"
        class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg text-sm shadow transition active:scale-95"
    >
        <i data-feather="user-x" class="w-4 h-4"></i>
        {{ __('Hapus Akun') }}
    </x-danger-button>

    <!-- Modal Konfirmasi -->
    <x-modal name="konfirmasi-hapus-akun" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-semibold text-gray-900 mb-2">
                {{ __('Apakah Anda yakin ingin menghapus akun ini?') }}
            </h2>

            <p class="text-sm text-gray-600 leading-relaxed">
                {{ __('Setelah akun dihapus, semua data Anda akan hilang secara permanen. Harap masukkan kata sandi Anda untuk mengonfirmasi penghapusan.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Kata Sandi') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm"
                    placeholder="{{ __('Masukkan kata sandi Anda') }}"
                    required
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-sm text-red-600" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="text-gray-700 hover:bg-gray-100">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="bg-red-600 hover:bg-red-700">
                    {{ __('Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>

<!-- Aktifkan Feather Icon -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (window.feather) feather.replace();
    });
</script>
