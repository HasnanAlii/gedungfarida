<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">
                {{ __('Detail Reservasi') }}
            </h2>

            <a href="{{ route('reservations.index') }}" 
               class="inline-flex items-center gap-2 bg-white hover:bg-gray-100 text-gray-700 border border-gray-300
                      px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition">
                <i data-feather="arrow-left" class="w-4 h-4"></i>
                Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                @php
                    // Logika Status Badge
                    $statusMap = [
                        'confirmed' => ['label' => 'Menunggu Bayar', 'icon' => 'credit-card', 'color' => 'blue'],
                        'completed' => ['label' => 'Sukses', 'icon' => 'check-circle', 'color' => 'green'],
                        'pending'   => ['label' => 'Menunggu Konfirmasi', 'icon' => 'clock', 'color' => 'orange'],
                        'canceled'  => ['label' => 'Dibatalkan', 'icon' => 'x-circle', 'color' => 'red'],
                    ];
                    $status = $statusMap[$reservation->status] ?? ['label' => ucfirst($reservation->status), 'icon' => 'help-circle', 'color' => 'gray'];
                @endphp

                <div class="lg:col-span-2 bg-white shadow-xl rounded-2xl overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">
                                    Reservasi ID #{{ $reservation->id }}
                                </h3>
                                <p class="text-gray-500">
                                    Dibuat pada {{ $reservation->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                            <div class="px-4 py-2 rounded-lg flex items-center gap-2
                                        bg-{{ $status['color'] }}-100 text-{{ $status['color'] }}-700 font-semibold">
                                <i data-feather="{{ $status['icon'] }}" class="w-5 h-5"></i>
                                <span>{{ $status['label'] }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 space-y-6">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-2">Detail Penyewa</h4>
                            <div class="text-gray-700 space-y-1">
                                <p><strong>Nama:</strong> {{ $reservation->renter_name }}</p>
                                @if($reservation->user)
                                <p><strong>Email:</strong> {{ $reservation->user->email }}</p>
                                @endif
                            </div>
                        </div>

                        <hr class="border-gray-200">

                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-2">Detail Acara</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="flex items-center gap-3">
                                    <i data-feather="home" class="w-6 h-6 text-orange-500"></i>
                                    <div>
                                        <p class="text-sm text-gray-500">Gedung</p>
                                        <p class="font-semibold">{{ $reservation->hall->name }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <i data-feather="calendar" class="w-6 h-6 text-orange-500"></i>
                                    <div>
                                        <p class="text-sm text-gray-500">Mulai</p>
                                        <p class="font-semibold">{{ $reservation->event_start->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <i data-feather="users" class="w-6 h-6 text-orange-500"></i>
                                    <div>
                                        <p class="text-sm text-gray-500">Kapasitas</p>
                                        <p class="font-semibold">{{ $reservation->hall->capacity }} Orang</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <i data-feather="calendar" class="w-6 h-6 text-orange-500"></i>
                                    <div>
                                        <p class="text-sm text-gray-500">Selesai</p>
                                        <p class="font-semibold">{{ $reservation->event_end->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="lg:col-span-1 space-y-6">
                    
                    <div class="bg-white shadow-xl rounded-2xl p-6 text-center">
                        <p class="text-lg text-gray-600">Total Biaya</p>
                        <p class="text-3xl font-extrabold text-orange-600 my-3">
                            Rp {{ number_format($reservation->total_price, 0, ',', '.') }}
                        </p>
                        
                        
                        {{-- --- Tombol Aksi Dinamis --- --}}
                        
                        @if($reservation->status == 'confirmed' && $reservation->payments)
                            {{-- 1. Menunggu Pembayaran --}}
                            <a href="{{ route('payments.edit', $reservation->payments->id) }}"
                               class="w-full inline-flex items-center justify-center gap-2 mt-4 px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-lg shadow-lg font-semibold transition">
                                <i data-feather="credit-card" class="w-5 h-5"></i>
                                Bayar Sekarang
                            </a>
                        @elseif($reservation->status == 'pending')
                            @hasrole('admin')
                                {{-- 2. Menunggu Konfirmasi (Admin) --}}
                                <form action="{{ route('reservations.konfirmasi', $reservation->id) }}" 
                                      method="POST" onsubmit="return confirm('Konfirmasi reservasi ini?')">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" 
                                            class="w-full inline-flex items-center justify-center gap-2 mt-4 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-lg font-semibold transition">
                                        <i data-feather="check-circle" class="w-5 h-5"></i>
                                        Konfirmasi Reservasi
                                    </button>
                                </form>
                                
                            @else
                                {{-- 3. Menunggu Konfirmasi (Customer) --}}
                                <p class="mt-4 text-gray-500">Menunggu konfirmasi dari Admin.</p>
                            @endhasrole
                            
                        @elseif($reservation->status == 'completed' && $reservation->payments)
                            {{-- 4. Selesai / Lunas --}}
                            <a href="{{ route('payments.receipt', $reservation->payments->id) }}"
                               class="w-full inline-flex items-center justify-center gap-2 mt-4 px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow-lg font-semibold transition">
                                <i data-feather="printer" class="w-5 h-5"></i>
                                Lihat Kwitansi
                            </a>
                        @elseif($reservation->status == 'canceled')
                            {{-- 5. Dibatalkan --}}
                            <p class="mt-4 text-red-600 font-medium">Reservasi ini telah dibatalkan.</p>
                        @endif
                    </div>

                    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                        <div class="p-5 border-b border-gray-200">
                            <h4 class="text-lg font-semibold text-gray-800">Layanan Dipesan</h4>
                        </div>
                        <div class="p-5 space-y-3 divide-y divide-gray-100">
                            @forelse($reservation->services as $service)
                                <div class="flex justify-between items-center pt-2">
                                    <div>
                                        <p class="font-semibold text-gray-700">{{ $service->name }}</p>
                                        <p class="text-sm text-gray-500">
                                            Rp {{ number_format($service->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div class="font-medium text-gray-600">
                                        x {{ $service->pivot->quantity }}
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 italic text-sm text-center py-4">
                                    Tidak ada layanan tambahan yang dipesan.
                                </p>
                            @endforelse
                        </div>
                    </div>
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