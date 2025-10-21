<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">
                {{ __('Dashboard Admin') }}
            </h2>

            <!-- Tombol Hapus Data Lama -->
            <form action="{{ route('admin.cleanup.olddata') }}" method="POST"
                onsubmit="return confirm('Apakah kamu yakin ingin menghapus data yang lebih dari 2 bulan?')"
                class="flex justify-end">
                @csrf
                <button type="submit"
                    class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-1.5 sm:px-5 sm:py-2 rounded-lg text-sm font-medium shadow transition-all active:scale-95">
                    <i data-feather="trash-2" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">Hapus Data Lama</span>
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
       

            <!-- Card Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Reservasi -->
                <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-blue-500 flex items-center justify-between hover:shadow-lg transition">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Total Reservasi</h3>
                        <p class="text-3xl font-bold text-blue-600 mt-2">
                            {{ $totalReservations ?? 0 }}
                        </p>
                    </div>
                    <div class="text-blue-500 text-4xl">📅</div>
                </div>

                <!-- Pembayaran -->
                <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-green-500 flex items-center justify-between hover:shadow-lg transition">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Pembayaran Terkonfirmasi</h3>
                        <p class="text-3xl font-bold text-green-600 mt-2">
                            {{ $confirmedPayments ?? 0 }}
                        </p>
                    </div>
                    <div class="text-green-500 text-4xl">💳</div>
                </div>

                <!-- Pemasukan -->
                <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-yellow-500 flex items-center justify-between hover:shadow-lg transition">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Total Pemasukan</h3>
                        <p class="text-3xl font-bold text-yellow-600 mt-2">
                            Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="text-yellow-500 text-4xl">💰</div>
                </div>
            </div>

            <!-- Tabel Reservasi Terbaru -->
            <div class="bg-white shadow-md rounded-xl overflow-hidden mt-10">
                 <div class="px-6 py-4 border-b bg-gradient-to-r from-orange-100 to-orange-200">
                    <h3 class="text-lg font-semibold text-gray-800">Reservasi Terbaru</h3>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-orange-50 text-gray-700">
                                <th class="p-3 text-left border font-semibold">No</th>
                                <th class="p-3 text-left border font-semibold">Nama Customer</th>
                                <th class="p-3 text-center border font-semibold">Tanggal Acara</th>
                                <th class="p-3 text-center border font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($recentReservations ?? [] as $reservation)
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="p-3 border text-gray-700">{{ $loop->iteration }}</td>
                                    <td class="p-3 border text-gray-700">{{ $reservation->renter_name }}</td>
                                    <td class="p-3 border text-center text-gray-600">
                                        {{ \Carbon\Carbon::parse($reservation->event_start)->format('d M Y') }}
                                    </td>
                                    <td class="p-3 border text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold shadow-sm
                                            @if($reservation->status == 'completed') bg-green-100 text-green-700
                                            @elseif($reservation->status == 'pending') bg-orange-100 text-orange-700
                                            @elseif($reservation->status == 'canceled') bg-red-100 text-red-700
                                            @elseif($reservation->status == 'confirmed') bg-blue-100 text-blue-700
                                            @else bg-gray-100 text-gray-700 @endif">
                                            @if($reservation->status == 'completed')
                                                ✅ Selesai
                                            @elseif($reservation->status == 'pending')
                                                ⏳ Menunggu Konfirmasi
                                            @elseif($reservation->status == 'canceled')
                                                ❌ Dibatalkan
                                            @elseif($reservation->status == 'confirmed')
                                                💳 Menunggu Pembayaran
                                            @else
                                                {{ ucfirst($reservation->status) }}
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center p-6 text-gray-500 italic">
                                        Belum ada data reservasi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
