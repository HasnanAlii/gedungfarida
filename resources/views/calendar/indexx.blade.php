<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 text-left sm:text-2xl">
            {{ __('Jadwal Gedung') }}
        </h2>
    </x-slot>

    <div class="py-10">
        {{-- PERUBAHAN: Dibuat lebih ramping (max-w-4xl) karena ini hanya daftar --}}
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-xl p-6 md:p-8">
                
                {{-- PERUBAHAN: Header Internal Card --}}
                <div class="text-center mb-8 border-b border-gray-200 pb-6">
                    <i data-feather="calendar" class="w-12 h-12 mx-auto text-orange-500 mb-3"></i>
                    <h2 class="text-2xl font-bold text-gray-800">
                        Kalender Ketidaktersediaan
                    </h2>
                    <p class="text-gray-500 mt-2">Berikut adalah tanggal-tanggal yang sudah dipesan atau diblokir.</p>
                </div>

                {{-- PERUBAHAN: Mengganti <table> dengan <div> list --}}
                <div class="space-y-4">
                   @forelse($dates as $calendar)
                        @php
                            $reservation = $calendar->reservation;
                            $isReservation = !is_null($calendar->reservation_id);
                        @endphp

                        <div class="flex items-center bg-gray-50 border border-gray-200 rounded-lg p-4 shadow-sm">
                            {{-- IKON STATUS --}}
                            <div class="p-3 rounded-lg mr-4
                                {{ $isReservation ? 'bg-orange-100' : 'bg-red-100' }}">
                                <i data-feather="{{ $isReservation ? 'calendar' : 'tool' }}"
                                class="w-6 h-6 {{ $isReservation ? 'text-orange-600' : 'text-red-600' }}"></i>
                            </div>

                            {{-- INFO --}}
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800 text-base md:text-lg">
                                    @if($isReservation)
                                        {{ \Carbon\Carbon::parse($reservation->event_start)->format('d M Y') }}
                                        –
                                        {{ \Carbon\Carbon::parse($reservation->event_end)->format('d M Y') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($calendar->date)->format('d M Y') }}
                                        –
                                        {{ \Carbon\Carbon::parse($calendar->date_end)->format('d M Y') }}
                                    @endif
                                </p>

                                <p class="text-sm font-medium
                                    {{ $isReservation ? 'text-orange-700' : 'text-red-700' }}">
                                    {{ $isReservation ? 'Tidak Tersedia (Sudah Dipesan)' : 'Tidak Tersedia (Maintenance / Diblokir)' }}
                                </p>
                            </div>
                        </div>
                    @empty
                        {{-- PERUBAHAN: Empty state yang lebih positif --}}
                        <div class="flex flex-col items-center justify-center p-10 bg-green-50 rounded-lg border border-dashed border-green-300">
                            <i data-feather="check-circle" class="w-12 h-12 text-green-500 mb-4"></i>
                            <h3 class="text-xl font-semibold text-green-800">Semua Tanggal Tersedia!</h3>
                            <p class="text-gray-600 mt-2">Saat ini belum ada jadwal yang diblokir. Silakan buat reservasi.</p>
                        </div>
                    @endforelse
                </div>

            </div>
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