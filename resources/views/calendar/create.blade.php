<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center sm:text-left">
            {{ __('Tambah Ketersediaan Gedung') }}
        </h2>
    </x-slot>

    <div class="py-12 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white rounded-2xl shadow-lg p-8 sm:p-10 transition-transform transform hover:scale-[1.01]">

                <!-- Title -->
                <h3 class="text-xl font-semibold text-gray-800 mb-6 border-l-4 border-orange-500 pl-3">
                    Informasi Ketersediaan
                </h3>

                {{-- Error --}}
                @if ($errors->any())
                    <div
                        class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4 text-sm text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('calendar.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Hall -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Gedung</label>
                        <select name="hall_id" required
                            class="w-full border border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg p-3 shadow-sm transition">
                            @foreach ($halls as $hall)
                                <option value="{{ $hall->id }}">{{ $hall->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Start Date -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Tanggal Mulai</label>
                        <input type="date" name="date" required
                            class="w-full border border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg p-3 shadow-sm transition">
                    </div>

                    <!-- End Date -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Tanggal Selesai
                            <span class="text-sm text-gray-400">(Opsional)</span>
                        </label>
                        <input type="date" name="date_end"
                            class="w-full border border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg p-3 shadow-sm transition">
                        <p class="text-xs text-gray-500 mt-1">
                            Kosongkan jika hanya berlaku satu hari
                        </p>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Status</label>
                        <select name="status"
                            class="w-full border border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg p-3 shadow-sm transition">
                            <option value="unavailable">Tidak Tersedia (Maintenance)</option>
                            <option value="available">Tersedia</option>
                        </select>
                    </div>

                    <!-- Note -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Catatan</label>
                        <input type="text" name="note"
                            class="w-full border border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg p-3 shadow-sm transition"
                            placeholder="Contoh: Renovasi AC, Perbaikan lantai">
                    </div>

                    <!-- Buttons -->
                    <div
                        class="flex flex-col sm:flex-row justify-end items-center gap-3 pt-4">
                        <a href="{{ route('calendar.index') }}"
                            class="w-full sm:w-auto bg-gray-200 text-gray-700 hover:bg-gray-300 px-6 py-2 rounded-lg transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="w-full sm:w-auto bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-semibold shadow-md transition">
                            Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
