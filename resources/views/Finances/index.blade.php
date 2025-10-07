<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Catatan Keuangan') }}
        </h2>
    </x-slot>

    <div class="py-10" x-data="{ openModal: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                <div class="p-6 text-gray-900 overflow-x-auto">

                    <!-- Tombol Tambah -->
                    <div class="mb-4">
                        <button @click="openModal = true" 
                              class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded shadow">
                            ➕ Tambah Pengeluaran
                        </button>
                             <a href="{{ route('finances.pdf') }}" 
                             class="px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded shadow">
                                🖨️ Cetak PDF
                            </a>     <a href="{{ route('finances.pdf') }}" 
                  
                        🖨️ Cetak PDF
                    </a>




                    </div>
               
                    <!-- Modal -->
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

                            <!-- Tombol close (pojok kanan atas) -->
                            <button @click="openModal = false" 
                                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                                ✖
                            </button>
                        </div>
                    </div>

                    <!-- Tabel Keuangan -->
                    <table class="w-full border-collapse text-sm rounded-lg overflow-hidden">
                        <thead>
                            <tr class="bg-gradient-to-r from-orange-200 to-orange-300 text-gray-800">
                                <th class="px-4 py-3 border text-center font-semibold">No</th>
                                {{-- <th class="px-4 py-3 border text-center font-semibold">Penyewa</th> --}}
                                <th class="px-4 py-3 border text-center font-semibold">Jumlah</th>
                                <th class="px-4 py-3 border text-center font-semibold">Tipe</th>
                                <th class="px-4 py-3 border text-center font-semibold">Deskripsi</th>
                                <th class="px-4 py-3 border text-center font-semibold">Tanggal</th>
                            
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($finances as $finance)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 border text-center">{{ $loop->iteration}}</td>
                                    {{-- <td class="px-4 py-3 border text-center">{{ $finance->reservation->renter_name ?? '-' }}</td> --}}
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
                                    <td colspan="7" class="text-center p-6 text-gray-500 italic">Tidak ada catatan keuangan ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- Ringkasan Keuangan -->
                    @php
                        $totalAmount = $finances->sum('amount');
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
