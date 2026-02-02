<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 text-left sm:text-2xl">
            {{ __('Kwitansi Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            
            {{-- PERUBAHAN: Padding p-10 agar lebih lega --}}
            <div id="kwitansi" class="bg-white shadow-2xl rounded-2xl overflow-hidden border border-gray-200 p-8 sm:p-10 text-gray-900">
                
                @php
                    // Definisikan status untuk ikon dan warna
                    $statusInfo = match($payment->status) {
                        'pending' => ['label' => 'Menunggu Verifikasi', 'icon' => 'clock', 'color' => 'yellow'],
                        'paid'    => ['label' => 'Pembayaran Berhasil', 'icon' => 'check-circle', 'color' => 'green'],
                        'failed'  => ['label' => 'Gagal', 'icon' => 'x-circle', 'color' => 'red'],
                        default   => ['label' => ucfirst($payment->status), 'icon' => 'help-circle', 'color' => 'gray'],
                    };
                @endphp

                <div class="flex justify-between items-center pb-6 border-b border-gray-200">
                    <div>
                        <img src="{{ asset('assets/logo.png') }}" alt="Logo Gedung Farida" class="h-10 w-auto">
                        <p class="text-gray-500 text-sm mt-1">Gedung Farida</p>
                    </div>
                    <h3 class="text-2xl font-bold text-orange-600">KWITANSI</h3>
                </div>

                <div class="text-center my-8">
                    
                    <p class="text-lg text-gray-600 mt-6">Total Pembayaran</p>
                    {{-- Total Harga --}}
                    <p class="text-5xl font-extrabold text-orange-600 mt-2">
                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                    </p>
                    {{-- Badge Status --}}
                    <div class="inline-flex items-center gap-2 px-4 mt-5 py-2 rounded-full
                                bg-{{ $statusInfo['color'] }}-100 text-{{ $statusInfo['color'] }}-700 font-semibold">
                        <i data-feather="{{ $statusInfo['icon'] }}" class="w-5 h-5"></i>
                        <span>{{ $statusInfo['label'] }}</span>
                    </div>
                </div>

                <div class="border-t border-b border-gray-200 divide-y divide-gray-200 text-base">
                    <div class="flex justify-between py-3">
                        <span class="text-gray-600">ID Reservasi:</span>
                        <span class_alias="font-semibold">{{ $payment->reservation->id ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-3">
                        <span class="text-gray-600">Nama Penyewa:</span>
                        <span class="font-semibold">{{ $payment->reservation->renter_name }}</span>
                    </div>
                    <div class="flex justify-between py-3">
                        <span class="text-gray-600">Tanggal Sewa:</span>
                        <span class_alias="font-semibold">{{ ($payment->reservation->event_start)->format('d M Y') ?? '-' }} - {{ ($payment->reservation->event_end)->format('d M Y') ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-3">
                        <span class="text-gray-600">Metode Pembayaran:</span>
                        <span class="font-semibold">{{ ucfirst($payment->method) }}</span>
                    </div>
                    <div class="flex justify-between py-3">
                        <span class="text-gray-600">Tanggal Pembayaran:</span>
                        <span class="font-semibold">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</span>
                    </div>
                </div>

                <div class="flex flex-col-reverse sm:flex-row gap-3 justify-between mt-8 print:hidden">
                    {{-- Tombol Kembali (Sekunder) --}}
                    <a href="{{ route('payments.index') }}"
                       class="inline-flex items-center justify-center gap-2 bg-white hover:bg-gray-100 text-gray-700 border border-gray-300 px-5 py-2 rounded-xl text-sm font-medium shadow-sm transition">
                        <i data-feather="arrow-left" class="w-4 h-4"></i> Kembali
                    </a>
                    
                    {{-- Tombol Cetak (Primer) --}}
                    <button onclick="window.print()" 
                            class="inline-flex items-center justify-center gap-2 bg-orange-600 hover:bg-orange-700 text-white px-5 py-2 rounded-xl text-sm font-medium shadow transition">
                        <i data-feather="printer" class="w-4 h-4"></i> Cetak Kwitansi
                    </button>
                </div>

            </div>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #kwitansi, #kwitansi * {
                visibility: visible;
            }
            #kwitansi {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                border: none;
                box-shadow: none;
                padding: 0;
            }
        }
    </style>
    
    {{-- Script untuk menjalankan Feather Icons --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                feather.replace();
            });
        </script>
    @endpush
</x-app-layout>