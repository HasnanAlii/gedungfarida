<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Kwitansi Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-200">
                <div class="p-8 text-gray-900">

                    <!-- Header -->
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold text-orange-600">Kwitansi Pembayaran</h3>
                        <p class="text-gray-500 text-sm mt-1">Gedung Farida</p>
                    </div>

                    <!-- Table -->
                    <table class="w-full text-sm border-t border-b divide-y divide-gray-200 mb-6">
                          <tr>
                            <td class="py-3 font-semibold w-1/3 text-gray-700">ID Reservasi</td>
                            <td class="py-3 text-gray-800">
                                {{ $payment->reservation->id?? '-' }}
                            </td>
                        </tr>
                        <table class="w-full mb-4">
                    <tr>
                        <td class="font-semibold">Nama Penyewa:</td>
                        <td>{{ $payment->reservation->renter_name }}</td>
                    </tr>
                  
                    <tr>
                        <td class="font-semibold">Total Harga:</td>
                        <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>

                    </tr>
                    <tr>
                        <td class="font-semibold">Metode Pembayaran:</td>
                        <td>{{ ucfirst($payment->method) }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Tanggal Pembayaran:</td>
                        <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                    </tr>
                    <tr>
                    <td class="font-semibold">Status:</td>
                    <td> Dibayar dan 
                        @if($payment->status === 'pending')
                            <span >
                                Menunggu Verifikasi Pembayaran
                            </span>
                        @elseif($payment->status === 'paid')
                            <span >
                                Pembayaran Diverifikasi
                            </span>
                        @elseif($payment->status === 'failed')
                            <span >
                                Gagal
                            </span>
                        @else
                            <span >
                                {{ ucfirst($payment->status) }}
                            </span>
                        @endif
                    </td>
                </tr>

                </table>

                    </table>

                    <!-- Footer Buttons -->
                    <div class="flex justify-between mt-6">
                        <a href="{{ route('payments.index') }}" 
                           class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-xl text-sm font-medium shadow transition">
                            ← Kembali
                        </a>
                        <button onclick="window.print()" 
                                class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-xl text-sm font-medium shadow transition">
                            🖨️ Cetak Kwitansi
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
