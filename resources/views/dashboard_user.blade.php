<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 text-left sm:text-2xl">
            {{ __('Dashboard Saya') }}
        </h2>
    </x-slot>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Alert Selamat Datang -->
            <div id="welcome-alert" 
                 class="flex items-start justify-between bg-gradient-to-r from-orange-400 to-orange-500 text-white p-4 rounded-xl shadow-md mb-6 relative">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold">👋 Selamat Datang, {{ Auth::user()->name ?? 'Pengguna' }}!</h3>
                    <p class="text-sm text-orange-100 mt-1">
                        Senang melihatmu kembali. Lihat status reservasi dan pembayaranmu di bawah ini.
                    </p>
                </div>
                <button onclick="document.getElementById('welcome-alert').classList.add('hidden')" 
                        class="text-white hover:text-orange-200 ml-4 text-2xl leading-none">
                    &times;
                </button>
            </div>

            <!-- Card Info User -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Card Reservasi -->
                <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-orange-500 flex items-center justify-between hover:shadow-lg transition">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Reservasi Saya</h3>
                        <p class="text-3xl font-bold text-orange-600 mt-2">
                            {{ count($myReservations) }}
                        </p>
                    </div>
                    <div class="text-orange-500 text-4xl">📅</div>
                </div>

                <!-- Card Pembayaran -->
                <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-green-500 flex items-center justify-between hover:shadow-lg transition">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Total Pembayaran</h3>
                        <p class="text-3xl font-bold text-green-600 mt-2">
                            Rp {{ number_format($myPayments->sum('amount'), 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="text-green-500 text-4xl">💰</div>
                </div>
            </div>

            <!-- Tabel Reservasi User -->
            <div class="bg-white shadow-md rounded-xl overflow-hidden mt-8">
                <div class="px-6 py-4 border-b bg-gradient-to-r from-orange-100 to-orange-200">
                    <h3 class="text-lg font-semibold text-gray-800">Reservasi Terbaru Saya</h3>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-orange-50 text-gray-700">
                                <th class="p-3 text-left border font-semibold">No</th>
                                <th class="p-3 text-center border font-semibold">Tanggal Acara</th>
                                <th class="p-3 text-center border font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($myReservations as $reservation)
                                <tr class="hover:bg-orange-50 transition">
                                    <td class="p-3 border text-gray-700">{{ $loop->iteration }}</td>
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
                                    <td colspan="3" class="text-center p-6 text-gray-500 italic">
                                        Belum ada reservasi.
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
