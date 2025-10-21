                
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <!-- Judul -->
            <h2 class="text-xl font-semibold text-gray-800 text-left sm:text-2xl">
                {{ __('Reservasi') }}
            </h2>

            <!-- Tombol Menu Reservasi -->
            <a href="{{ route('payments.index') }}" 
            class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold
                    text-xs py-1 px-2 rounded-lg transition w-auto sm:text-sm sm:py-2 sm:px-4">
                Menu Pembayaran
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
  <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-2">
        <h2 class="text-md font-bold text-left sm:text-left sm:text-2xl"> Daftar Reservasi</h2>

        <a href="{{ route('reservations.create') }}" 
        class="inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white px-5 text-sm  sm:text-xl py-2 rounded-lg shadow-md font-semibold transition">
        <!-- Feather icon: plus -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Buat Reservasi
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($reservations as $reservation)
                @php
                    $statusLabels = [
                        'confirmed' => ['label' => '💰 Menunggu Bayar', 'class' => 'bg-yellow-100 text-yellow-800'],
                        'completed' => ['label' => '✅ Sukses', 'class' => 'bg-green-100 text-green-800'],
                        'pending'   => ['label' => '⏳ Menunggu Konfirmasi', 'class' => 'bg-blue-100 text-blue-800'],
                        'canceled'  => ['label' => '❌ Dibatalkan', 'class' => 'bg-red-100 text-red-800'],
                    ];
                    $status = $statusLabels[$reservation->status] ?? ['label' => ucfirst($reservation->status), 'class' => 'bg-gray-100 text-gray-800'];
                @endphp

                <div class="bg-white rounded-xl shadow p-4 flex flex-col justify-between hover:scale-105 transition-transform duration-200">
                    
                    {{-- Ringkas info --}}
                    <div class="text-center mb-2">
                        <h3 class="text-lg font-bold mb-1">Reservasi ID {{ $reservation->id }}</h3>
                        <p class="text-sm text-gray-600 mb-1">
                            {{ $reservation->event_start->format('d M') }} – {{ $reservation->event_end->format('d M') }}
                        </p>
                        <p class="text-sm text-gray-500 truncate mb-1">
                            @if($reservation->services->count())
                            {{ $reservation->services->pluck('name')->implode(', ') }}
                            @else
                            <span class="italic">Tanpa catering</span>
                            @endif
                        </p>
                        <p class="text-sm font-semibold">Rp {{ number_format($reservation->total_price,0,',','.') }}</p>
                    </div>
                    
                    {{-- Status --}}
                    <div class="text-center mb-2">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $status['class'] }}">
                            {{ $status['label'] }}
                        </span>
                    </div>

                    {{-- Toggle Detail --}}
                        @hasrole('admin')
                        <button class="bg-blue-50 text-blue-700 text-sm py-1 px-2 rounded-full hover:bg-blue-100 transition mb-2" 
                        onclick="this.nextElementSibling.classList.toggle('hidden')">
                        Lihat Detail ▼
                         </button>
                

                         <div class="hidden text-sm text-gray-700 mb-2 space-y-1">
                            <p>Penyewa: {{ $reservation->renter_name }}</p>
                            <ul class="list-disc list-inside">
                                @foreach($reservation->services as $service)
                                <li>{{ $service->name }} x {{ $service->pivot->quantity }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endhasrole

                                                {{-- Aksi --}}
                            <div class="flex justify-center gap-2 mt-2 flex-wrap">

                                <!-- Tombol Edit -->
                                <a href="{{ route('reservations.edit', $reservation->id) }}"
                                class="bg-green-100 text-green-800 rounded-full px-2 py-1 text-xs hover:bg-green-200 transition">
                                ✏️
                                </a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus reservasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-100 text-red-800 rounded-full px-2 py-1 text-xs hover:bg-red-200 transition">
                                        🗑️
                                    </button>
                                </form>

                                <!-- Tombol Konfirmasi (Admin Only) -->
                                @if(Auth::user()->hasRole('admin') && $reservation->status === 'pending')
                                    <form action="{{ route('reservations.konfirmasi', $reservation->id) }}" 
                                        method="POST" class="inline-block"
                                        onsubmit="return confirm('Konfirmasi reservasi ini?')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" 
                                                class="bg-green-100 text-green-800 rounded-full px-2 py-1 text-xs hover:bg-green-200 transition">
                                            Konfirmasi
                                        </button>
                                    </form>
                                @endif

                            </div>

                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6 flex justify-center">
            {{ $reservations->links() }}
        </div>
    </div>
</x-app-layout>
