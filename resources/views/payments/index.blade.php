{{-- resources/views/payments/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Pembayaran ') }}
        </h2>
    </x-slot>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-xl p-6">
                
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full border-collapse rounded-lg overflow-hidden text-sm">
                        <thead>
                             <tr class="bg-gradient-to-r from-orange-200 to-orange-300 text-gray-800">
                                <th class="px-4 py-3 border text-center font-semibold">ID Reservasi </th>
                                @hasrole('admin')
                                <th class="px-4 py-3 border text-left font-semibold">Penyewa</th>
                                @endhasrole
                                <th class="px-4 py-3 border text-center font-semibold">Jumlah</th>
                                 @hasrole('admin')
                                <th class="px-4 py-3 border text-center font-semibold">Metode Pembayaran</th>
                                @endhasrole
                                <th class="px-4 py-3 border text-center font-semibold">Tanggal Pembayaran</th>
                                <th class="px-4 py-3 border text-center font-semibold">Status</th>
                                 @hasrole('admin')
                                <th class="px-4 py-3 border text-center font-semibold">Bukti</th>
                                  @endhasrole
                                <th class="px-4 py-3 border text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($payments as $payment)
                                <tr class="hover:bg-gray-50 transition">
                                    <!-- Nomor -->
                                    <td class="px-4 py-3 border text-gray-700 text-center">{{ $payment->reservation->id}}</td>
                                    @hasrole('admin')
                                    <!-- Reservation -->
                                    <td class="px-4 py-3 border text-gray-700">
                                        {{ $payment->reservation->renter_name ?? '-' }}
                                    </td>
                                      @endhasrole

                                    <!-- Amount -->
                                    <td class="px-4 py-3 border text-center font-semibold text-gray-800">
                                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                    </td>

                                    <!-- Method -->
                                    @hasrole('admin')
                                    <td class="px-4 py-3 border text-center text-gray-600">
                                        {{ ucfirst($payment->method) }}
                                    </td>
                                      @endhasrole

                                    <!-- Payment Date -->
                                    <td class="px-4 py-3 border text-center text-gray-600">
                                        {{ $payment->payment_date }}
                                    </td>

                                    <!-- Status -->
                                    @php
                                        $paymentStatus = [
                                            'pending' => ['label' => 'Menunggu Verifikasi Pembayaran ', 'class' => 'bg-yellow-100 text-yellow-700'],
                                            'paid'    => ['label' => 'Dibayar ', 'class' => 'bg-green-100 text-green-700'],
                                            'unpaid'    => ['label' => 'Menunggu Pembayaran ', 'class' => 'bg-green-100 text-green-700'],
                                            'failed'  => ['label' => 'Gagal ', 'class' => 'bg-red-100 text-red-700'],
                                        ];
                                        $status = $paymentStatus[$payment->status] 
                                                ?? ['label' => ucfirst($payment->status), 'class' => 'bg-gray-100 text-gray-700'];
                                    @endphp
                                    <td class="px-4 py-3 border text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold shadow-sm {{ $status['class'] }}">
                                            {{ $status['label'] }}
                                        </span>
                                    </td>

                                    <!-- Bukti Pembayaran -->
                                    @hasrole('admin')
                                    <td class="px-4 py-3 border text-center">
                                        @if($payment->payment_proof)
                                            @php
                                                $fileExt = pathinfo($payment->payment_proof, PATHINFO_EXTENSION);
                                                $fileUrl = asset('storage/payment_proofs/' . $payment->payment_proof);
                                            @endphp
                                            @if(in_array(strtolower($fileExt), ['jpg','jpeg','png','gif']))
                                                <a href="{{ $fileUrl }}" target="_blank">
                                                    <img src="{{ $fileUrl }}" alt="Bukti Pembayaran" class="w-16 h-16 object-cover rounded border shadow-sm">
                                                </a>
                                            @else
                                                <a href="{{ $fileUrl }}" target="_blank" class="text-blue-600 hover:underline font-medium">
                                                    📂 Lihat File
                                                </a>
                                            @endif
                                        @else
                                            <span class="text-gray-400 italic">-</span>
                                        @endif
                                    </td>
                                      @endhasrole

                                    <!-- Actions -->
                                 <td class="px-4 py-3 border text-center">
                                <div class="flex flex-wrap justify-center gap-2">
                                    {{-- Tombol Bayar --}}
                                    @if($payment->status == 'unpaid')
                                        <a href="{{ route('payments.edit', $payment->id) }}" 
                                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs shadow transition">
                                            💳 Bayar
                                        </a>
                                    @endif

                                    {{-- Tombol Cetak Struk --}}
                                    <a href="{{ route('payments.receipt', $payment->id) }}"   
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs shadow transition">
                                        Cetak Struk
                                    </a>

                                    {{-- Tombol Konfirmasi (Admin Only) --}}
                                    @if($payment->status == 'pending')
                                        @hasrole('admin')
                                            <form action="{{ route('payments.konfirmasi', $payment->id) }}" 
                                                method="POST"
                                                onsubmit="return confirm('Konfirmasi pembayaran ini?')">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" 
                                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs shadow transition">
                                                    ✅ Konfirmasi
                                                </button>
                                            </form>
                                        @endhasrole
                                    @endif

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('payments.destroy', $payment->id) }}" 
                                        method="POST"
                                        onsubmit="return confirm('Hapus pembayaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs shadow transition">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-6 text-center text-gray-500 italic">
                                        Tidak ada pembayaran ditemukan.
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
