<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('📅 Jadwal Gedung') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-xl p-6">
                
                <table class="w-full border-collapse rounded-xl overflow-hidden shadow-sm">
                    <thead>
                        <tr class="bg-gradient-to-r from-orange-200 to-orange-300 text-gray-800">
                            <th class="p-3 text-center text-sm font-semibold border ">Tanggal Sewa</th>
                            <th class="p-3 text-center text-sm font-semibold border">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($dates as $calendar)
                            @php
                                $reservation = $calendar->reservation;
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-3 border text-gray-700 text-center">
                                    @if($reservation)
                                        {{ \Carbon\Carbon::parse($reservation->event_start)->format('d M Y') }} – 
                                        {{ \Carbon\Carbon::parse($reservation->event_end)->format('d M Y') }}
                                    @else
                                        <span class="text-gray-400 italic">Belum ada</span>
                                    @endif
                                </td>
                                <td class="p-3 border text-center font-medium">
                                    @if($calendar->status !== 'Booked')
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold shadow-sm">
                                            Disewa
                                        </span>
                                    @else
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold shadow-sm">
                                            Tersedia
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
