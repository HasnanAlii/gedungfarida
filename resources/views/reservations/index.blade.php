<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 text-left sm:text-2xl">
                {{ __('Reservasi') }}
            </h2>

            <a href="{{ route('payments.index') }}" 
               class="inline-flex items-center bg-orange-600 hover:bg-orange-700 text-white font-semibold
                      text-xs py-1 px-2 rounded-lg transition w-auto sm:text-sm sm:py-2 sm:px-4">
                Menu Pembayaran
                <i data-feather="arrow-right" class="ml-1 h-3 w-3 sm:ml-2 sm:h-5 sm:w-5"></i>
            </a>
        </div>
    </x-slot>

<div class="container mx-auto py-2">

        {{-- Header Halaman --}}
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-2">
        <h2 class="text-md font-bold text-left text-gray-800 sm:text-2xl"> Daftar Reservasi</h2>

        <a href="{{ route('reservations.create') }}" 
            class="inline-flex items-center bg-orange-500 hover:bg-orange-700 text-white px-5 text-sm sm:text-base py-2 rounded-lg shadow-md font-semibold transition">
            <i data-feather="plus" class="h-5 w-5 mr-2"></i>
            Buat Reservasi
        </a>
    </div>

    {{-- Grid sama seperti halaman pembayaran --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach ($reservations as $reservation)
            @php
                $statusMap = [
                    'confirmed' => ['label' => 'Menunggu Pembayaran', 'class' => 'bg-yellow-100 text-yellow-800', 'border' => 'border-yellow-400'],
                    'completed' => ['label' => 'Sukses', 'class' => 'bg-green-100 text-green-800', 'border' => 'border-green-400'],
                    'pending'   => ['label' => 'Menunggu Konfirmasi', 'class' => 'bg-blue-100 text-blue-800', 'border' => 'border-blue-400'],
                    'canceled'  => ['label' => 'Dibatalkan', 'class' => 'bg-red-100 text-red-800', 'border' => 'border-red-400'],
                ];
                $status = $statusMap[$reservation->status] 
                          ?? ['label' => ucfirst($reservation->status), 'class' => 'bg-gray-100 text-gray-800', 'border' => 'border-gray-400'];
            @endphp

            {{-- CARD KONSISTEN DENGAN PAYMENT --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col 
                        transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 
                        border-l-4 {{ $status['border'] }}">

                {{-- Header --}}
                <div class="p-4 border-b border-gray-100">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800">Reservasi ID {{ $reservation->id }}</h3>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $status['class'] }}">
                            {{ $status['label'] }}
                        </span>
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-4 space-y-3 flex-grow">
                    <div>
                        <p class="text-xs text-gray-500">Total Biaya</p>
                        <p class="text-3xl font-bold text-orange-600">Rp {{ number_format($reservation->total_price,0,',','.') }}</p>
                    </div>

                    <div class="text-sm text-gray-700 flex items-center gap-2">
                        <i data-feather="calendar" class="w-4 h-4 text-gray-400"></i>
                        <span>
                            {{ $reservation->event_start->format('d M') }} –
                            {{ $reservation->event_end->format('d M Y') }}
                        </span>
                    </div>

                    <div class="text-sm text-gray-700 flex items-center gap-2">
                        <i data-feather="coffee" class="w-4 h-4 text-gray-400"></i>
                        <span>
                            @if($reservation->services->count())
                                {{ $reservation->services->pluck('name')->implode(', ') }}
                            @else
                                <span class="italic text-gray-400">Tanpa catering</span>
                            @endif
                        </span>
                    </div>

                    @hasrole('admin')
                    <div class="text-sm text-gray-700">
                        <p class="font-semibold text-gray-600 mb-1">Penyewa:</p>
                        <p>{{ $reservation->renter_name }}</p>
                    </div>
                    @endhasrole
                </div>

                {{-- Actions --}}
                <div class="p-4 bg-gray-50 mt-auto">
                    <div class="flex flex-wrap justify-start gap-2">

                        <a href="{{ route('reservations.show', $reservation->id) }}"
                          class="flex items-center gap-1.5 bg-blue-100 text-blue-800 rounded-md px-3 py-1.5 text-xs font-medium hover:bg-blue-200 transition">
                          <i data-feather="eye" class="w-4 h-4"></i> Detail
                       </a>
                        <a href="{{ route('reservations.edit', $reservation->id) }}"
                           class="flex items-center gap-1.5 bg-green-100 text-green-800 rounded-md px-3 py-1.5 text-xs font-medium hover:bg-green-200 transition">
                           <i data-feather="edit-2" class="w-4 h-4"></i> Edit
                        </a>


                        <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST"
                              onsubmit="return confirm('Hapus reservasi ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" 
                                    class="flex items-center gap-1.5 bg-red-100 text-red-800 rounded-md px-3 py-1.5 text-xs font-medium hover:bg-red-200 transition">
                                <i data-feather="trash-2" class="w-4 h-4"></i> Hapus
                            </button>
                        </form>
                        {{-- @hasrole('admin') --}}
                        @if(Auth::user()->hasRole('admin') && $reservation->status === 'pending')
                        <form action="{{ route('reservations.konfirmasi', $reservation->id) }}" 
                            method="POST" onsubmit="return confirm('Konfirmasi reservasi ini?')">
                            @csrf @method('PUT')
                            <button type="submit" 
                                    class="flex items-center gap-1.5 bg-blue-100 text-blue-800 rounded-md px-3 py-1.5 text-xs font-medium hover:bg-blue-200 transition">
                                <i data-feather="check-circle" class="w-4 h-4"></i> Konfirmasi
                            </button>
                        </form>
                        @endif
                        {{-- @endhasrole --}}

                    </div>
                </div>

            </div>
        @endforeach
    </div>

    <div class="mt-8 flex justify-center">
        {{ $reservations->links() }}
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/feather-icons"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => feather.replace());
</script>
@endpush

</x-app-layout>
