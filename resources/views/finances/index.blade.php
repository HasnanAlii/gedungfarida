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

                    <div class="mb-4 flex flex-col md:flex-row md:items-center md:flex-wrap gap-3">
                        <button @click="openModal = true" 
                                class="inline-flex items-center gap-2 px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg shadow transition">
                            <i data-feather="plus" class="w-5 h-5"></i>
                            Tambah Pengeluaran
                        </button>

                        {{-- PERUBAHAN: Warna diubah agar tidak bentrok dengan 'Hapus' --}}
                        <a href="{{ route('finances.pdf', ['filter' => request('filter'), 'date' => request('date')]) }}" 
                           class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow transition">
                            <i data-feather="printer" class="w-5 h-5"></i>
                            Cetak PDF
                        </a>

                        <form action="{{ route('finances.deleteOld') }}" method="POST" 
                              onsubmit="return confirm('Yakin ingin menghapus semua data keuangan yang lebih dari 2 bulan?')" 
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 shadow font-semibold transition">
                                <i data-feather="trash-2" class="w-5 h-5"></i>
                                Hapus Data Lama
                            </button>
                        </form>
                    </div>

                    {{-- PERUBAHAN: Dipisah dengan border-t agar lebih rapi --}}
                    <form action="{{ route('finances.index') }}" method="GET"
                          class="flex flex-col md:flex-row items-center gap-3 bg-gray-50 p-4 rounded-lg shadow-inner border-t mt-6">
                        
                        <div class="flex items-center gap-2">
                            <i data-feather="filter" class="w-5 h-5 text-gray-600"></i>
                            <label for="filter" class="font-medium text-gray-700 shrink-0">Filter:</label>
                        </div>
                        
                        <select name="filter" id="filter" x-model="filter"
                                class="w-full md:w-auto border-gray-300 rounded-lg shadow-sm text-sm focus:ring-orange-500 focus:border-orange-500">
                            <option value="all">Semua</option>
                            <option value="harian">Harian</option>
                            <option value="bulanan">Bulanan</option>
                        </select>

                        <input :type="filter === 'bulanan' ? 'month' : 'date'" 
                               name="date" 
                               value="{{ request('date') }}"
                               class="w-full md:w-auto border-gray-300 rounded-lg shadow-sm text-sm focus:ring-orange-500 focus:border-orange-500">

                        <button type="submit"
                                class="inline-flex items-center justify-center w-full md:w-auto gap-2 px-4 py-2 rounded-lg bg-orange-600 hover:bg-orange-700 text-white font-semibold shadow">
                            <i data-feather="check" class="w-5 h-5"></i>
                            Terapkan
                        </button>
                    </form>

                    <div x-show="openModal" @click.away="openModal = false"
                         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         x-cloak>
                        
                        <div @click.stop class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 relative"
                             x-transition:enter="ease-out duration-300"
                             x-transition:enter-start="opacity-0 scale-90"
                             x-transition:enter-end="opacity-100 scale-100">
                            
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Pengeluaran</h3>

                            <form action="{{ route('finances.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="type" value="expense">

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700">Jumlah (Rp)</label>
                                    <input type="number" name="amount" required 
                                           class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500">
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                    <textarea name="description" rows="2" required
                                              class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500"></textarea>
                                </div>

                                <div class="flex justify-end space-x-2 mt-4">
                                    <button type="button" @click="openModal = false"
                                            class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition">
                                        Batal
                                    </button>
                                    <button type="submit" 
                                            class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg shadow font-medium transition">
                                        Simpan
                                    </button>
                                </div>
                            </form>

                            {{-- PERUBAHAN: Tombol close diganti ikon --}}
                            <button @click="openModal = false" 
                                    class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                                <i data-feather="x" class="w-6 h-6"></i>
                            </button>
                        </div>
                    </div>

                    <table class="w-full border-collapse text-sm rounded-lg overflow-hidden mt-6">
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
                                <tr class="hover:bg-orange-50 transition">
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
                                    <td class="px-4 py-3 border text-left">{{ $finance->description }}</td>
                                    <td class="px-4 py-3 border text-center">{{ $finance->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center p-6 text-gray-500 italic">Tidak ada catatan keuangan ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @php
                        $totalIncome = $finances->where('type', 'income')->sum('amount');
                        $totalExpense = $finances->where('type', 'expense')->sum('amount');
                    @endphp

                    {{-- PERUBAHAN: Menambahkan ikon pada card ringkasan --}}
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="p-5 bg-green-100 rounded-xl shadow flex items-center gap-4">
                            <div class="p-3 bg-green-200 rounded-full">
                                <i data-feather="arrow-down-left" class="w-6 h-6 text-green-700"></i>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-700">Total Pemasukan</div>
                                <div class="text-2xl font-bold text-green-800">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        <div class="p-5 bg-red-100 rounded-xl shadow flex items-center gap-4">
                            <div class="p-3 bg-red-200 rounded-full">
                                <i data-feather="arrow-up-right" class="w-6 h-6 text-red-700"></i>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-700">Total Pengeluaran</div>
                                <div class="text-2xl font-bold text-red-800">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        <div class="p-5 bg-orange-100 rounded-xl shadow flex items-center gap-4">
                            <div class="p-3 bg-orange-200 rounded-full">
                                <i data-feather="dollar-sign" class="w-6 h-6 text-orange-700"></i>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-700">Total Dana</div>
                                <div class="text-2xl font-bold text-orange-800">Rp {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        {{ $finances->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Script untuk menjalankan Feather Icons --}}
    @push('scripts')
        <script>
            // Panggil replace() saat DOM dimuat
            document.addEventListener('DOMContentLoaded', () => {
                feather.replace();
            });
            // Panggil replace() saat Alpine memanipulasi DOM (misal: membuka modal)
            document.addEventListener('alpine:init', () => {
                Alpine.effect(() => {
                    Alpine.nextTick(() => feather.replace());
                });
            });
        </script>
    @endpush
</x-app-layout>