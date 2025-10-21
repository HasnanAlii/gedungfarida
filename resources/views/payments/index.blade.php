{{-- resources/views/payments/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <!-- Judul -->
             <h2 class="text-xl font-semibold text-gray-800 text-left sm:text-2xl">
                {{ __('Pembayaran') }}
            </h2>

            <!-- Tombol Menu Reservasi -->
            <a href="{{ route('reservations.index') }}" 
            class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold
                    text-xs py-1 px-2 rounded-lg transition w-auto sm:text-sm sm:py-2 sm:px-4">
                Menu Reservasi
                <!-- Feather icon: arrow-right -->
                <svg xmlns="http://www.w3.org/2000/svg" 
                    class="ml-1 h-3 w-3 sm:ml-2 sm:h-5 sm:w-5" 
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>



    </x-slot>

    <div class="container mx-auto py-2">
        <h2 class="text-md font-bold text-left sm:text-left sm:text-2xl mb-3">Daftar Pembayaran</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($payments as $payment)
                @php
                    $statusLabels = [
                        'pending' => ['label' => 'Menunggu Verifikasi', 'class' => 'bg-yellow-100 text-yellow-800'],
                        'paid'    => ['label' => 'Dibayar', 'class' => 'bg-green-100 text-green-800'],
                        'unpaid'  => ['label' => 'Menunggu Pembayaran', 'class' => 'bg-gray-100 text-gray-700'],
                        'failed'  => ['label' => 'Gagal', 'class' => 'bg-red-100 text-red-800'],
                    ];
                    $status = $statusLabels[$payment->status] ?? ['label' => ucfirst($payment->status), 'class' => 'bg-gray-100 text-gray-800'];
                @endphp

                <div class="bg-white rounded-xl shadow p-4 flex flex-col justify-between hover:scale-105 transition-transform duration-200">
                    
                    {{-- Ringkas info --}}
                    <div class="text-center mb-2">
                        <h3 class="text-lg font-bold mb-1">ID Reservasi {{ $payment->reservation->id }}</h3>
                        @hasrole('admin')
                        <p class="text-sm text-gray-600 mb-1">{{ $payment->reservation->renter_name }}</p>
                        @endhasrole
                        <p class="text-sm text-gray-600 mb-1">{{ ucfirst($payment->method) }}</p>
                        <p class="text-sm text-gray-500">{{ $payment->payment_date }}</p>
                        <p class="text-sm font-semibold mb-1">Rp {{ number_format($payment->amount,0,',','.') }}</p>
                    </div>

                    {{-- Status --}}
                    <div class="text-center mb-2">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $status['class'] }}">
                            {{ $status['label'] }}
                        </span>
                    </div>

                    {{-- Bukti Pembayaran (Admin) --}}
                    @hasrole('admin')
                    <div class="text-center mb-2">
                        @if($payment->payment_proof)
                            @php
                                $fileExt = pathinfo($payment->payment_proof, PATHINFO_EXTENSION);
                                $fileUrl = asset('storage/payment_proofs/' . $payment->payment_proof);
                            @endphp
                            @if(in_array(strtolower($fileExt), ['jpg','jpeg','png','gif']))
                                <a href="{{ $fileUrl }}" target="_blank">
                                    <img src="{{ $fileUrl }}" alt="Bukti Pembayaran" class="w-16 h-16 object-cover rounded border shadow-sm mx-auto">
                                </a>
                            @else
                                <a href="{{ $fileUrl }}" target="_blank" class="text-blue-600 hover:underline font-medium">
                                    📂 Lihat File
                                </a>
                            @endif
                        @else
                            <span class="text-gray-400 italic">-</span>
                        @endif
                    </div>
                    @endhasrole

                    {{-- Aksi --}}
                    <div class="flex justify-center gap-2 mt-2 flex-wrap">
                        @if($payment->status == 'unpaid')
                            <a href="{{ route('payments.edit', $payment->id) }}" 
                               class="bg-green-100 text-green-800 rounded-full px-2 py-1 text-xs hover:bg-green-200 transition">
                               💳 Bayar
                            </a>
                        @endif

                        <a href="{{ route('payments.receipt', $payment->id) }}"   
                           class="bg-blue-100 text-blue-800 rounded-full px-2 py-1 text-xs hover:bg-blue-200 transition">
                           Cetak Struk
                        </a>

                        @if($payment->status == 'pending')
                            @hasrole('admin')
                            <form action="{{ route('payments.konfirmasi', $payment->id) }}" method="POST" onsubmit="return confirm('Konfirmasi pembayaran ini?')">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="bg-blue-100 text-blue-800 rounded-full px-2 py-1 text-xs hover:bg-blue-200 transition">
                                    ✅ Konfirmasi
                                </button>
                            </form>
                            @endhasrole
                        @endif

                        <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" onsubmit="return confirm('Hapus pembayaran ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-100 text-red-800 rounded-full px-2 py-1 text-xs hover:bg-red-200 transition">
                                🗑️ Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6 flex justify-center">
            {{ $payments->links() }}
        </div>
    </div>
</x-app-layout>
