<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center sm:text-left">
            {{ __('Edit Data Gedung') }}
        </h2>
    </x-slot>

    <div class="py-12  min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-8 sm:p-10 transition-transform transform hover:scale-[1.01]">

                <!-- Title -->
                <h3 class="text-xl font-semibold text-gray-800 mb-6 border-l-4 border-orange-500 pl-3">
                    Formulir Edit Gedung
                </h3>

                <!-- Form -->
                <form action="{{ route('halls.update', $hall->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Nama Aula -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Nama Gedung</label>
                        <input type="text" name="name" value="{{ old('name', $hall->name) }}"
                            class="w-full border border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg p-3 shadow-sm transition"
                            placeholder="Masukkan nama Gedung" required>
                    </div>

                    <!-- Kapasitas -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Kapasitas</label>
                        <input type="number" name="capacity" value="{{ old('capacity', $hall->capacity) }}"
                            class="w-full border border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg p-3 shadow-sm transition"
                            placeholder="Masukkan kapasitas aula" required>
                    </div>

                  <!-- Harga -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Harga Sewa</label>
                        <input 
                            type="text" 
                            id="price_display"
                            class="w-full border border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg p-3 shadow-sm transition"
                            placeholder="Masukkan harga sewa"
                            value="{{ old('price', number_format($hall->price, 0, ',', '.')) }}"
                            oninput="formatRupiahInput(this)" 
                            required
                        >
                        <input type="hidden" name="price" id="price" value="{{ old('price', $hall->price) }}">
                    </div>

                    <script>
                        function formatRupiahInput(input) {
                            // Hapus semua karakter selain angka
                            let value = input.value.replace(/\D/g, "");
                            // Format angka ke dalam format ribuan Indonesia
                            let formatted = new Intl.NumberFormat('id-ID').format(value);
                            // Tampilkan ke input teks
                            input.value = formatted;
                            // Simpan nilai asli ke input hidden
                            document.getElementById('price').value = value;
                        }
                    </script>

                    

                    <!-- Tombol -->
                    <div class="flex flex-col sm:flex-row justify-end items-center gap-3 pt-4">
                        <a href="{{ route('halls.index') }}"
                           class="w-full sm:w-auto bg-gray-200 text-gray-700 hover:bg-gray-300 px-6 py-2 rounded-lg transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="w-full sm:w-auto bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-semibold shadow-md transition">
                            Perbarui Data
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
