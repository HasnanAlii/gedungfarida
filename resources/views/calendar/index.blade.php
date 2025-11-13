<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __(' Jadwal Gedung') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Grid Responsif untuk Card --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse($dates as $calendar)
                    @php
                        $reservation = $calendar->reservation;
                        $hasReservation = !is_null($reservation);
                    @endphp

                    {{-- Card Jadwal --}}
                    <div class="bg-white shadow-lg rounded-xl overflow-hidden flex flex-col 
                                transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                        
                        <div class="p-5 border-b {{ $hasReservation ? 'border-gray-100' : 'border-red-100 bg-red-50' }}">
                            @if($hasReservation)
                                <p class="text-xs text-gray-500">Penyewa</p>
                                <h3 class="text-xl font-bold text-gray-900 truncate">
                                    {{ $reservation->renter_name }}
                                </h3>
                            @else
                                <h3 class="text-xl font-bold text-red-600 flex items-center gap-2">
                                    <i data-feather="slash" class="w-5 h-5"></i>
                                    Jadwal Diblokir
                                </h3>
                            @endif
                        </div>

                        <div class="p-5 flex-grow space-y-5">
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 uppercase">Tanggal Mulai</label>
                                    <p class="font-semibold text-gray-800">
                                        @if($hasReservation)
                                            {{ \Carbon\Carbon::parse($reservation->event_start)->format('d M Y') }}
                                        @else
                                            <span class="italic text-gray-400">-</span>
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 uppercase">Tanggal Selesai</label>
                                    <p class="font-semibold text-gray-800">
                                        @if($hasReservation)
                                            {{ \Carbon\Carbon::parse($reservation->event_end)->format('d M Y') }}
                                        @else
                                            <span class="italic text-gray-400">-</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div>
                                <label class="text-xs font-semibold text-gray-500 uppercase">Catering</label>
                                <div class="mt-1">
                                    @if($hasReservation && $reservation->services->isNotEmpty())
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700 shadow-sm">
                                        {{ $reservation->services->pluck('name')->implode(', ') }}
                                    </span>
                                    @elseif($hasReservation)
                                    <span class="text-gray-500 italic text-sm">Tidak menggunakan catering</span>
                                    @else
                                    <span class="text-gray-400 italic text-sm">-</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div>
                                <label class="text-xs font-semibold text-gray-500 uppercase">Keterangan</label>
                                <p class="text-gray-700 text-sm">
                                    {{ $calendar->note ?? '-' }}
                                </p>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 mt-auto border-t border-gray-100">
                            <div class="flex justify-end">
                                <form action="{{ route('calendar.destroy', $calendar->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')"
                                      class="inline-block">
                                    @csrf @method('DELETE')
                                    <button typef="submit" 
                                            class="inline-flex items-center gap-1.5 bg-red-100 hover:bg-red-200 text-red-800 px-3 py-1.5 rounded-md text-xs font-medium transition">
                                        <i data-feather="trash-2" class="w-4 h-4"></i>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="md:col-span-2 lg:col-span-3 bg-white shadow-lg rounded-xl p-12 text-center text-gray-500">
                        <i data-feather="calendar" class="w-12 h-12 mx-auto text-gray-400 mb-4"></i>
                        <h3 class="text-xl font-medium text-gray-700">Tidak Ada Jadwal</h3>
                        <p class="mt-2">Belum ada jadwal gedung yang terdaftar atau diblokir.</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination (Jika Anda menambahkannya) --}}
            {{-- <div class="mt-8">
                {{ $dates->links() }}
            </div> --}}

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