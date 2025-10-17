<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Catatan Keuangan') }}
        </h2>
    </x-slot>

    <div class="py-10" x-data="{ openModal: false, filter: '{{ request('filter', 'all') }}' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                <div class="p-6 text-gray-900 overflow-x-auto">

            <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                   <div class="flex flex-wrap gap-2">
                    <!-- Tombol Tambah -->
                    <button @click="openModal = true" 
                        class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded shadow">
                        ➕ Tambah Pengeluaran
                    </button>

                    <!-- Cetak PDF -->
                    <a href="{{ route('finances.pdf', ['filter' => request('filter'), 'date' => request('date')]) }}" 
                        class="px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded shadow">
                        🖨️ Cetak PDF
                    </a>

                    <!-- Hapus Data Lama -->
                    <form action="{{ route('finances.deleteOld') }}" method="POST" 
                        onsubmit="return confirm('Yakin ingin menghapus semua data keuangan yang lebih dari 2 bulan?')" 
                        class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                            class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 shadow">
                            <!-- Icon Trash -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4"/>
                            </svg>
                            Hapus Data Keuangan Lama
                        </button>
                    </form>
                </div>


                        <!-- Filter -->
                        <form action="{{ route('finances.index') }}" method="GET"
                              class="flex items-center gap-2 bg-gray-50 px-4 py-2 rounded-lg shadow">

                            <!-- Icon Filter -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L14 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 018 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                            </svg>

                            <label for="filter" class="font-medium text-gray-700">Filter:</label>
                            <select name="filter" id="filter" x-model="filter"
                                    class="border rounded-md pr-6 py-1 text-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="all">Semua</option>
                                <option value="harian">Harian</option>
                                <option value="bulanan">Bulanan</option>
                            </select>

                            <input :type="filter === 'bulanan' ? 'month' : 'date'" 
                                name="date" 
                                value="{{ request('date') }}"
                                class="border rounded-md px-2 py-1 text-sm focus:ring-blue-500 focus:border-blue-500">

                            <button type="submit"
                                    class="flex items-center gap-2 px-4 py-1 rounded bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow">
                                <!-- Icon Apply -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Terapkan
                            </button>
                        </form>
                    </div>

                    <!-- Modal Tambah -->
                    <div x-show="openModal" 
                         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                         x-transition>
                        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 relative">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Pengeluaran</h3>

                            <form action="{{ route('finances.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="type" value="expense">

                                <!-- Jumlah -->
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700">Jumlah (Rp)</label>
                                    <input type="number" name="amount" required 
                                           class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500">
                                </div>

                                <!-- Deskripsi -->
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                    <textarea name="description" rows="2" required
                                              class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500"></textarea>
                                </div>

                                <!-- Tombol -->
                                <div class="flex justify-end space-x-2 mt-4">
                                    <button type="button" @click="openModal = false"
                                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded">
                                        Batal
                                    </button>
                                    <button type="submit" 
                                            class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded shadow">
                                        Simpan
                                    </button>
                                </div>
                            </form>

                            <button @click="openModal = false" 
                                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                                ✖
                            </button>
                        </div>
                    </div>

                    <!-- Tabel Keuangan -->
                    <table class="w-full border-collapse text-sm rounded-lg overflow-hidden mt-3">
                        <thead>
                            <tr class="bg-gradient-to-r from-orange-200 to-orange-300 text-gray-800">
                                <th class="px-4 py-3 border text-center font-semibold">No</th>
                                <th class="px-4 py-3 border text-center font-semibold">Jumlah</th>
                                <th class="px-4 py-3 border text-center font-semibold">Tipe</th>
                                <th class="px-4 py-3 border text-center font-semibold">Deskripsi</th>
                                <th class="px-4 py-3 border text-center font-semibold">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($finances as $finance)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 border text-center">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3 border text-center font-semibold">
                                        Rp {{ number_format($finance->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 border text-center">
                                        @if($finance->type == 'income')
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 shadow-sm">Pemasukan</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 shadow-sm">Pengeluaran</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 border text-center">{{ $finance->description }}</td>
                                    <td class="px-4 py-3 border text-center">{{ $finance->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center p-6 text-gray-500 italic">Tidak ada catatan keuangan ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Ringkasan Keuangan -->
                    @php
                        $totalIncome = $finances->where('type', 'income')->sum('amount');
                        $totalExpense = $finances->where('type', 'expense')->sum('amount');
                    @endphp

                    <div class="mb-4 grid grid-cols-1 md:grid-cols-3 mt-5 gap-4">
                        <div class="p-4 bg-green-100 rounded-lg text-center shadow">
                            <div class="text-sm font-semibold text-gray-700">Total Pemasukan</div>
                            <div class="text-xl font-bold text-green-800">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
                        </div>
                        <div class="p-4 bg-red-100 rounded-lg text-center shadow">
                            <div class="text-sm font-semibold text-gray-700">Total Pengeluaran</div>
                            <div class="text-xl font-bold text-red-800">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
                        </div>
                        <div class="p-4 bg-orange-100 rounded-lg text-center shadow">
                            <div class="text-sm font-semibold text-gray-700">Total Dana</div>
                            <div class="text-xl font-bold text-orange-800">Rp {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <div class="mt-4">
                        {{ $finances->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
