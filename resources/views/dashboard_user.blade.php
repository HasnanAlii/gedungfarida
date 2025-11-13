<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 text-left sm:text-2xl">
            {{ __('Dashboard Saya') }}
        </h2>
    </x-slot>

    <div class="py-10"> {{-- Padding ditambah agar lebih lega --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div x-data="{ showAlert: true }" x-show="showAlert" x-transition.opacity
                 class="flex items-start justify-between bg-gradient-to-r from-orange-400 to-orange-500 text-white p-5 rounded-xl shadow-lg mb-8 relative">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold">👋 Selamat Datang, {{ Auth::user()->name ?? 'Pengguna' }}!</h3>
                    <p class="text-sm text-orange-100 mt-1">
                        Senang melihatmu kembali. Lihat status reservasi dan pembayaranmu di bawah ini.
                    </p>
                </div>
                {{-- PERUBAHAN: Tombol close diganti ikon --}}
                <button @click="showAlert = false" 
                        class="text-orange-100 hover:text-white transition-colors ml-4">
                    <i data-feather="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- PERUBAHAN: Desain card dengan ikon --}}
                <div class="bg-white shadow-xl rounded-2xl p-6 flex items-center gap-6 hover:shadow-2xl transition-shadow">
                    <div class="flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-2xl bg-orange-100 text-orange-600">
                        <i data-feather="book-open" class="w-8 h-8"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Reservasi Saya</h3>
                        <p class="text-3xl font-bold text-orange-600 mt-1">
                            {{ count($myReservations) }}
                        </p>
                    </div>
                </div>

                {{-- PERUBAHAN: Desain card dengan ikon --}}
                <div class="bg-white shadow-xl rounded-2xl p-6 flex items-center gap-6 hover:shadow-2xl transition-shadow">
                    <div class="flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-2xl bg-green-100 text-green-600">
                        <i data-feather="dollar-sign" class="w-8 h-8"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Total Pembayaran</h3>
                        <p class="text-3xl font-bold text-green-600 mt-1">
                            Rp {{ number_format($myPayments->sum('amount'), 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-xl rounded-2xl overflow-hidden mt-8">
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-orange-50 to-orange-100">
                    <h3 class="text-lg font-semibold text-gray-800">Reservasi Terbaru Saya</h3>
                </div>
                
                <div class="divide-y divide-gray-100">
            @forelse ($myReservations as $reservation)
                @php
                    // Tentukan style status
                    $statusInfo = match($reservation->status) {
                        'completed' => ['icon' => 'check-circle', 'color' => 'green', 'label' => 'Selesai'],
                        'pending' => ['icon' => 'clock', 'color' => 'orange', 'label' => 'Menunggu Konfirmasi'],
                        'canceled' => ['icon' => 'x-circle', 'color' => 'red', 'label' => 'Dibatalkan'],
                        'confirmed' => ['icon' => 'credit-card', 'color' => 'blue', 'label' => 'Menunggu Pembayaran'],
                        default => ['icon' => 'help-circle', 'color' => 'gray', 'label' => ucfirst($reservation->status)],
                    };

                    // Tentukan link aman (tidak error)
                    $link = match(true) {
                        // Jika sudah confirmed & payment ada → menuju edit pembayaran
                        $reservation->status === 'confirmed' && $reservation->payment !== null =>
                            route('reservations.show', $reservation->id),

                        // Jika confirmed tapi belum ada payment → arahkan ke index pembayaran
                        $reservation->status === 'confirmed' && $reservation->payment === null =>
                            route('reservations.show', $reservation->id),

                        // Selain itu → menuju halaman daftar reservasi
                        default =>route('reservations.show', $reservation->id),

                    };

                    // Tentukan teks tombol
                    $buttonText = match(true) {
                        $reservation->status === 'confirmed' && $reservation->payment !== null => 'Bayar Sekarang',
                        $reservation->status === 'confirmed' && $reservation->payment === null => 'Buat Pembayaran',
                        default => 'Lihat Detail',
                    };
                @endphp

                        {{-- CARD RESERVASI --}}
                        <a href="{{ $link }}" 
                        class="flex flex-col sm:flex-row items-center justify-between p-4 hover:bg-orange-50 transition-colors duration-150">

                            <div class="flex items-center gap-4">
                                {{-- Ikon Status --}}
                                <div class="p-3 rounded-full bg-{{ $statusInfo['color'] }}-100 text-{{ $statusInfo['color'] }}-600">
                                    <i data-feather="{{ $statusInfo['icon'] }}" class="w-6 h-6"></i>
                                </div>

                                {{-- Info Reservasi --}}
                                <div>
                                    <p class="font-semibold text-gray-800">
                                        Reservasi 
                                        {{ \Carbon\Carbon::parse($reservation->event_start)->format('d M Y') }} 
                                        – 
                                        {{ \Carbon\Carbon::parse($reservation->event_end)->format('d M Y') }}
                                    </p>
                                    <p class="text-sm text-{{ $statusInfo['color'] }}-600 font-medium">
                                        {{ $statusInfo['label'] }}
                                    </p>
                                </div>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="mt-3 sm:mt-0 flex items-center gap-1 text-sm text-orange-600 font-medium">
                                <span>{{ $buttonText }}</span>
                                <i data-feather="chevron-right" class="w-4 h-4"></i>
                            </div>
                        </a>

                    @empty

            {{-- EMPTY STATE --}}
            <div class="p-12 text-center">
                <i data-feather="calendar" class="w-12 h-12 mx-auto text-gray-400 mb-4"></i>
                <h3 class="text-xl font-medium text-gray-700">Belum Ada Reservasi</h3>
                <p class="text-gray-500 mt-2">Anda belum memiliki riwayat reservasi gedung.</p>
                <a href="{{ route('reservations.create') }}" 
                class="inline-flex items-center gap-2 mt-6 bg-orange-600 hover:bg-orange-700 text-white px-5 py-2.5 rounded-lg shadow-lg font-semibold transition">
                    <i data-feather="plus" class="w-5 h-5"></i>
                    Buat Reservasi Baru
                </a>
            </div>

        @endforelse

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
            // Panggil replace() saat Alpine memanipulasi DOM (misal: menutup alert)
            document.addEventListener('alpine:init', () => {
                Alpine.effect(() => {
                    feather.replace();
                });
            });
        </script>
    @endpush
</x-app-layout>