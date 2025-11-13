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
       
            <!-- Card Statistik (Desain Baru) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Total Reservasi -->
                <div class="bg-white shadow-xl rounded-2xl p-6 flex items-center gap-6 hover:shadow-2xl transition-shadow">
                    <div class="flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-2xl bg-orange-100 text-orange-600">
                        <i data-feather="book-open" class="w-8 h-8"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Total Reservasi</h3>
                        <p class="text-3xl font-bold text-orange-600 mt-1">
                            {{ $totalReservations ?? 0 }}
                        </p>
                    </div>
                </div>

                <!-- Pembayaran Terkonfirmasi -->
                <div class="bg-white shadow-xl rounded-2xl p-6 flex items-center gap-6 hover:shadow-2xl transition-shadow">
                    <div class="flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-2xl bg-green-100 text-green-600">
                        <i data-feather="check-circle" class="w-8 h-8"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Pembayaran Terkonfirmasi</h3>
                        <p class="text-3xl font-bold text-green-600 mt-1">
                            {{ $confirmedPayments ?? 0 }}
                        </p>
                    </div>
                </div>

                <!-- Total Pemasukan -->
                <div class="bg-white shadow-xl rounded-2xl p-6 flex items-center gap-6 hover:shadow-2xl transition-shadow">
                    <div class="flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-2xl bg-blue-100 text-blue-600">
                        <i data-feather="dollar-sign" class="w-8 h-8"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Total Pemasukan</h3>
                        <p class="text-3xl font-bold text-blue-600 mt-1">
                            Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- PERUBAHAN: Tabel diganti menjadi Daftar Reservasi -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden mt-8">
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-orange-50 to-orange-100">
                    <h3 class="text-lg font-semibold text-gray-800">Reservasi Terbaru</h3>
                </div>
                
                <div class="divide-y divide-gray-100">
                    @forelse ($recentReservations ?? [] as $reservation)
                        @php
                            // Tentukan style berdasarkan status
                            $statusInfo = match($reservation->status) {
                                'completed' => ['icon' => 'check-circle', 'color' => 'green', 'label' => 'Selesai'],
                                'pending' => ['icon' => 'clock', 'color' => 'orange', 'label' => 'Menunggu Konfirmasi'],
                                'canceled' => ['icon' => 'x-circle', 'color' => 'red', 'label' => 'Dibatalkan'],
                                'confirmed' => ['icon' => 'credit-card', 'color' => 'blue', 'label' => 'Menunggu Pembayaran'],
                                default => ['icon' => 'help-circle', 'color' => 'gray', 'label' => ucfirst($reservation->status)],
                            };
                            
                            // Tentukan link tujuan
                            // Admin harusnya ke 'reservations.edit' atau 'reservations.show'
                            $link = route('reservations.show',$reservation->id); 
                        @endphp
                        
                        <a href="{{ $link }}" class="flex flex-col sm:flex-row items-center justify-between p-4 hover:bg-orange-50 transition-colors duration-150">
                            <div class="flex items-center gap-4">
                                {{-- Ikon Status --}}
                                <div class="p-3 rounded-full bg-{{ $statusInfo['color'] }}-100 text-{{ $statusInfo['color'] }}-600">
                                    <i data-feather="{{ $statusInfo['icon'] }}" class="w-6 h-6"></i>
                                </div>
                                {{-- Info --}}
                                <div>
                                    <p class="font-semibold text-gray-800">
                                        {{ $reservation->renter_name }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Acara: {{ \Carbon\Carbon::parse($reservation->event_start)->format('d M Y') }}- {{ \Carbon\Carbon::parse($reservation->event_end)->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                            {{-- Tombol Aksi --}}
                            <div class="mt-3 sm:mt-0 flex items-center gap-1 text-sm text-orange-600 font-medium">
                                <span>Lihat Detail</span>
                                <i data-feather="chevron-right" class="w-4 h-4"></i>
                            </div>
                        </a>
                    @empty
                        {{-- Empty state yang lebih baik --}}
                        <div class="p-12 text-center">
                            <i data-feather="calendar" class="w-12 h-12 mx-auto text-gray-400 mb-4"></i>
                            <h3 class="text-xl font-medium text-gray-700">Belum Ada Reservasi</h3>
                            <p class="text-gray-500 mt-2">Saat ini belum ada data reservasi yang masuk.</p>
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
            document.addEventListener('DOMContentLoaded', () => {
                feather.replace();
            });
        </script>
    @endpush
</x-app-layout>