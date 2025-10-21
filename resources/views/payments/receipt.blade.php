<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 text-left sm:text-2xl">
            {{ __('Kwitansi Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div id="kwitansi" class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-200 p-8 text-gray-900">
                
                <!-- Header -->
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-bold text-orange-600">Kwitansi Pembayaran</h3>
                    <p class="text-gray-500 text-sm mt-1">Gedung Farida</p>
                </div>

                <!-- Table -->
                <table class="w-full text-sm border-t border-b divide-y divide-gray-200 mb-6 ">
                    <tr>
                        <td class="py-3 font-semibold w-1/3 text-gray-700">ID Reservasi</td>
                        <td class="py-3 text-gray-800">{{ $payment->reservation->id ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Nama Penyewa:</td>
                        <td>{{ $payment->reservation->renter_name }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Metode Pembayaran:</td>
                        <td>{{ ucfirst($payment->method) }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Total Harga:</td>
                        <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Tanggal Pembayaran:</td>
                        <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Status:</td>
                        <td>
                            @if($payment->status === 'pending')
                                Menunggu Verifikasi Pembayaran
                            @elseif($payment->status === 'paid')
                                Pembayaran Diverifikasi
                            @elseif($payment->status === 'failed')
                                Gagal
                            @else
                                {{ ucfirst($payment->status) }}
                            @endif
                        </td>
                    </tr>
                </table>

                <!-- Footer Buttons -->
                <div class="flex justify-between mt-6 print:hidden">
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

    <!-- Print Styling -->
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
            }
        }
    </style>
</x-app-layout>
