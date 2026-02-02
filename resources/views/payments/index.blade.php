{{-- resources/views/payments/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 text-left sm:text-2xl">
                {{ __('Pembayaran') }}
            </h2>

            <a href="{{ route('reservations.index') }}" 
            {{-- PERUBAHAN: Tombol diubah menjadi oranye --}}
            class="inline-flex items-center bg-orange-600 hover:bg-orange-700 text-white font-semibold
                    text-xs py-1 px-2 rounded-lg transition w-auto sm:text-sm sm:py-2 sm:px-4">
                Menu Reservasi
                {{-- PERUBAHAN: Ikon diubah ke Feather Icon --}}
                <i data-feather="arrow-right" class="ml-1 h-3 w-3 sm:ml-2 sm:h-5 sm:w-5"></i>
            </a>
        </div>
    </x-slot>

    <div class="container mx-auto py-2">
        <h2 class="text-md font-bold text-left text-gray-800 sm:text-2xl mb-6">Daftar Pembayaran</h2>

        {{-- PERUBAHAN: Grid diubah menjadi 3 kolom dan gap lebih besar --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($payments as $payment)
                @php
                    $statusLabels = [
                        'pending' => ['label' => 'Menunggu Verifikasi', 'class' => 'bg-yellow-100 text-yellow-800', 'border' => 'border-yellow-400'],
                        'paid'    => ['label' => 'Dibayar', 'class' => 'bg-green-100 text-green-800', 'border' => 'border-green-400'],
                        'unpaid'  => ['label' => 'Menunggu Pembayaran', 'class' => 'bg-gray-100 text-gray-700', 'border' => 'border-gray-400'],
                        'failed'  => ['label' => 'Gagal', 'class' => 'bg-red-100 text-red-800', 'border' => 'border-red-400'],
                    ];
                    $status = $statusLabels[$payment->status] ?? ['label' => ucfirst($payment->status), 'class' => 'bg-gray-100 text-gray-800', 'border' => 'border-gray-400'];
                @endphp

                {{-- PERUBAHAN: Desain Kartu yang Diperbarui --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col 
                            transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 
                            border-l-4 {{ $status['border'] }}">
                    
                    <div class="p-4 border-b border-gray-100">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-800">ID Reservasi {{ $payment->reservation->id }}</h3>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $status['class'] }}">
                                {{ $status['label'] }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-4 space-y-3 flex-grow">
                        <div>
                            <p class="text-xs text-gray-500">Jumlah Bayar</p>
                            <p class="text-3xl font-bold text-orange-600">Rp {{ number_format($payment->amount,0,',','.') }}</p>
                        </div>
                        
                        @hasrole('admin')
                        <div class="text-sm text-gray-700 flex items-center gap-2">
                            <i data-feather="user" class="w-4 h-4 text-gray-400"></i>
                            <span>{{ $payment->reservation->renter_name }}</span>
                        </div>
                        @endhasrole
                        
                        <div class="text-sm text-gray-500 flex items-center gap-2">
                            <i data-feather="credit-card" class="w-4 h-4 text-gray-400"></i>
                            <span>Metode: {{ ucfirst($payment->method) }}</span>
                        </div>

                        <div class="text-sm text-gray-500 flex items-center gap-2">
                            <i data-feather="calendar" class="w-4 h-4 text-gray-400"></i>
                            <span>Tgl: {{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') : '-' }}</span>
                        </div>
                    </div>

                    {{-- @hasrole('admin') --}}
                    <div class="p-4 bg-gray-50 border-t border-b border-gray-100">
                        <h4 class="text-xs font-semibold text-gray-500 uppercase mb-2">Bukti Pembayaran</h4>
                        @if($payment->payment_proof)
                            @php
                                $fileExt = pathinfo($payment->payment_proof, PATHINFO_EXTENSION);
                                $fileUrl = asset('storage/payment_proofs/' . $payment->payment_proof);
                            @endphp
                            @if(in_array(strtolower($fileExt), ['jpg','jpeg','png','gif']))
                                <a href="{{ $fileUrl }}" target="_blank">
                                    <img src="{{ $fileUrl }}" alt="Bukti Pembayaran" class="w-full h-32 object-cover rounded-lg border shadow-sm">
                                </a>
                            @else
                                <a href="{{ $fileUrl }}" target="_blank" class="flex items-center gap-2 text-orange-600 hover:underline font-medium">
                                    <i data-feather="file-text" class="w-4 h-4"></i>
                                    <span>Lihat File Bukti</span>
                                </a>
                            @endif
                        @else
                            <span class="text-gray-400 italic text-sm">- Belum ada bukti -</span>
                        @endif
                    </div>
                    {{-- @endhasrole --}}

                    <div class="p-4 bg-gray-50 mt-auto">
                        <div class="flex flex-wrap justify-start gap-2">
                            @if($payment->status == 'unpaid')
                                <a href="{{ route('payments.edit', $payment->id) }}" 
                                   class="flex items-center gap-1.5 bg-green-100 text-green-800 rounded-md px-3 py-1.5 text-xs font-medium hover:bg-green-200 transition">
                                   <i data-feather="credit-card" class="w-4 h-4"></i> Bayar
                                </a>
                            @endif

                            <a href="{{ route('payments.receipt', $payment->id) }}"   
                               class="flex items-center gap-1.5 bg-blue-100 text-blue-800 rounded-md px-3 py-1.5 text-xs font-medium hover:bg-blue-200 transition">
                               <i data-feather="printer" class="w-4 h-4"></i> Cetak Struk
                            </a>

                            @if($payment->status == 'pending')
                                @hasrole('admin')
                                <form action="{{ route('payments.konfirmasi', $payment->id) }}" method="POST" onsubmit="return confirm('Konfirmasi pembayaran ini?')">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="flex items-center gap-1.5 bg-blue-100 text-blue-800 rounded-md px-3 py-1.5 text-xs font-medium hover:bg-blue-200 transition">
                                        <i data-feather="check-circle" class="w-4 h-4"></i> Konfirmasi
                                    </button>
                                </form>
                                @endhasrole
                            @endif

                             @hasrole('admin')
                            <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" onsubmit="return confirm('Hapus pembayaran ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="flex items-center gap-1.5 bg-red-100 text-red-800 rounded-md px-3 py-1.5 text-xs font-medium hover:bg-red-200 transition">
                                    <i data-feather="trash-2" class="w-4 h-4"></i> Hapus
                                </button>
                            </form>
                              @endhasrole

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8 flex justify-center">
            {{ $payments->links() }}
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