<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __(' Jadwal Gedung') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full border-collapse text-sm rounded-lg overflow-hidden">
                        <thead>
                            <tr class="bg-gradient-to-r from-orange-200 to-orange-300 text-gray-800">
                                <th class="px-4 py-3 border text-center font-semibold">Penyewa</th>
                                {{-- <th class="px-4 py-3 border text-center font-semibold">Hall</th> --}}
                                <th class="px-4 py-3 border text-center font-semibold">Catering</th>
                                <th class="px-4 py-3 border text-center font-semibold">Keterangan</th>
                                <th class="px-4 py-3 border text-center font-semibold">Tanggal Sewa</th>
                                <th class="px-4 py-3 border text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($dates as $calendar)
                                @php
                                    $reservation = $calendar->reservation;
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <!-- Penyewa -->
                                    <td class="px-4 py-3 border text-gray-700 text-center">
                                        {{ optional($reservation)->renter_name ?? '-' }}
                                    </td>

                                    {{-- <!-- Hall -->
                                    <td class="px-4 py-3 border text-center font-semibold text-gray-800">
                                        {{ $calendar->hall->name ?? '-' }}
                                    </td> --}}
                                    
                                    <!-- Catering -->
                                    <td class="px-4 py-3 border text-center">
                                        @if($reservation && $reservation->services->isNotEmpty())
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700 shadow-sm">
                                            {{ $reservation->services->map(fn($s) => $s->name . ' x ' . $s->pivot->quantity)->implode(', ') }}
                                        </span>
                                        @elseif($reservation)
                                        <span class="text-gray-500 italic">Tidak menggunakan catering</span>
                                        @else
                                        <span class="text-gray-400 italic">Tidak ada reservasi</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Keterangan -->
                                    <td class="px-4 py-3 border text-gray-600 text-center">
                                        {{ $calendar->note ?? '-' }}
                                    </td>
                                    
                                    <!-- Tanggal -->
                                    <td class="px-4 py-3 border text-center text-gray-600">
                                    @if($reservation)
                                        {{ \Carbon\Carbon::parse($reservation->event_start)->format('d M Y') }}
                                            -
                                        {{ \Carbon\Carbon::parse($reservation->event_end)->format('d M Y') }}
                                     @else
                                        <span class="italic text-gray-400">-</span>
                                    @endif
                                    </td>      
                                                                            
                                    <!-- Action -->
                                    <td class="px-4 py-3 border text-center">
                                        <form action="{{ route('calendar.destroy', $calendar->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')"
                                              class="inline-block">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs shadow transition">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            
                            @if($dates->isEmpty())
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-500 italic">
                                        Tidak ada jadwal gedung.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
