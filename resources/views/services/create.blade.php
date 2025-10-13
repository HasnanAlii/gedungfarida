<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center sm:text-left">
            {{ __('Tambah Layanan') }}
        </h2>
    </x-slot>

    <div class="py-12  min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-8 sm:p-10 transition-transform transform hover:scale-[1.01]">

                <!-- Title -->
                <h3 class="text-xl font-semibold text-gray-800 mb-6 border-l-4 border-orange-500 pl-3">
                    Formulir Tambah Layanan
                </h3>

                <!-- Form -->
                <form action="{{ route('services.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Nama Layanan -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Nama Layanan</label>
                        <input type="text" name="name"
                            class="w-full border border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg p-3 shadow-sm transition"
                            placeholder="Masukkan nama layanan" required>
                    </div>

                    <!-- Harga -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Harga</label>
                        <input 
                            type="text" 
                            id="price_display"
                            class="w-full border border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg p-3 shadow-sm transition"
                            placeholder="Masukkan harga layanan"
                            oninput="formatRupiahInput(this)"
                            required
                        >
                        <input type="hidden" name="price" id="price">
                    </div>

                    <script>
                        function formatRupiahInput(input) {
                            // Hapus semua karakter selain angka
                            let value = input.value.replace(/\D/g, "");
                            // Format angka ke format ribuan Indonesia
                            let formatted = new Intl.NumberFormat('id-ID').format(value);
                            // Tampilkan hasil di input teks
                            input.value = formatted;
                            // Simpan nilai asli tanpa format ke input hidden
                            document.getElementById('price').value = value;
                        }
                    </script>

                    <!-- Tombol -->
                    <div class="flex flex-col sm:flex-row justify-end items-center gap-3 pt-4">
                        <a href="{{ route('services.index') }}"
                           class="w-full sm:w-auto bg-gray-200 text-gray-700 hover:bg-gray-300 px-6 py-2 rounded-lg transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="w-full sm:w-auto bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-semibold shadow-md transition">
                            Simpan Layanan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
